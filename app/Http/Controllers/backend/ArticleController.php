<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ArticleController extends Controller
{
    public function __construct()
    {
        view()->share('settings', Setting::find(1));
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
        $request->validate([
                               'title'     => 'required|min:5',
                               'sub_title' => 'required|min:5',
                               'writing'   => 'required|min:10',
                               'image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
                           ]);

        $article            = new Article();
        $article->title     = $request->title;
        $article->slug      = Str::slug($request->title);
        $article->sub_title = $request->sub_title;
        $article->writing   = $request->writing;
        $article->status    = $request->status;

        $path = public_path('uploads/articles/') . Str::slug($request->title);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $image        = $request->file('image');
        $imageName    = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(1920, 1080);
        $image_resize->save($path . '/' . $imageName);
        $article->image = '/uploads/articles/' . Str::slug($request->title) . '/' . $imageName;

        $article->save();

        return redirect()->route('admin.articles')->with('message', 'Makale Başarıyla Oluşturuldu');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('backend.articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
                               'title'   => 'required',
                               'writing' => 'required|min:15',
                               'status'  => 'required',
                               'image'   => 'image|mimes:jpg,jpeg,png,svg|max:2048'
                           ]);

        $article          = Article::findOrFail($id);
        $article->title   = $request->title;
        $article->slug    = Str::slug($request->title);
        $article->writing = $request->writing;
        $article->status  = $request->status;

        $path = public_path('uploads/articles/') . Str::slug($request->title);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->hasFile('image')) {
            $image        = $request->file('image');
            $imageName    = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $article->image = '/uploads/articles/' . Str::slug($request->title) . '/' . $imageName;
        }

        $article->save();

        return redirect()->route('admin.articles')->with('message', 'Makale Başarıyla Güncellendi.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $path    = public_path('uploads/articles/') . Str::slug($article->title);

        if (File::exists(public_path($article->image))) {
            File::delete(public_path($article->image));
        }

        if (File::exists($path) && is_dir($path)) {
            array_map('unlink', glob("$path/*.*"));
            rmdir($path);
        }

        $article->delete();
        return redirect()->route('admin.articles')->with('message', 'Makale Başarıyla Silindi.');
    }

    public function switchStatus(Request $request)
    {
        $article         = Article::findOrFail($request->id);
        $article->status = $request->state == 'true' ? 1 : 0;
        $article->save();
        return true;
    }
}
