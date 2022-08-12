<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Publishers;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class PublisherController extends Controller
{
    public function __construct()
    {
        view()->share('settings', Settings::find(1));
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

        $publishers = Publishers::where('name', 'LIKE', '%' . $quick_search . '%')
                                ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        foreach ($publishers as $publisher) {
            $publisher->games_count = $publisher->games->count();
            $publisher->save();
        }

        return view('backend.publishers.index', compact('publishers', 'per_page', 'quick_search', 'sort_dir', 'sort_by'));
    }

    public function create()
    {
        return view('backend.publishers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                               'name'        => 'required',
                               'description' => 'required|min:15',
                               'status'      => 'required',
                               'image'       => 'required|image|mimes:jpg,jpeg,png,svg|max:2048'
                           ]);

        $publisher              = new Publishers();
        $publisher->name        = $request->name;
        $publisher->slug        = Str::slug($request->name);
        $publisher->description = $request->description;
        $publisher->status      = $request->status;

        $path = public_path('uploads/publishers/') . Str::slug($request->name);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $image        = $request->file('image');
        $imageName    = Str::slug($request->name) . '.' . $request->image->getClientOriginalExtension();
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(300, 220);
        $image_resize->save($path . '/' . $imageName);
        $publisher->image = '/uploads/publishers/' . Str::slug($request->name) . '/' . $imageName;

        $publisher->save();

        return redirect()->route('admin.publishers')->with('message', 'Dağıtıcı Başarıyla Oluşturuldu.');
    }

    public function edit($id)
    {
        $publisher = Publishers::findOrFail($id);
        return view('backend.publishers.edit', compact('publisher'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
                               'name'        => 'required',
                               'description' => 'required|min:15',
                               'status'      => 'required',
                               'image'       => 'image|mimes:jpg,jpeg,png,webp|max:2048'
                           ]);

        $publisher              = Publishers::findOrFail($id);
        $publisher->name        = $request->name;
        $publisher->slug        = Str::slug($request->name);
        $publisher->description = $request->description;
        $publisher->status      = $request->status;

        $path = public_path('uploads/publishers/') . Str::slug($request->name);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->hasFile('image')) {
            $image        = $request->file('image');
            $imageName    = Str::slug($request->name) . '.' . $request->image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(300, 220);
            $image_resize->save($path . '/' . $imageName);
            $publisher->image = '/uploads/publishers/' . Str::slug($request->name) . '/' . $imageName;
        }

        $publisher->save();

        return redirect()->route('admin.publishers')->with('message', 'Dağıtıcı Bilgileri Başarıyla Güncellendi.');
    }

    public function destroy($id)
    {
        $publisher = Publishers::findOrFail($id);

        $path = public_path('uploads/publishers/') . Str::slug($publisher->name);

        if (File::exists(public_path($publisher->image))) {
            File::delete(public_path($publisher->image));
        }

        if (File::exists($path) && is_dir($path)) {
            array_map('unlink', glob("$path/*.*"));
            rmdir(public_path('uploads/publishers/') . Str::slug($publisher->name));
        }

        $publisher->delete();

        return redirect()->route('admin.publishers')->with('message', 'Dağıtıcı Başarıyla Silindi.');
    }

    public function switchStatus(Request $request)
    {
        $publisher         = Publishers::findOrFail($request->id);
        $publisher->status = $request->state == 'true' ? 1 : 0;
        $publisher->save();
        return true;
    }
}
