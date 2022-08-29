<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;

class PublisherController extends Controller
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

        $publishers = Publisher::where('name', 'LIKE', '%' . $quick_search . '%')
                               ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        return view('backend.publishers.index', compact('publishers', 'per_page', 'quick_search', 'sort_dir', 'sort_by'));
    }

    public function create()
    {
        return view('backend.publishers.create');
    }

    public function store(Request $request)
    {
        $publisher_fields = [
            'name',
            'description',
            'status',
        ];

        $publisher_rules = [
            'name'        => 'required',
            'description' => 'required|min:15',
            'status'      => 'required',
        ];

        foreach ($publisher_fields as $field) {
            $publisher_data[$field] = $request->input($field);
        }

        $publisher_data['slug'] = Str::slug($request->input('name'));

        $validate_publisher = Validator::make($publisher_data, $publisher_rules);

        if ($validate_publisher->fails()) {
            return redirect()->route('admin.create-publisher')
                             ->withErrors($validate_publisher)
                             ->withInput();
        }

        $image_rules = [
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048'
        ];

        $validate_image = Validator::make($request->file(), $image_rules);

        if ($validate_image->fails()) {
            return redirect()->route('admin.create-publisher')
                             ->withErrors($validate_image)
                             ->withInput();
        }

        $path = public_path('uploads/publishers/') . Str::slug($request->name);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $image     = $request->file('image');
        $imageName = Str::slug($request->input('name')) . '.' . $request->image->getClientOriginalExtension();
        Image::make($image->getRealPath())->resize(300, 220)->save($path . '/' . $imageName);
        $publisher_data['image'] = '/uploads/publishers/' . Str::slug($request->input('name')) . '/' . $imageName;

        Publisher::create($publisher_data);

        return redirect()->route('admin.publishers')->with('message', 'Dağıtıcı Başarıyla Oluşturuldu.');
    }

    public function edit($publisher_id)
    {
        $publisher = Publisher::findOrFail($publisher_id);
        return view('backend.publishers.edit', compact('publisher'));
    }

    public function update(Request $request, $publisher_id)
    {
        $publisher = Publisher::findOrFail($publisher_id);

        $publisher_fields = [
            'name',
            'description',
            'status',
        ];

        $publisher_rules = [
            'name'        => 'required',
            'description' => 'required|min:15',
            'status'      => 'required',
        ];

        foreach ($publisher_fields as $field) {
            $publisher_data[$field] = $request->input($field);
        }

        $validate_publisher = Validator::make($publisher_data, $publisher_rules);

        if ($validate_publisher->fails()) {
            return redirect()->route('admin.edit-publisher', $publisher_id)
                             ->withErrors($validate_publisher)
                             ->withInput();
        }

        $image_rules = [
            'image' => 'image|mimes:jpg,jpeg,png,webp,svg|max:2048'
        ];

        $validate_image = Validator::make($request->file(), $image_rules);

        if ($validate_image->fails()) {
            return redirect()->route('admin.edit-publisher', $publisher_id)
                             ->withErrors($validate_image)
                             ->withInput();
        }

        if ($request->hasFile('image')) {
            $path = public_path('uploads/publishers/') . Str::slug($request->input('name'));

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $image     = $request->file('image');
            $imageName = Str::slug($request->input('name')) . '.' . $request->image->getClientOriginalExtension();
            Image::make($image->getRealPath())->resize(300, 220)->save($path . '/' . $imageName);
            $publisher_data['image'] = '/uploads/publishers/' . Str::slug($request->input('name')) . '/' . $imageName;
        }

        $publisher->update($publisher_data);

        return redirect()->route('admin.publishers')->with('message', 'Dağıtıcı Bilgileri Başarıyla Güncellendi.');
    }

    public function destroy($id)
    {
        /**
         * @var Publisher $publisher
         */

        $publisher = Publisher::with('games')->findOrFail($id);

        $path = public_path('uploads/publishers/') . Str::slug($publisher->name);

        if ($publisher->games->count() > 0) {
            foreach ($publisher->games as $p_game) {
                GameController::destroy($p_game->id);
            }
        }

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
        /**
         * @var Publisher $publisher
         */

        if ($request->ajax()) {
            $publisher         = Publisher::with('games')->findOrFail($request->id);
            $publisher->status = $request->state == 'true' ? 1 : 0;
            $publisher->save();

            if ($publisher->games->count() > 0) {
                if ($publisher->status == 0) {
                    foreach ($publisher->games as $p_game) {
                        $p_game->update(['status' => 0]);
                    }
                }
            }
            return true;
        }
        return false;
    }
}
