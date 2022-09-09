<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserOperationController extends Controller
{
    public function __construct() {}

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

    public function banUser(Request $request)
    {
        $user = User::find($request->input('user_id'));

        $data = [
            'ban_reason' => strip_tags(trim($request->input('ban_reason')))
        ];

        $rules = [
            'ban_reason' => 'required|min:30'
        ];

        $validate_user_ban = \Validator::make($data, $rules);

        if ($validate_user_ban->fails()) {
            return redirect()->route('admin.user-operations')
                             ->withErrors($validate_user_ban)
                             ->withInput();
        }

        $user->update([
            'is_banned'  => 1,
            'ban_reason' => $request->input('ban_reason'),
            'banned_by'  => \Auth::user()->name . ' ' . \Auth::user()->surname,
            'banned_at'  => \Carbon\Carbon::now()
        ]);
        return redirect()->route('admin.user-operations')->with('message', 'Kullanıcı Kalıcı Olarak Yasaklandı.');
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
            return true;
        }
        return false;
    }
}
