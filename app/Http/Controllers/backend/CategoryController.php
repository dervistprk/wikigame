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

        $categories = Categories::where('name', 'LIKE', '%' . $quick_search . '%')
                                ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        foreach ($categories as $category) {
            $category->games_count = $category->games->count();
            $category->save();
        }

        return view('backend.categories.index', compact('categories', 'per_page', 'quick_search', 'sort_dir', 'sort_by'));
    }

    public function create()
    {
        return view('backend.categories.create');
    }

    public function store(Request $request)
    {
        //TODO: editör validasyonu min:15 değeri düzelt.
        //TODO: kategori pasif yapılınca ilgili oyunları da pasife al (aynısına geliştirici ve dağıtıcı için de bak)
        //TODO: oyunların; resim, video ve varsa başka bu şekilde kolonlarını ana tablodan kaldırıp yeni bir tablo oluşturup oraya al.
        //TODO: bu tablolara modelleri oluştur, ilgili kolonların kullanıldığı yerleri tespit edip gerekli değişiklikleri yap.
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

    public function switchStatus(Request $request)
    {
        $category         = Categories::findOrFail($request->id);
        $category->status = $request->state == 'true' ? 1 : 0;
        $category->save();
        return true;
    }
}
