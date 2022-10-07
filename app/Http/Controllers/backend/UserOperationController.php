<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Game;
use App\Models\User;
use App\Notifications\CommentDeleted;
use App\Notifications\CommentEdited;
use App\Notifications\CommentVerified;
use App\Notifications\SubCommentDeleted;
use App\Notifications\SubCommentVerified;
use App\Notifications\UserBanned;
use App\Notifications\UserBanRemoved;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class UserOperationController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $per_page     = $request->input('per_page', 10);
        $quick_search = $request->input('quick_search');

        $sort_by  = $request->get('sort_by', 'id');
        $sort_dir = $request->get('sort_dir', 'desc');

        if ($sort_dir == 'desc') {
            $sort_dir = 'asc';
        } else {
            $sort_dir = 'desc';
        }

        $users = User::where('name', 'LIKE', '%' . $quick_search . '%')
                     ->orWhere('surname', 'LIKE', '%' . $quick_search . '%')
                     ->orWhere('email', 'LIKE', '%' . $quick_search . '%')
                     ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        return view('backend.user-operations.index', compact('per_page', 'quick_search', 'sort_by', 'sort_dir', 'users'));
    }

    public function banUser(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if ($request->isMethod('post')) {
            $user_data = [
                'ban_reason' => strip_tags(trim($request->input('ban_reason')))
            ];

            $user_rules = [
                'ban_reason' => 'required|min:30'
            ];

            $validate_user_ban = Validator::make($user_data, $user_rules);

            if ($validate_user_ban->fails()) {
                return redirect()->route('admin.ban-user', $user_id)
                                 ->withErrors($validate_user_ban)
                                 ->withInput();
            }

            $user->update([
                'is_banned'  => 1,
                'ban_reason' => $request->input('ban_reason'),
                'banned_by'  => Auth::user()->name . ' ' . Auth::user()->surname,
                'banned_at'  => Carbon::now()
            ]);

            if ($user->comments) {
                foreach ($user->comments as $comment) {
                    if ($comment->commentable_type == 'App\Models\Game') {
                        $content = Game::findOrFail($comment->commentable_id);
                    } else {
                        $content = Article::findOrFail($comment->commentable_id);
                    }

                    if ($comment->replies) {
                        foreach ($comment->replies as $reply) {
                            $reply->update(['is_verified' => 0]);
                            $reply->user->notify(new CommentVerified($reply, $content));
                        }
                    }

                    $comment->update(['is_verified' => 0]);
                }
            }

            $user->notify(new UserBanned($user));

            return redirect()->route('admin.user-operations')->with('message', 'Kullanıcı Kalıcı Olarak Yasaklandı.');
        }
        return view('backend.user-operations.ban_user', compact('user'));
    }

    public function removeBan(Request $request)
    {
        if ($request->ajax()) {
            $user = User::find($request->post('user_id'));
            $user->update([
                'is_banned'  => 0,
                'ban_reason' => null,
                'banned_by'  => null,
                'banned_at'  => null
            ]);
            $user->notify(new UserBanRemoved($user));
            return true;
        }
        return false;
    }

    public function userComments(Request $request, $user_id)
    {
        $per_page     = $request->input('per_page', 10);
        $quick_search = $request->input('quick_search');

        $sort_by  = $request->get('sort_by', 'id');
        $sort_dir = $request->get('sort_dir', 'desc');

        if ($sort_dir == 'desc') {
            $sort_dir = 'asc';
        } else {
            $sort_dir = 'desc';
        }

        $user     = User::with('comments')->findOrFail($user_id);
        $comments = $user->comments()->where('body', 'LIKE', '%' . $quick_search . '%')
                         ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        return view('backend.user-operations.user_comments', compact('user', 'comments', 'per_page', 'quick_search', 'sort_by', 'sort_dir'));
    }

    public function editUserComment(Request $request, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        if ($request->isMethod('post')) {
            $comment_fields = [
                'is_verified'
            ];

            $comment_rules = [
                'body'        => 'required|min:30',
                'is_verified' => 'required'
            ];

            foreach ($comment_fields as $field) {
                $comment_data[$field] = $request->input($field);
            }

            $comment_data['body'] = strip_tags(trim($request->input('body')));

            $validate_comment = Validator::make($comment_data, $comment_rules);

            if ($validate_comment->fails()) {
                return redirect()->route('admin.edit-user-comment', $comment_id)
                                 ->withErrors($validate_comment)
                                 ->withInput();
            }

            $comment_data['body'] = $request->input('body');

            $comment_old_body   = $comment->body;
            $comment_old_status = $comment->is_verified;

            $comment->update($comment_data);

            if ($comment->commentable_type == 'App\Models\Game') {
                $content = Game::findOrFail($comment->commentable_id);
            } else {
                $content = Article::findOrFail($comment->commentable_id);
            }

            if ($comment->is_verified != $comment_old_status) {
                $comment->user->notify(new CommentVerified($comment, $content));
            }

            $comment->user->notify(new CommentEdited($comment, $content, $comment_old_body));

            return redirect()->route('admin.user-comments', $comment->user_id)->with('message', 'Kullanıcı Yorumu Başarıyla Düzenlendi.');
        }

        return view('backend.user-operations.edit_user_comment', compact('comment'));
    }

    public function verifyUserComment(Request $request)
    {
        if ($request->ajax()) {
            $comment              = Comment::findOrFail($request->id);

            if ($comment->user->is_banned == 0) {
                $comment->is_verified = $request->state == 'true' ? 1 : 0;
                $comment->save();

                if ($comment->commentable_type == 'App\Models\Game') {
                    $content = Game::findOrFail($comment->commentable_id);
                } else {
                    $content = Article::findOrFail($comment->commentable_id);
                }

                if ($comment->parent) {
                    $parent_comment_user = $comment->parent->user;
                    $parent_comment_user->notify(new SubCommentVerified($comment, $content));
                }

                $comment->user->notify(new CommentVerified($comment, $content));
                return true;
            } else {
                return [
                    'error' => true
                ];
            }
        }
        return false;
    }

    public function deleteUserComment(Request $request)
    {
        if ($request->ajax()) {
            $comment = Comment::findOrFail($request->id);
            $user    = $comment->user;

            if ($comment->commentable_type == 'App\Models\Game') {
                $content = Game::findOrFail($comment->commentable_id);
            } else {
                $content = Article::findOrFail($comment->commentable_id);
            }

            if ($comment->parent) {
                $parent_comment_user = $comment->parent->user;
                $parent_comment_user->notify(new SubCommentDeleted($comment, $content));
            }

            $user->notify(new CommentDeleted($comment, $content));

            $comment->delete();
            return true;
        }
        return false;
    }
}
