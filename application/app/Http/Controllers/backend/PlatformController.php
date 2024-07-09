<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;
use Str;
use Validator;

class PlatformController extends Controller
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

        $platforms = Platform::where('name', 'LIKE', '%' . $quick_search . '%')
                             ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        return view('backend.platforms.index', compact('platforms', 'per_page', 'quick_search', 'sort_dir', 'sort_by'));
    }

    public function create()
    {
        $statuses = [];
        foreach (config('platform_config.statuses') as $key => $status) {
            $statuses[$key] = $status;
        }

        return view('backend.platforms.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $platform_fields = [
            'name',
            'status'
        ];

        $platform_rules = [
            'name'   => 'required|max:255',
            'status' => 'required'
        ];

        foreach ($platform_fields as $field) {
            $platform_data[$field] = $request->input($field);
        }

        $platform_data['slug'] = Str::slug($request->input('name'));

        $validate_platform = Validator::make($platform_data, $platform_rules);

        if ($validate_platform->fails()) {
            return redirect()->route('admin.create-platform')
                             ->withErrors($validate_platform)
                             ->withInput();
        }

        Platform::create($platform_data);

        return redirect()->route('admin.platforms')->with('message', 'Platform Başarıyla Oluşturuldu.');
    }

    public function edit($platform_id)
    {
        $platform = Platform::findOrFail($platform_id);

        $statuses = [];
        foreach (config('platform_config.statuses') as $key => $status) {
            $statuses[$key] = $status;
        }

        return view('backend.platforms.edit', compact('platform', 'statuses'));
    }

    public function update(Request $request, $platform_id)
    {
        $platform = Platform::findOrFail($platform_id);

        $platform_fields = [
            'name',
            'status'
        ];

        $platform_rules = [
            'name'   => 'required|max:255',
            'status' => 'required'
        ];

        foreach ($platform_fields as $field) {
            $platform_data[$field] = $request->input($field);
        }

        $platform_data['slug'] = Str::slug($request->input('name'));

        $validate_platform = Validator::make($platform_data, $platform_rules);

        if ($validate_platform->fails()) {
            return redirect()->route('admin.edit-platform', $platform_id)
                             ->withErrors($validate_platform)
                             ->withInput();
        }

        $platform->update($platform_data);

        return redirect()->route('admin.platforms')->with('message', 'Platform Bilgileri Başarıyla Güncellendi.');
    }

    public function destroy($platform_id)
    {
        /**
         * @var Platform $platform
         */

        $platform = Platform::with('games')->findOrFail($platform_id);

        if ($platform->games->count() > 0) {
            foreach ($platform->games as $p_game) {
                $p_game->update(['status' => 0]);
            }
        }

        $platform->delete();
        return redirect()->route('admin.platforms')->with('message', 'Platform Başarıyla Silindi.');
    }

    public function multipleDestroy(Request $request)
    {
        if ($request->ajax()) {
            $platforms = Platform::with('games')->whereIn('id', $request->post('ids'))->get();

            foreach ($platforms as $platform) {
                if ($platform->games->count() > 0) {
                    foreach ($platform->games as $p_game) {
                        $p_game->update(['status' => 0]);
                    }
                }
                $platform->delete();
            }
            return true;
        }
        return false;
    }

    public function switchStatus(Request $request)
    {
        /**
         * @var Platform $platform
         */

        if ($request->ajax()) {
            $platform         = Platform::with('games')->findOrFail($request->input('id'));
            $platform->status = $request->input('state') == 'true' ? 1 : 0;
            $platform->save();

            if ($platform->games->count() > 0) {
                if ($platform->status == 0) {
                    foreach ($platform->games as $p_game) {
                        $p_game->update(['status' => 0]);
                    }
                }
            }
            return true;
        }
        return false;
    }
}
