<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;

class SettingController extends Controller
{
    public function settings()
    {
        $settings = Setting::first();
        return view('backend.settings', compact('settings'));
    }

    public function settingsUpdate(Request $request)
    {
        $settings = Setting::first();

        $settings_fields = [
            'footer_text',
            'about_text',
            'facebook',
            'twitter',
            'github',
            'linkedin',
            'youtube',
            'instagram',
            'meta_description',
            'site_status'
        ];

        $settings_rules = [
            'about_text'       => 'required|min:15',
            'meta_description' => 'required|min:5',
            'site_status'      => 'required',
            'favicon'          => 'image|mimes:jpeg,png,jpg,ico,webp|max:500',
            'logo'             => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'backend_favicon'  => 'image|mimes:jpeg,png,jpg,ico,webp|max:500'
        ];

        foreach ($settings_fields as $field) {
            $setting_data[$field] = $request->input($field);
        }

        $validate_settings = Validator::make($setting_data, $settings_rules);

        if ($validate_settings->fails()) {
            return redirect()->route('admin.settings')
                             ->withErrors($validate_settings)
                             ->withInput();
        }

        $image_path = public_path('assets/');

        if (!file_exists($image_path)) {
            mkdir($image_path, 0777, true);
        }

        if ($request->hasFile('favicon')) {
            $imageName = 'favicon' . '.' . $request->favicon->getClientOriginalExtension();
            Image::make($request->file('favicon')->getRealPath())->resize(16, 16)->save($image_path . $imageName);
            $setting_data['favicon'] = '/assets/' . $imageName;
        }

        if ($request->hasFile('logo')) {
            $imageName = 'logo' . '.' . $request->logo->getClientOriginalExtension();
            Image::make($request->file('logo')->getRealPath())->resize(40, 40)->save($image_path . $imageName);
            $setting_data['logo'] = '/assets/' . $imageName;
        }

        if ($request->hasFile('backend_favicon')) {
            $imageName = 'backend_favicon' . '.' . $request->backend_favicon->getClientOriginalExtension();
            Image::make($request->file('backend_favicon')->getRealPath())->resize(16, 16)->save($image_path . $imageName);
            $setting_data['backend_favicon'] = '/assets/' . $imageName;
        }

        $settings->update($setting_data);

        return redirect()->route('admin.dashboard')->with('message', 'Site Ayarları Başarıyla Güncellendi.');
    }

}