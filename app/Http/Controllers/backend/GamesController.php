<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Developers;
use App\Models\GameDetails;
use App\Models\Games;
use App\Models\Publishers;
use App\Models\Settings;
use App\Models\SystemRequirementsMin;
use App\Models\SystemRequirementsRec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class GamesController extends Controller
{
    public function __construct()
    {
        view()->share('settings', Settings::find(1));
    }

    public function index()
    {
        $games = Games::orderBy('id', 'desc')->get();
        return view('backend.games.index', compact('games'));
    }

    public function create()
    {
        $categories = Categories::where('status', '=', 1)->orderBy('name')->get();
        $developers = Developers::where('status', '=', 1)->orderBy('name')->get();
        $publishers = Publishers::where('status', '=', 1)->orderBy('name')->get();

        return view('backend.games.create', compact('categories', 'developers', 'publishers'));
    }

    public function store(Request $request)
    {
        $request->validate([
                               'name'             => 'required|max:255',
                               'subtitle'         => 'required|max:255',
                               'category'         => 'required',
                               'developer'        => 'required',
                               'publisher'        => 'required',
                               'genre'            => 'required',
                               'platform'         => 'required',
                               'release_date'     => 'required',
                               'website'          => 'required|max:255',
                               'description'      => 'required|min:15',
                               'cpu_min'          => 'required|max:255',
                               'gpu_min'          => 'required|max:255',
                               'ram_min'          => 'required|numeric',
                               'ram_min_unit'     => 'required',
                               'storage_min'      => 'required|numeric',
                               'storage_min_unit' => 'required',
                               'os_min'           => 'required|max:255',
                               'cpu_rec'          => 'required|max:255',
                               'gpu_rec'          => 'required|max:255',
                               'ram_rec'          => 'required|numeric',
                               'ram_rec_unit'     => 'required',
                               'storage_rec'      => 'required|numeric',
                               'storage_rec_unit' => 'required',
                               'os_rec'           => 'required|max:255',
                               'cover_image'      => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:3092',
                               'image1'           => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:3092',
                               'image2'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'image3'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'image4'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'image5'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'image6'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'image7'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'video1'           => 'required|max:255'
                           ]);

        $game               = new Games();
        $game->name         = ucwords($request->name);
        $game->sub_title    = ucfirst($request->subtitle);
        $game->category_id  = $request->category;
        $game->developer_id = $request->developer;
        $game->publisher_id = $request->publisher;
        $game->slug         = Str::slug($request->name);
        $game->description  = $request->description;
        $game->status       = 1;
        $game->hit          = 0;

        $sys_req_min               = new SystemRequirementsMin();
        $sys_req_min->cpu          = $request->cpu_min;
        $sys_req_min->gpu          = $request->gpu_min;
        $sys_req_min->ram          = $request->ram_min;
        $sys_req_min->ram_unit     = $request->ram_min_unit;
        $sys_req_min->storage      = $request->storage_min;
        $sys_req_min->storage_unit = $request->storage_min_unit;
        $sys_req_min->os           = $request->os_min;
        $sys_req_min->save();

        $sys_req_rec               = new SystemRequirementsRec();
        $sys_req_rec->cpu          = $request->cpu_rec;
        $sys_req_rec->gpu          = $request->gpu_rec;
        $sys_req_rec->ram          = $request->ram_rec;
        $sys_req_rec->ram_unit     = $request->ram_rec_unit;
        $sys_req_rec->storage      = $request->storage_rec;
        $sys_req_rec->storage_unit = $request->storage_rec_unit;
        $sys_req_rec->os           = $request->os_rec;
        $sys_req_rec->save();

        $game_details               = new GameDetails();
        $game_details->genre        = implode(', ', $request->genre);
        $game_details->age_rating   = $request->age_rating;
        $game_details->release_date = $request->release_date;
        $game_details->platform     = implode(', ', $request->platform);
        $game_details->website      = $request->website;
        $game_details->save();

        $path = public_path('uploads/games/') . Str::slug($request->name);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $image              = $request->file('cover_image');
        $coverImageName     = Str::slug($request->name) . '-cover.' . $request->cover_image->getClientOriginalExtension();
        $cover_image_resize = Image::make($image->getRealPath());
        $cover_image_resize->resize(230, 300);
        $cover_image_resize->save($path . '/' . $coverImageName);
        $game->cover_image = '/uploads/games/' . Str::slug($request->name) . '/' . $coverImageName;

        $image        = $request->file('image1');
        $imageName    = Str::slug($request->name) . '-1.' . $request->image1->getClientOriginalExtension();
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(1920, 1080);
        $image_resize->save($path . '/' . $imageName);
        $game->image1 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;

        if ($request->hasFile('image2')) {
            $image        = $request->file('image2');
            $imageName    = Str::slug($request->name) . '-2.' . $request->image2->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image2 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        if ($request->hasFile('image3')) {
            $image        = $request->file('image3');
            $imageName    = Str::slug($request->name) . '-3.' . $request->image3->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image3 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        if ($request->hasFile('image4')) {
            $image        = $request->file('image4');
            $imageName    = Str::slug($request->name) . '-4.' . $request->image4->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image4 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        if ($request->hasFile('image5')) {
            $image        = $request->file('image5');
            $imageName    = Str::slug($request->name) . '-5.' . $request->image5->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image5 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        if ($request->hasFile('image6')) {
            $image        = $request->file('image6');
            $imageName    = Str::slug($request->name) . '-6.' . $request->image6->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image6 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        if ($request->hasFile('image7')) {
            $image        = $request->file('image1');
            $imageName    = Str::slug($request->name) . '-7.' . $request->image7->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image7 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        $game->video1 = 'https://www.youtube.com/embed/' . $request->video1;

        if ($request->video2) {
            $game->video2 = 'https://www.youtube.com/embed/' . $request->video2;
        }

        if ($request->video3) {
            $game->video3 = 'https://www.youtube.com/embed/' . $request->video3;
        }

        if ($request->video4) {
            $game->video4 = 'https://www.youtube.com/embed/' . $request->video4;
        }

        if ($request->video5) {
            $game->video5 = 'https://www.youtube.com/embed/' . $request->video5;
        }

        $game->sys_req_min_id  = $sys_req_min->id;
        $game->sys_req_rec_id  = $sys_req_rec->id;
        $game->game_details_id = $game_details->id;
        $game->save();

        return redirect()->route('admin.games')->with('message', 'Oyun Başarıyla Oluşturuldu.');
    }

    public function edit($id)
    {
        $game       = Games::findOrFail($id);
        $categories = Categories::where('status', '=', 1)->orderBy('name', 'asc')->get();
        $developers = Developers::where('status', '=', 1)->orderBy('name', 'asc')->get();
        $publishers = Publishers::where('status', '=', 1)->orderBy('name', 'asc')->get();

        return view('backend.games.edit', compact('game', 'categories', 'developers', 'publishers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
                               'name'             => 'required|max:255',
                               'subtitle'         => 'required|max:255',
                               'category'         => 'required',
                               'developer'        => 'required',
                               'publisher'        => 'required',
                               'genre'            => 'required',
                               'platform'         => 'required',
                               'release_date'     => 'required',
                               'website'          => 'required|max:255',
                               'description'      => 'required|min:15',
                               'cpu_min'          => 'required|max:255',
                               'gpu_min'          => 'required|max:255',
                               'ram_min'          => 'required|numeric',
                               'ram_min_unit'     => 'required',
                               'storage_min'      => 'required|numeric',
                               'storage_min_unit' => 'required',
                               'os_min'           => 'required|max:255',
                               'cpu_rec'          => 'required|max:255',
                               'gpu_rec'          => 'required|max:255',
                               'ram_rec'          => 'required|numeric',
                               'ram_rec_unit'     => 'required',
                               'storage_rec'      => 'required|numeric',
                               'storage_rec_unit' => 'required',
                               'os_rec'           => 'required|max:255',
                               'image1'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:3092',
                               'image2'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'image3'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'image4'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'image5'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'image6'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'image7'           => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
                               'video1'           => 'required|max:255'
                           ]);

        $game               = Games::findOrFail($id);
        $game->name         = ucwords($request->name);
        $game->sub_title    = ucfirst($request->subtitle);
        $game->category_id  = $request->category;
        $game->developer_id = $request->developer;
        $game->publisher_id = $request->publisher;
        $game->slug         = Str::slug($request->name);
        $game->description  = $request->description;
        $game->status       = $request->status;

        $sys_req_min               = SystemRequirementsMin::where('id', '=', $game->sys_req_min_id)->first();
        $sys_req_min->cpu          = $request->cpu_min;
        $sys_req_min->gpu          = $request->gpu_min;
        $sys_req_min->ram          = $request->ram_min;
        $sys_req_min->ram_unit     = $request->ram_min_unit;
        $sys_req_min->storage      = $request->storage_min;
        $sys_req_min->storage_unit = $request->storage_min_unit;
        $sys_req_min->os           = $request->os_min;
        $sys_req_min->save();

        $sys_req_rec               = SystemRequirementsRec::where('id','=' , $game->sys_req_rec_id)->first();
        $sys_req_rec->cpu          = $request->cpu_rec;
        $sys_req_rec->gpu          = $request->gpu_rec;
        $sys_req_rec->ram          = $request->ram_rec;
        $sys_req_rec->ram_unit     = $request->ram_rec_unit;
        $sys_req_rec->storage      = $request->storage_rec;
        $sys_req_rec->storage_unit = $request->storage_rec_unit;
        $sys_req_rec->os           = $request->os_rec;
        $sys_req_rec->save();

        $game_details               = GameDetails::where('id','=' , $game->game_details_id)->first();
        $game_details->genre        = implode(', ', $request->genre);
        $game_details->age_rating   = $request->age_rating;
        $game_details->release_date = $request->release_date;
        $game_details->platform     = implode(', ', $request->platform);
        $game_details->website      = $request->website;
        $game_details->save();

        $path = public_path('uploads/games/') . Str::slug($request->name);

        if ($request->hasFile('cover_image')) {
            $image          = $request->file('cover_image');
            $coverImageName = Str::slug($request->name) . '-cover.' . $request->cover_image->getClientOriginalExtension();
            $image_resize   = Image::make($image->getRealPath());
            $image_resize->resize(230, 300);
            $image_resize->save($path . '/' . $coverImageName);
            $game->cover_image = '/uploads/games/' . Str::slug($request->name) . '/' . $coverImageName;
        }

        if ($request->hasFile('image1')) {
            $image        = $request->file('image1');
            $imageName    = Str::slug($request->name) . '-1.' . $request->image1->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image1 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        if ($request->hasFile('image2')) {
            $image        = $request->file('image2');
            $imageName    = Str::slug($request->name) . '-2.' . $request->image2->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image2 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        if ($request->hasFile('image3')) {
            $image        = $request->file('image3');
            $imageName    = Str::slug($request->name) . '-3.' . $request->image3->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image3 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        if ($request->hasFile('image4')) {
            $image        = $request->file('image4');
            $imageName    = Str::slug($request->name) . '-4.' . $request->image4->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image4 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        if ($request->hasFile('image5')) {
            $image        = $request->file('image5');
            $imageName    = Str::slug($request->name) . '-5.' . $request->image5->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image5 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        if ($request->hasFile('image6')) {
            $image        = $request->file('image6');
            $imageName    = Str::slug($request->name) . '-6.' . $request->image6->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image6 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        if ($request->hasFile('image7')) {
            $image        = $request->file('image7');
            $imageName    = Str::slug($request->name) . '-7.' . $request->image7->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1920, 1080);
            $image_resize->save($path . '/' . $imageName);
            $game->image7 = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        $game->video1 = $request->video1;

        if ($request->video2) {
            $game->video2 = $request->video2;
        }

        if ($request->video3) {
            $game->video3 = $request->video3;
        }

        if ($request->video4) {
            $game->video4 = $request->video4;
        }

        if ($request->video5) {
            $game->video5 = $request->video5;
        }

        $game->sys_req_min_id  = $sys_req_min->id;
        $game->sys_req_rec_id  = $sys_req_rec->id;
        $game->game_details_id = $game_details->id;
        $game->save();

        return redirect()->route('admin.games')->with('message', 'Oyun Bilgileri Başarıyla Güncellendi.');
    }

    public function destroy($id)
    {
        $game         = Games::findOrFail($id);
        $game_details = GameDetails::where('id','=' , $game->game_details_id)->first();
        $sys_req_min  = SystemRequirementsMin::where('id','=' , $game->sys_req_min_id)->first();
        $sys_req_rec  = SystemRequirementsRec::where('id','=' , $game->sys_req_rec_id)->first();

        File::delete(public_path($game->cover_image));
        File::delete(public_path($game->image1));

        if (File::exists(public_path($game->image2))) {
            File::delete(public_path($game->image2));
        }

        if (File::exists(public_path($game->image3))) {
            File::delete(public_path($game->image3));
        }

        if (File::exists(public_path($game->image4))) {
            File::delete(public_path($game->image4));
        }

        if (File::exists(public_path($game->image5))) {
            File::delete(public_path($game->image5));
        }

        if (File::exists(public_path($game->image6))) {
            File::delete(public_path($game->image6));
        }

        if (File::exists(public_path($game->image7))) {
            File::delete(public_path($game->image7));
        }

        $path = public_path('uploads/games/') . Str::slug($game->name);
        array_map('unlink', glob("$path/*.*"));
        rmdir(public_path('uploads/games/') . Str::slug($game->name));

        $game->delete();
        $game_details->delete();
        $sys_req_min->delete();
        $sys_req_rec->delete();

        return redirect()->route('admin.games')->with('message', 'Oyun Başarıyla Silindi.');
    }
}
