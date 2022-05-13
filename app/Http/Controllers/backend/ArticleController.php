<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ArticleController extends Controller
{
    public function __construct()
    {
        view()->share('settings', Settings::find(1));
    }

    public function index()
    {
        $articles = Articles::get();
        return view('backend.articles.index', compact('articles'));
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

        $article            = new Articles();
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
        $article = Articles::findOrFail($id);
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

        $article          = Articles::findOrFail($id);
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
        $article = Articles::findOrFail($id);
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


}
