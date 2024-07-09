<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;

class ArticleController extends Controller
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

        $articles = Article::where('title', 'LIKE', '%' . $quick_search . '%')
                           ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        return view('backend.articles.index', compact('articles', 'per_page', 'quick_search', 'sort_by', 'sort_dir'));
    }

    public function create()
    {
        return view('backend.articles.create');
    }

    public function store(Request $request)
    {
        $article_fields = [
            'title',
            'sub_title',
            'status'
        ];

        $article_rules = [
            'title'     => 'required|min:5',
            'sub_title' => 'required|min:5',
            'writing'   => 'required|min:15',
            'status'    => 'required',
        ];

        foreach ($article_fields as $field) {
            $article_data[$field] = $request->input($field);
        }

        $article_data['writing'] = strip_tags(trim($request->input('writing')));
        $article_data['slug']    = Str::slug($request->input('title'));

        $validate_article = Validator::make($article_data, $article_rules);

        if ($validate_article->fails()) {
            return redirect()->route('admin.create-article')
                             ->withErrors($validate_article)
                             ->withInput();
        }

        $article_data['writing'] = $request->input('writing');

        $image_rules = [
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:3092'
        ];

        $validate_image = Validator::make($request->file(), $image_rules);

        if ($validate_image->fails()) {
            return redirect()->route('admin.create-article')
                             ->withErrors($validate_image)
                             ->withInput();
        }

        $path = public_path('uploads/articles/') . Str::slug($request->input('title'));

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true);
        }

        $image     = $request->file('image');
        $imageName = Str::slug($request->input('title')) . '.' . $image->getClientOriginalExtension();
        Image::make($image->getRealPath())->resize(1920, 1080)->save($path . '/' . $imageName);
        $article_data['image'] = '/uploads/articles/' . Str::slug($request->input('title')) . '/' . $imageName;

        Article::create($article_data);

        return redirect()->route('admin.articles')->with('message', 'Makale Başarıyla Oluşturuldu');
    }

    public function edit($article_id)
    {
        $article = Article::findOrFail($article_id);
        return view('backend.articles.edit', compact('article'));
    }

    public function update(Request $request, $article_id)
    {
        $article_fields = [
            'title',
            'sub_title',
            'status'
        ];

        $article_rules = [
            'title'     => 'required|min:5',
            'sub_title' => 'required|min:5',
            'writing'   => 'required|min:15',
            'status'    => 'required',
        ];

        foreach ($article_fields as $field) {
            $article_data[$field] = $request->input($field);
        }

        $article_data['writing'] = strip_tags(trim($request->input('writing')));
        $article_data['slug']    = Str::slug($request->input('title'));

        $validate_article = Validator::make($article_data, $article_rules);

        if ($validate_article->fails()) {
            return redirect()->route('admin.edit-article', $article_id)
                             ->withErrors($validate_article)
                             ->withInput();
        }

        $article_data['writing'] = $request->input('writing');

        $image_rules = [
            'image' => 'image|mimes:jpg,jpeg,png,webp|max:3092'
        ];

        $validate_image = Validator::make($request->file(), $image_rules);

        if ($validate_image->fails()) {
            return redirect()->route('admin.create-article')
                             ->withErrors($validate_image)
                             ->withInput();
        }

        $article = Article::findOrFail($article_id);
        $path    = public_path('uploads/articles/') . Str::slug($request->input('title'));

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true);

            $old_path = public_path('uploads/articles/') . $article->slug;

            if (File::exists($old_path) && File::isDirectory($old_path)) {
                File::copyDirectory($old_path, $path);
            }

            if ($article->image) {
                $file_extension        = '.' . File::extension($article->image);
                $imageName             = Str::slug($request->input('title')) . $file_extension;
                $article_data['image'] = '/uploads/articles/' . Str::slug($request->input('title')) . '/' . $imageName;
                if (File::exists($old_path) && File::isDirectory($old_path) && File::exists(
                        $old_path . '/' . $article->slug . $file_extension
                    )) {
                    rename(
                        $old_path . '/' . $article->slug . $file_extension,
                        $path . '/' . Str::slug($request->input('title')) . $file_extension
                    );
                    File::delete($path . '/' . $article->slug . $file_extension);
                }
            }

            if (File::exists($old_path) && File::isDirectory($old_path)) {
                File::deleteDirectory($old_path);
            }
        }

        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = Str::slug($request->input('title')) . '.' . $image->getClientOriginalExtension();
            Image::make($image->getRealPath())->resize(1920, 1080)->save($path . '/' . $imageName);
            $article_data['image'] = '/uploads/articles/' . Str::slug($request->input('title')) . '/' . $imageName;
        }

        $article->update($article_data);

        return redirect()->route('admin.articles')->with('message', 'Makale Başarıyla Güncellendi.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $path    = public_path('uploads/articles/') . Str::slug($article->title);

        if (File::exists(public_path($article->image))) {
            File::delete(public_path($article->image));
        }

        if (File::exists($path) && File::isDirectory($path)) {
            File::deleteDirectory($path);
        }

        $article->delete();
        return redirect()->route('admin.articles')->with('message', 'Makale Başarıyla Silindi.');
    }

    public function switchStatus(Request $request)
    {
        if ($request->ajax()) {
            $article         = Article::findOrFail($request->input('id'));
            $article->status = $request->input('state') == 'true' ? 1 : 0;
            $article->save();
            return true;
        }
        return false;
    }

    public function multipleDestroy(Request $request)
    {
        if ($request->ajax()) {
            $articles = Article::whereIn('id', $request->post('ids'))->get();

            foreach ($articles as $article) {
                $path = public_path('uploads/articles/') . Str::slug($article->name);

                if (File::exists(public_path($article->image))) {
                    File::delete(public_path($article->image));
                }

                if (File::exists($path) && File::isDirectory($path)) {
                    File::deleteDirectory($path);
                }

                $article->delete();
            }
            return true;
        }
        return false;
    }
}
