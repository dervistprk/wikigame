<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Developers;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class DeveloperController extends Controller
{
    public function __construct()
    {
        view()->share('settings', Settings::find(1));
    }

    public function index()
    {
        $developers = Developers::orderBy('name', 'asc')->get();
        foreach ($developers as $developer) {
            $developer->games_count = $developer->games->count();
            $developer->save();
        }

        return view('backend.developers.index', compact('developers'));
    }

    public function create()
    {
        return view('backend.developers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                               'name'        => 'required',
                               'description' => 'required|min:15',
                               'status'      => 'required',
                               'image'       => 'required|image|mimes:jpg,jpeg,png,svg|max:2048'
                           ]);

        $developer              = new Developers();
        $developer->name        = $request->name;
        $developer->slug        = Str::slug($request->name);
        $developer->description = $request->description;
        $developer->status      = $request->status;

        $path = public_path('uploads/developers/') . Str::slug($request->name);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $image        = $request->file('image');
        $imageName    = Str::slug($request->name) . '.' . $request->image->getClientOriginalExtension();
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(300, 220);
        $image_resize->save($path . '/' . $imageName);
        $developer->image = '/uploads/developers/' . Str::slug($request->name) . '/' . $imageName;

        $developer->save();

        return redirect()->route('admin.developers')->with('message', 'Geliştirici Başarıyla Oluşturuldu.');
    }

    public function edit($id)
    {
        $developer = Developers::findOrFail($id);
        return view('backend.developers.edit', compact('developer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
                               'name'        => 'required',
                               'description' => 'required|min:15',
                               'status'      => 'required',
                               'image'       => 'image|mimes:jpg,jpeg,png,svg|max:2048'
                           ]);

        $developer              = Developers::findOrFail($id);
        $developer->name        = $request->name;
        $developer->slug        = Str::slug($request->name);
        $developer->description = $request->description;
        $developer->status      = $request->status;

        $path = public_path('uploads/developers/') . Str::slug($request->name);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->hasFile('image')) {
            $image        = $request->file('image');
            $imageName    = Str::slug($request->name) . '.' . $request->image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(300, 220);
            $image_resize->save($path . '/' . $imageName);
            $developer->image = '/uploads/developers/' . Str::slug($request->name) . '/' . $imageName;
        }

        $developer->save();

        return redirect()->route('admin.developers')->with('message', 'Geliştirici Bilgileri Başarıyla Güncellendi.');
    }

    public function destroy($id)
    {
        $developer = Developers::findOrFail($id);
        $path      = public_path('uploads/developers/') . Str::slug($developer->name);

        if (File::exists(public_path($developer->image))) {
            File::delete(public_path($developer->image));
        }

        if (File::exists($path) && is_dir($path)) {
            array_map('unlink', glob("$path/*.*"));
            rmdir($path);
        }

        $developer->delete();
        return redirect()->route('admin.developers')->with('message', 'Geliştirici Başarıyla Silindi.');
    }
}
