<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CategoryController extends Controller
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

        $categories = Category::with('games')->where('name', 'LIKE', '%' . $quick_search . '%')
                              ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        return view(
            'backend.categories.index',
            compact('categories', 'per_page', 'quick_search', 'sort_dir', 'sort_by')
        );
    }

    public function create()
    {
        return view('backend.categories.create');
    }

    public function store(Request $request)
    {
        $category_fields = [
            'name',
            'status'
        ];

        $category_rules = [
            'name'        => 'required',
            'description' => 'required|min:15',
            'status'      => 'required'
        ];

        foreach ($category_fields as $field) {
            $category_data[$field] = $request->input($field);
        }

        $category_data['description'] = strip_tags($request->input('description'));
        $category_data['slug']        = Str::slug($request->input('name'));

        $validate_category = Validator::make($category_data, $category_rules);

        if ($validate_category->fails()) {
            return redirect()->route('admin.create-article')
                             ->withErrors($validate_category)
                             ->withInput();
        }

        $category_data['description'] = $request->input('description');

        Category::create($category_data);

        return redirect()->route('admin.categories')->with('message', 'Kategori Başarıyla Oluşturuldu.');
    }

    public function edit($category_id)
    {
        $category = Category::findOrFail($category_id);
        $title    = 'Kategori';
        return view('backend.categories.edit', compact('category', 'title'));
    }

    public function update(Request $request, $category_id)
    {
        $category_fields = [
            'name',
            'status'
        ];

        $category_rules = [
            'name'        => 'required',
            'description' => 'required|min:15',
            'status'      => 'required'
        ];

        foreach ($category_fields as $field) {
            $category_data[$field] = $request->input($field);
        }

        $category_data['description'] = strip_tags(trim($request->input('description')));
        $category_data['slug']        = Str::slug($request->input('name'));

        $validate_category = Validator::make($category_data, $category_rules);

        if ($validate_category->fails()) {
            return redirect()->route('admin.edit-category', $category_id)
                             ->withErrors($validate_category)
                             ->withInput();
        }

        $category_data['description'] = $request->input('description');

        $category = Category::with('games')->findOrFail($category_id);
        $category->update($category_data);

        return redirect()->route('admin.categories')->with('message', 'Kategori Bilgileri Başarıyla Güncellendi.');
    }

    public function destroy($id)
    {
        /**
         * @var Category $category
         */
        $category = Category::with('games')->findOrFail($id);

        if ($category->games->count() > 0) {
            foreach ($category->games as $c_game) {
                GameController::destroy($c_game->id);
            }
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('message', 'Kategori Başarıyla Silindi.');
    }

    public function multipleDestroy(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::with('games')->whereIn('id', $request->post('ids'))->get();

            foreach ($categories as $category) {
                if ($category->games->count() > 0) {
                    foreach ($category->games as $c_game) {
                        GameController::destroy($c_game->id);
                    }
                }
                $category->delete();
            }
            return true;
        }
        return false;
    }

    public function switchStatus(Request $request)
    {
        /**
         * @var Category $category
         */
        if ($request->ajax()) {
            $category         = Category::with('games')->findOrFail($request->input('id'));
            $category->status = $request->input('state') == 'true' ? 1 : 0;
            $category->save();

            if ($category->games->count() > 0) {
                if ($category->status == 0) {
                    foreach ($category->games as $c_game) {
                        $c_game->update(['status' => 0]);
                    }
                }
            }
            return true;
        }
        return false;
    }
}
