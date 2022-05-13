<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function settings()
    {
        $settings = Settings::first();
        return view('backend.settings', compact('settings'));
    }

    public function settingsUpdate(Request $request)
    {
        $settings = Settings::first();
        $request->validate([
                               'about_text'       => 'required|min:15',
                               'meta_description' => 'required|min:5',
                               'site_status'      => 'required',
                               'favicon'          => 'image|mimes:jpeg,png,jpg,ico|max:320',
                               'logo'             => 'image|mimes:jpeg,png,jpg|max:2048',
                               'backend_favicon'  => 'image|mimes:jpeg,png,jpg,ico|max:320'
                           ]);

        $settings->footer_text      = $request->footer_text;
        $settings->about_text       = $request->about_text;
        $settings->facebook         = $request->facebook;
        $settings->twitter          = $request->twitter;
        $settings->github           = $request->github;
        $settings->linkedin         = $request->linkedin;
        $settings->youtube          = $request->youtube;
        $settings->instagram        = $request->instagram;
        $settings->meta_description = $request->meta_description;
        $settings->site_status      = $request->site_status;

        if ($request->hasFile('favicon')) {
            $imageName = 'favicon' . '.' . $request->favicon->getClientOriginalExtension();
            $request->favicon->move(public_path('assets'), $imageName);
            $settings->favicon = '/assets/' . $imageName;
        }

        if ($request->hasFile('logo')) {
            $imageName = 'logo' . '.' . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('assets'), $imageName);
            $settings->logo = '/assets/' . $imageName;
        }

        if ($request->hasFile('backend_favicon')) {
            $imageName = 'backend_favicon' . '.' . $request->backend_favicon->getClientOriginalExtension();
            $request->backend_favicon->move(public_path('assets'), $imageName);
            $settings->backend_favicon = '/assets/' . $imageName;
        }

        $settings->save();

        return redirect()->route('admin.dashboard')->with('message', 'Site Ayarları Başarıyla Güncellendi.');
    }

}
