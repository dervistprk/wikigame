<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\WhiteList;
use Illuminate\Http\Request;
use Validator;

class WhiteListController extends Controller
{
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

        $white_list_users = WhiteList::where('name', 'LIKE', '%' . $quick_search . '%')
                                     ->orderBy($sort_by, $sort_dir)->paginate($per_page)->appends('per_page', $per_page);

        return view('backend.whitelist.index', compact('white_list_users', 'per_page', 'quick_search', 'sort_dir', 'sort_by'));
    }

    public function create()
    {
        return view('backend.whitelist.create');
    }

    public function store(Request $request)
    {
        $white_list_fields = [
            'ip',
            'name'
        ];

        $white_list_rules = [
            'ip'   => 'required|max:255|ip',
            'name' => 'required|max:255'
        ];

        foreach ($white_list_fields as $field) {
            $white_list_data[$field] = $request->input($field);
        }

        $validate_white_list = Validator::make($white_list_data, $white_list_rules);

        if ($validate_white_list->fails()) {
            return redirect()->route('admin.create-whitelist-user')
                             ->withErrors($validate_white_list)
                             ->withInput();
        }

        WhiteList::create($white_list_data);

        return redirect()->route('admin.whitelist-users')->with('message', 'Kullanıcı Başarıyla Eklendi.');
    }

    public function edit($whitelist_id)
    {
        $whitelist_user = WhiteList::find($whitelist_id);
        return view('backend.whitelist.edit', compact('whitelist_user'));
    }

    public function update(Request $request, $whitelist_id)
    {
        $white_list_fields = [
            'ip',
            'name'
        ];

        $white_list_rules = [
            'ip'   => 'required|max:255|ip',
            'name' => 'required|max:255'
        ];

        foreach ($white_list_fields as $field) {
            $white_list_data[$field] = $request->input($field);
        }

        $validate_white_list = Validator::make($white_list_data, $white_list_rules);

        if ($validate_white_list->fails()) {
            return redirect()->route('admin.create-whitelist-user')
                             ->withErrors($validate_white_list)
                             ->withInput();
        }

        $whitelist_user = WhiteList::findOrFail($whitelist_id);
        $whitelist_user->update($white_list_data);

        return redirect()->route('admin.whitelist-users')->with('message', 'Kullanıcı Başarıyla Güncellendi.');
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $white_list = WhiteList::findOrFail($request->post('user_id'));
            $white_list->delete();
            return true;
        }
        return false;
    }
}
