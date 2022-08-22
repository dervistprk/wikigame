<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class DeveloperController extends Controller
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

        $developers = Developer::with('games')->where('name', 'LIKE', '%' . $quick_search . '%')
                               ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        if ($developers->count() > 0) {
            foreach ($developers as $developer) {
                $developer->games_count = $developer->games->count();
                $developer->save();
            }
        }
        return view('backend.developers.index', compact('developers', 'per_page', 'quick_search', 'sort_by', 'sort_dir'));
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

        $developer              = new Developer();
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
        $developer = Developer::findOrFail($id);
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

        $developer              = Developer::findOrFail($id);
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
        $developer = Developer::findOrFail($id);
        $path      = public_path('uploads/developers/') . Str::slug($developer->name);

        if ($developer->games->count() > 0)  {
            foreach ($developer->games as $d_game) {
                GameController::destroy($d_game->id);
            }
        }

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

    public function switchStatus(Request $request)
    {
        $developer         = Developer::findOrFail($request->id);
        $developer->status = $request->state == 'true' ? 1 : 0;
        $developer->save();

        $dev_games = $developer->games;

        if ($dev_games->count() > 0) {
            if ($developer->status == 0) {
                foreach ($dev_games as $d_game) {
                    $d_game->update(['status' => 0]);
                }
            }
        }
        return true;
    }
}
