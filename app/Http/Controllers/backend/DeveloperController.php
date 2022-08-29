<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;

class DeveloperController extends Controller
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

        $developers = Developer::with('games')->where('name', 'LIKE', '%' . $quick_search . '%')
                               ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        return view('backend.developers.index', compact('developers', 'per_page', 'quick_search', 'sort_by', 'sort_dir'));
    }

    public function create()
    {
        return view('backend.developers.create');
    }

    public function store(Request $request)
    {
        $developer_fields = [
            'name',
            'description',
            'status',
            'image'
        ];

        $developer_rules = [
            'name'        => 'required',
            'description' => 'required|min:15',
            'status'      => 'required',
        ];

        foreach ($developer_fields as $field) {
            $developer_data[$field] = $request->input($field);
        }

        $developer_data['slug'] = Str::slug($request->input('name'));

        $validate_developer = Validator::make($developer_data, $developer_rules);

        if ($validate_developer->fails()) {
            return redirect()->route('admin.create-developer')
                             ->withErrors($validate_developer)
                             ->withInput();
        }

        $image_rules = [
            'image' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048'
        ];

        $validate_image = Validator::make($request->file(), $image_rules);

        if ($validate_image->fails()) {
            return redirect()->route('admin.create-developer')
                             ->withErrors($validate_image)
                             ->withInput();
        }

        $path = public_path('uploads/developers/') . Str::slug($request->input('name'));

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $image     = $request->file('image');
        $imageName = Str::slug($request->input('name')) . '.' . $request->file('image')->getClientOriginalExtension();
        Image::make($image->getRealPath())->resize(300, 220)->save($path . '/' . $imageName);
        $developer_data['image'] = '/uploads/developers/' . Str::slug($request->input('name')) . '/' . $imageName;

        Developer::create($developer_data);

        return redirect()->route('admin.developers')->with('message', 'Geliştirici Başarıyla Oluşturuldu.');
    }

    public function edit($developer_id)
    {
        $developer = Developer::findOrFail($developer_id);
        return view('backend.developers.edit', compact('developer'));
    }

    public function update(Request $request, $developer_id)
    {
        $developer = Developer::findOrFail($developer_id);

        $developer_fields = [
            'name',
            'description',
            'status',
        ];

        $developer_rules = [
            'name'        => 'required',
            'description' => 'required|min:15',
            'status'      => 'required',
        ];

        foreach ($developer_fields as $field) {
            $developer_data[$field] = $request->input($field);
        }

        $developer_data['slug'] = Str::slug($request->input('name'));

        $validate_developer = Validator::make($developer_data, $developer_rules);

        if ($validate_developer->fails()) {
            return redirect()->route('admin.edit-developer', $developer_id)
                             ->withErrors($validate_developer)
                             ->withInput();
        }

        $image_rules = [
            'image' => 'image|mimes:jpg,jpeg,png,svg|max:2048'
        ];

        $validate_image = Validator::make($request->file(), $image_rules);

        if ($validate_image->fails()) {
            return redirect()->route('admin.edit-developer', $developer_id)
                             ->withErrors($validate_image)
                             ->withInput();
        }

        $path = public_path('uploads/developers/') . Str::slug($request->input('name'));

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = Str::slug($request->input('name')) . '.' . $request->file('image')->getClientOriginalExtension();
            Image::make($image->getRealPath())->resize(300, 220)->save($path . '/' . $imageName);
            $developer_data['image'] = '/uploads/developers/' . Str::slug($request->input('name')) . '/' . $imageName;
        }

        $developer->update($developer_data);

        return redirect()->route('admin.developers')->with('message', 'Geliştirici Bilgileri Başarıyla Güncellendi.');
    }

    public function destroy($id)
    {
        /**
         * @var Developer $developer
         */

        $developer = Developer::with('games')->findOrFail($id);
        $path      = public_path('uploads/developers/') . Str::slug($developer->name);

        if ($developer->games->count() > 0) {
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
        /**
         * @var Developer $developer
         */
        if ($request->ajax()) {
            $developer         = Developer::with('games')->findOrFail($request->id);
            $developer->status = $request->state == 'true' ? 1 : 0;
            $developer->save();

            if ($developer->games->count() > 0) {
                if ($developer->status == 0) {
                    foreach ($developer->games as $d_game) {
                        $d_game->update(['status' => 0]);
                    }
                }
            }
            return true;
        }
        return false;
    }
}
