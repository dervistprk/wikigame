<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Str;
use Validator;

class GenreController extends Controller
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

        $genres = Genre::where('name', 'LIKE', '%' . $quick_search . '%')
                       ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        return view('backend.genres.index', compact('genres', 'per_page', 'quick_search', 'sort_dir', 'sort_by'));
    }

    public function create()
    {
        $statuses = [];
        foreach (config('genre_config.statuses') as $key => $status) {
            $statuses[$key] = $status;
        }

        return view('backend.genres.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $genre_fields = [
            'name',
            'status'
        ];

        $genre_rules = [
            'name'   => 'required|max:255',
            'status' => 'required'
        ];

        foreach ($genre_fields as $field) {
            $genre_data[$field] = $request->input($field);
        }

        $genre_data['slug'] = Str::slug($request->input('name'));

        $validate_genre = Validator::make($genre_data, $genre_rules);

        if ($validate_genre->fails()) {
            return redirect()->route('admin.create-genre')
                             ->withErrors($validate_genre)
                             ->withInput();
        }

        Genre::create($genre_data);

        return redirect()->route('admin.genres')->with('message', 'Tür Başarıyla Oluşturuldu.');
    }

    public function edit($genre_id)
    {
        $genre = Genre::findOrFail($genre_id);

        $statuses = [];
        foreach (config('genre_config.statuses') as $key => $status) {
            $statuses[$key] = $status;
        }

        return view('backend.genres.edit', compact('genre', 'statuses'));
    }

    public function update(Request $request, $genre_id)
    {
        $genre = Genre::findOrFail($genre_id);

        $genre_fields = [
            'name',
            'status'
        ];

        $genre_rules = [
            'name'   => 'required|max:255',
            'status' => 'required'
        ];

        foreach ($genre_fields as $field) {
            $genre_data[$field] = $request->input($field);
        }

        $genre_data['slug'] = Str::slug($request->input('name'));

        $validate_genre = Validator::make($genre_data, $genre_rules);

        if ($validate_genre->fails()) {
            return redirect()->route('admin.edit-genre', $genre_id)
                             ->withErrors($validate_genre)
                             ->withInput();
        }

        $genre->update($genre_data);

        return redirect()->route('admin.genres')->with('message', 'Tür Bilgileri Başarıyla Güncellendi.');
    }

    public function destroy($genre_id)
    {
        /**
         * @var Genre $genre
         */

        $genre = Genre::with('games')->findOrFail($genre_id);

        if ($genre->games->count() > 0) {
            foreach ($genre->games as $g_game) {
                $g_game->update(['status' => 0]);
            }
        }

        $genre->delete();
        return redirect()->route('admin.genres')->with('message', 'Tür Başarıyla Silindi.');
    }

    public function multipleDestroy(Request $request)
    {
        if ($request->ajax()) {
            $genres = Genre::with('games')->whereIn('id', $request->post('ids'))->get();

            foreach ($genres as $genre) {
                if ($genre->games->count() > 0) {
                    foreach ($genre->games as $g_game) {
                        $g_game->update(['status' => 0]);
                    }
                }
                $genre->delete();
            }
            return true;
        }
        return false;
    }

    public function switchStatus(Request $request)
    {
        /**
         * @var Genre $genre
         */

        if ($request->ajax()) {
            $genre         = Genre::with('games')->findOrFail($request->input('id'));
            $genre->status = $request->input('state') == 'true' ? 1 : 0;
            $genre->save();

            if ($genre->games->count() > 0) {
                if ($genre->status == 0) {
                    foreach ($genre->games as $g_game) {
                        $g_game->update(['status' => 0]);
                    }
                }
            }
            return true;
        }
        return false;
    }
}
