<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        view()->share('settings', Settings::find(1));
    }

    public function index()
    {
        $categories = Categories::orderBy('name', 'asc')->get();
        foreach ($categories as $category) {
            $category->games_count = $category->games->count();
            $category->save();
        }
        return view('backend.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.categories.create');
    }

    public function store(Request $request)
    {
        //TODO: editör validasyonu min:15 değeri düzelt.
        $request->validate([
               'name'        => 'required',
               'description' => 'required|min:15',
               'status'      => 'required'
        ]);

        $category              = new Categories();
        $category->name        = $request->name;
        $category->slug        = Str::slug($request->name);
        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.categories')->with('message', 'Kategori Başarıyla Oluşturuldu.');
    }

    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        return view('backend.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
               'name'        => 'required',
               'description' => 'required|min:15',
               'status'      => 'required',
        ]);

        $category              = Categories::findOrFail($id);
        $category->name        = $request->name;
        $category->slug        = Str::slug($request->name);
        $category->description = $request->description;
        $category->status      = $request->status;
        $category->save();

        return redirect()->route('admin.categories')->with('message', 'Kategori Bilgileri Başarıyla Güncellendi.');
    }

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories')->with('message', 'Kategori Başarıyla Silindi.');
    }
}
