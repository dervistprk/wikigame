<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Developer;
use App\Models\GameDetail;
use App\Models\Game;
use App\Models\GameImage;
use App\Models\GameVideo;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Publisher;
use App\Models\Setting;
use App\Models\SystemRequirementsMin;
use App\Models\SystemRequirementsRec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $per_page     = $request->get('per_page', 10);
        $quick_search = $request->get('quick_search');

        $name_query             = $request->get('name_query');
        $id_query               = $request->get('id_query');
        $category_query         = $request->get('category_query');
        $developer_query        = $request->get('developer_query');
        $publisher_query        = $request->get('publisher_query');
        $release_date_max_query = $request->get('release_date_max_query');
        $release_date_min_query = $request->get('release_date_min_query');
        $status_query           = $request->get('status_query');

        $sort_by  = $request->get('sort_by', 'id');
        $sort_dir = $request->get('sort_dir', 'desc');

        $detailed_search = [];
        $relation_search = [];

        if (!is_null($quick_search)) {
            $detailed_search[] = ['name', 'LIKE', '%' . $quick_search . '%'];
        }

        if (!is_null($id_query)) {
            $detailed_search[] = ['id', '=', $id_query];
        }

        if (!is_null($name_query)) {
            $detailed_search[] = ['name', 'LIKE', '%' . $name_query . '%'];
        }

        if (!is_null($category_query)) {
            $detailed_search[] = ['category_id', '=', $category_query];
        }

        if (!is_null($developer_query)) {
            $detailed_search[] = ['developer_id', '=', $developer_query];
        }

        if (!is_null($publisher_query)) {
            $detailed_search[] = ['publisher_id', '=', $publisher_query];
        }

        if (!is_null($release_date_max_query)) {
            $relation_search[] = ['release_date', '<=', $release_date_max_query];
        }

        if (!is_null($release_date_min_query)) {
            $relation_search[] = ['release_date', '>=', $release_date_min_query];
        }

        if (!is_null($status_query)) {
            $detailed_search[] = ['status', '=', $status_query];
        }

        if ($sort_dir == 'desc') {
            $sort_dir = 'asc';
        } else {
            $sort_dir = 'desc';
        }

        $games = Game::whereHas('details', function($q) use ($relation_search) {
            return $q->where($relation_search);
        })->orderBy($sort_by, $sort_dir)->where($detailed_search)->paginate($per_page)->appends('per_page', $per_page);

        $developers = Developer::where('status', '=', 1)->get();
        $publishers = Publisher::where('status', '=', 1)->get();
        $categories = Category::where('status', '=', 1)->get();

        return view(
            'backend.games.index',
            compact(
                'games',
                'per_page',
                'quick_search',
                'developers',
                'publishers',
                'categories',
                'name_query',
                'id_query',
                'category_query',
                'developer_query',
                'publisher_query',
                'release_date_min_query',
                'release_date_max_query',
                'status_query',
                'sort_dir',
                'sort_by'
            )
        );
    }

    public function create()
    {
        $categories = Category::where('status', '=', 1)->orderBy('name')->get();
        $developers = Developer::where('status', '=', 1)->orderBy('name')->get();
        $publishers = Publisher::where('status', '=', 1)->orderBy('name')->get();
        $platforms  = Platform::where('status', '=', 1)->orderBy('name')->get();
        $genres     = Genre::where('status', '=', 1)->orderBy('name')->get();

        $statuses = [];
        foreach (config('game_config.statuses') as $key => $status) {
            $statuses[$key] = $status;
        }

        return view('backend.games.create', compact('categories', 'developers', 'publishers', 'platforms', 'genres', 'statuses'));
    }

    public function store(Request $request)
    {
        $game_fields = [
            'name',
            'category_id',
            'developer_id',
            'publisher_id',
            'description',
            'status',
        ];

        $game_field_rules = [
            'name'         => 'required|unique:games|max:255',
            'sub_title'    => 'required|max:255',
            'category_id'  => 'required',
            'developer_id' => 'required',
            'publisher_id' => 'required',
            'description'  => 'required|min:15',
            'status'       => 'required'
        ];

        foreach ($game_fields as $game_field) {
            $game_data[$game_field] = $request->input($game_field);
        }

        $game_data['sub_title'] = ucfirst($request->sub_title);
        $game_data['slug']      = Str::slug($request->name);

        $validate_game_fields = Validator::make($game_data, $game_field_rules);

        if ($validate_game_fields->fails()) {
            return redirect()->route('admin.create-game')
                             ->withErrors($validate_game_fields)
                             ->withInput();
        }

        $game_detail_fields = [
            'release_date',
            'website',
            'age_rating',
        ];

        $game_detail_field_rules = [
            'release_date' => 'required',
            'website'      => 'required|max:255',
            'age_rating'   => 'required',
        ];

        foreach ($game_detail_fields as $detail_field) {
            $detail_data[$detail_field] = $request->input($detail_field);
        }

        $validate_game_detail_fields = Validator::make($detail_data, $game_detail_field_rules);

        if ($validate_game_detail_fields->fails()) {
            return redirect()->route('admin.create-game')
                             ->withErrors($validate_game_detail_fields)
                             ->withInput();
        }

        $game_platform_field_rules = [
            'platform_id.*' => 'required'
        ];

        $platform_data = $request->input('platform_id');

        $validate_game_platform_fields = Validator::make($platform_data, $game_platform_field_rules);

        if ($validate_game_platform_fields->fails()) {
            return redirect()->route('admin.create-game')
                             ->withErrors($validate_game_platform_fields)
                             ->withInput();
        }

        $game_genre_field_rules = [
            'genre_id.*' => 'required'
        ];

        $genre_data = $request->input('genre_id');

        $validate_game_genre_fields = Validator::make($genre_data, $game_genre_field_rules);

        if ($validate_game_genre_fields->fails()) {
            return redirect()->route('admin.create-game')
                             ->withErrors($validate_game_genre_fields)
                             ->withInput();
        }

        $file_rules = [
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'image1'      => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:3092',
        ];

        $validate_file = Validator::make($request->file(), $file_rules);

        if ($validate_file->fails()) {
            return redirect()->route('admin.create-game')
                             ->withErrors($validate_file)
                             ->withInput();
        }

        $sys_req_min_fields = [
            'cpu_min',
            'gpu_min',
            'ram_min',
            'ram_min_unit',
            'storage_min',
            'storage_min_unit',
            'os_min'
        ];

        $sys_req_min_rules = [
            'cpu_min'          => 'required|max:255',
            'gpu_min'          => 'required|max:255',
            'ram_min'          => 'required|numeric',
            'ram_min_unit'     => 'required',
            'storage_min'      => 'required|numeric',
            'storage_min_unit' => 'required',
            'os_min'           => 'required|max:255'
        ];

        foreach ($sys_req_min_fields as $min_field) {
            $sys_req_min_data[$min_field] = $request->input($min_field);
        }

        $validate_sys_req_min_fields = Validator::make($sys_req_min_data, $sys_req_min_rules);

        if ($validate_sys_req_min_fields->fails()) {
            return redirect()->route('admin.create-game')
                             ->withErrors($validate_sys_req_min_fields)
                             ->withInput();
        }

        $sys_req_rec_fields = [
            'cpu_rec',
            'gpu_rec',
            'ram_rec',
            'ram_rec_unit',
            'storage_rec',
            'storage_rec_unit',
            'os_rec'
        ];

        $sys_req_rec_rules = [
            'cpu_rec'          => 'required|max:255',
            'gpu_rec'          => 'required|max:255',
            'ram_rec'          => 'required|numeric',
            'ram_rec_unit'     => 'required',
            'storage_rec'      => 'required|numeric',
            'storage_rec_unit' => 'required',
            'os_rec'           => 'required|max:255',
        ];

        foreach ($sys_req_rec_fields as $rec_field) {
            $sys_req_rec_data[$rec_field] = $request->input($rec_field);
        }

        $validate_sys_req_rec_fields = Validator::make($sys_req_rec_data, $sys_req_rec_rules);

        if ($validate_sys_req_rec_fields->fails()) {
            return redirect()->route('admin.create-game')
                             ->withErrors($validate_sys_req_rec_fields)
                             ->withInput();
        }

        $image_path = public_path('uploads/games/') . Str::slug($request->name);

        if (!file_exists($image_path)) {
            mkdir($image_path, 0777, true);
        }

        $cover_image    = $request->file('cover_image');
        $coverImageName = Str::slug($request->name) . '-cover.' . $request->cover_image->getClientOriginalExtension();
        Image::make($cover_image->getRealPath())->resize(230, 300)->save($image_path . '/' . $coverImageName);
        $game_data['cover_image'] = '/uploads/games/' . Str::slug($request->name) . '/' . $coverImageName;

        $image_1   = $request->file('image1');
        $imageName = Str::slug($request->name) . '-1.' . $request->image1->getClientOriginalExtension();
        Image::make($image_1->getRealPath())->resize(1920, 1080)->save($image_path . '/' . $imageName);
        $game_data['image1'] = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;

        $game         = new Game($game_data);
        $game_details = new GameDetail($detail_data);
        $sys_req_min  = new SystemRequirementsMin($sys_req_min_data);
        $sys_req_rec  = new SystemRequirementsRec($sys_req_rec_data);

        $game_details->save();
        $sys_req_min->save();
        $sys_req_rec->save();

        $game->game_details_id = $game_details->id;
        $game->sys_req_min_id  = $sys_req_min->id;
        $game->sys_req_rec_id  = $sys_req_rec->id;
        $game->save();
        $game->platforms()->sync($platform_data);
        $game->genres()->sync($genre_data);

        //if extra images comes from request then save image path and hash
        if (isset($request->file()['path'])) {
            $image_fields['path']       = $request->file()['path'];
            $image_fields['image_hash'] = $request->input('image_hash');
            $image_count                = count($image_fields['path']);

            $image_path_field_rules = [
                "path.*" => "required|image|mimes:jpeg,png,jpg,svg,webp|max:3092",
            ];

            $validate_image_path_field = Validator::make($image_fields['path'], $image_path_field_rules);

            if ($validate_image_path_field->fails()) {
                self::destroy($game->id);
                return redirect()->route('admin.create-game')
                                 ->withErrors($validate_image_path_field)
                                 ->withInput();
            }

            $k = 2;

            foreach ($image_fields['path'] as $temp_image) {
                $imageName    = Str::slug($request->name) . '-' . $k . '.' . $temp_image->getClientOriginalExtension();
                $image_resize = Image::make($temp_image->getRealPath());
                $image_resize->resize(1920, 1080);
                $image_resize->save($image_path . '/' . $imageName);

                $image_data = [
                    'game_id' => $game->id,
                    'path'    => '/uploads/games/' . Str::slug($request->name) . '/' . $imageName,
                ];

                GameImage::create($image_data);
                $k++;
            }

            $image_hash_field_rules = [
                'image_hash.*' => 'required|max:255'
            ];

            $validate_image_hash_fields = Validator::make($image_fields['image_hash'], $image_hash_field_rules);

            if ($validate_image_hash_fields->fails()) {
                self::destroy($game->id);
                return redirect()->route('admin.create-game')
                                 ->withErrors($validate_image_hash_fields)
                                 ->withInput();
            }

            $image_hash_data = [];

            foreach ($image_fields['image_hash'] as $hash) {
                $image_hash_data[] = $hash;
            }

            $last_added_images = GameImage::latest()->take($image_count)->get();
            $i                 = 0;

            foreach ($last_added_images as $last_image) {
                $last_image->image_hash = $image_hash_data[$i];
                $last_image->save();
                $i++;
            }
        }

        //save video url and hash
        $video_fields['url']        = $request->input('url');
        $video_fields['video_hash'] = $request->input('video_hash');

        $video_count = count($video_fields['url']);

        $video_url_field_rules = [
            "url.*" => "required|max:255",
        ];

        $validate_video_url_field = Validator::make($video_fields['url'], $video_url_field_rules);

        if ($validate_video_url_field->fails()) {
            self::destroy($game->id);
            return redirect()->route('admin.create-game')
                             ->withErrors($validate_video_url_field)
                             ->withInput();
        }

        foreach ($video_fields['url'] as $url) {
            $video_data = [
                'game_id' => $game->id,
                'url'     => 'https://www.youtube.com/embed/' . $url
            ];

            GameVideo::create($video_data);
        }

        $video_hash_field_rules = [
            'video_hash.*' => 'required|max:255'
        ];

        $validate_video_hash_fields = Validator::make($video_fields['video_hash'], $video_hash_field_rules);

        if ($validate_video_hash_fields->fails()) {
            self::destroy($game->id);
            return redirect()->route('admin.create-game')
                             ->withErrors($validate_video_hash_fields)
                             ->withInput();
        }

        $video_hash_data = [];

        foreach ($video_fields['video_hash'] as $hash) {
            $video_hash_data[] = $hash;
        }

        $last_added_videos = GameVideo::latest()->take($video_count)->get();
        $i                 = 0;

        foreach ($last_added_videos as $last_video) {
            $last_video->video_hash = $video_hash_data[$i];
            $last_video->save();
            $i++;
        }

        return redirect()->route('admin.games')->with('message', 'Oyun Başarıyla Oluşturuldu.');
    }

    public function edit($id)
    {
        $game       = Game::with('videos', 'platforms')->findOrFail($id);
        $categories = Category::where('status', '=', 1)->orderBy('name')->get();
        $developers = Developer::where('status', '=', 1)->orderBy('name')->get();
        $publishers = Publisher::where('status', '=', 1)->orderBy('name')->get();
        $platforms  = Platform::where('status', '=', 1)->orderBy('name')->pluck('name', 'id');
        $genres     = Genre::where('status', '=', 1)->orderBy('name')->pluck('name', 'id');

        $video_count = 1;
        $video_limit = config('game_config.video_count');

        $image_count = 1;
        $image_limit = config('game_config.image_count');

        return view(
            'backend.games.edit',
            compact(
                'game',
                'categories',
                'developers',
                'publishers',
                'video_count',
                'video_limit',
                'image_count',
                'image_limit',
                'platforms',
                'genres'
            )
        );
    }

    public function update(Request $request, $game_id)
    {
        /**
         * @var Game $game
         */
        $game = Game::with(
            'details',
            'systemReqMin',
            'systemReqRec',
            'category',
            'developer',
            'publisher',
            'videos'
        )->findOrFail($game_id);

        $game_fields = [
            'name',
            'category_id',
            'developer_id',
            'publisher_id',
            'description',
            'status',
        ];

        $category_status  = $game->category->status;
        $developer_status = $game->developer->status;
        $publisher_status = $game->publisher->status;

        if ($category_status == 0) {
            $status_message = 'Oyunu aktive etmek için lütfen öncelikle <span class="font-weight-bold">kategorisini</span> aktive edin.';
            return redirect()->route('admin.edit-game', $game->id)->withErrors($status_message);
        } elseif ($developer_status == 0) {
            $status_message = 'Oyunu aktive etmek için lütfen öncelikle <span class="font-weight-bold">geliştiricisini</span> aktive edin.';
            return redirect()->route('admin.edit-game', $game->id)->withErrors($status_message);
        } elseif ($publisher_status == 0) {
            $status_message = 'Oyunu aktive etmek için lütfen öncelikle <span class="font-weight-bold">dağıtıcısını</span> aktive edin.';
            return redirect()->route('admin.edit-game', $game->id)->withErrors($status_message);
        }

        $game_field_rules = [
            'name'         => 'required|max:255',
            'sub_title'    => 'required|max:255',
            'category_id'  => 'required',
            'developer_id' => 'required',
            'publisher_id' => 'required',
            'description'  => 'required|min:15',
        ];

        foreach ($game_fields as $game_field) {
            $game_data[$game_field] = $request->input($game_field);
        }

        $game_data['sub_title'] = ucfirst($request->sub_title);
        $game_data['slug']      = Str::slug($request->name);

        $validate_game_fields = Validator::make($game_data, $game_field_rules);

        if ($validate_game_fields->fails()) {
            return redirect()->route('admin.edit-game', $game_id)
                             ->withErrors($validate_game_fields)
                             ->withInput();
        }

        $game_detail_fields = [
            'release_date',
            'website',
            'age_rating'
        ];

        $game_detail_field_rules = [
            'release_date' => 'required',
            'website'      => 'required|max:255',
            'age_rating'   => 'required'
        ];

        foreach ($game_detail_fields as $detail_field) {
            $detail_data[$detail_field] = $request->input($detail_field);
        }

        $validate_game_detail_fields = Validator::make($detail_data, $game_detail_field_rules);

        if ($validate_game_detail_fields->fails()) {
            return redirect()->route('admin.edit-game', $game_id)
                             ->withErrors($validate_game_detail_fields)
                             ->withInput();
        }

        $game_platform_field_rules = [
            'platform_id.*' => 'required'
        ];

        $platform_data = $request->input('platform_id');

        $validate_game_platform_fields = Validator::make($platform_data, $game_platform_field_rules);

        if ($validate_game_platform_fields->fails()) {
            return redirect()->route('admin.edit-game', $game_id)
                             ->withErrors($validate_game_platform_fields)
                             ->withInput();
        }

        $game_genre_field_rules = [
            'genre_id.*' => 'required'
        ];

        $genre_data = $request->input('genre_id');

        $validate_game_genre_fields = Validator::make($genre_data, $game_genre_field_rules);

        if ($validate_game_genre_fields->fails()) {
            return redirect()->route('admin.edit-game', $game_id)
                             ->withErrors($validate_game_genre_fields)
                             ->withInput();
        }

        //validate image files
        $file_rules = [
            'cover_image' => 'image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'image1'      => 'image|mimes:jpeg,png,jpg,svg,webp|max:3092',
        ];

        $validate_file = Validator::make($request->file(), $file_rules);

        if ($validate_file->fails()) {
            return redirect()->route('admin.edit-game', $game_id)
                             ->withErrors($validate_file)
                             ->withInput();
        }

        //validate and system requirements fields
        $sys_req_min_fields = [
            'cpu_min',
            'gpu_min',
            'ram_min',
            'ram_min_unit',
            'storage_min',
            'storage_min_unit',
            'os_min'
        ];

        $sys_req_min_rules = [
            'cpu_min'          => 'required|max:255',
            'gpu_min'          => 'required|max:255',
            'ram_min'          => 'required|numeric',
            'ram_min_unit'     => 'required',
            'storage_min'      => 'required|numeric',
            'storage_min_unit' => 'required',
            'os_min'           => 'required|max:255',
        ];

        foreach ($sys_req_min_fields as $min_field) {
            $sys_req_min_data[$min_field] = $request->input($min_field);
        }

        $validate_sys_req_min_fields = Validator::make($sys_req_min_data, $sys_req_min_rules);

        if ($validate_sys_req_min_fields->fails()) {
            return redirect()->route('admin.edit-game', $game_id)
                             ->withErrors($validate_sys_req_min_fields)
                             ->withInput();
        }

        $sys_req_rec_fields = [
            'cpu_rec',
            'gpu_rec',
            'ram_rec',
            'ram_rec_unit',
            'storage_rec',
            'storage_rec_unit',
            'os_rec'
        ];

        $sys_req_rec_rules = [
            'cpu_rec'          => 'required|max:255',
            'gpu_rec'          => 'required|max:255',
            'ram_rec'          => 'required|numeric',
            'ram_rec_unit'     => 'required',
            'storage_rec'      => 'required|numeric',
            'storage_rec_unit' => 'required',
            'os_rec'           => 'required|max:255',
        ];

        foreach ($sys_req_rec_fields as $rec_field) {
            $sys_req_rec_data[$rec_field] = $request->input($rec_field);
        }

        $validate_sys_req_rec_fields = Validator::make($sys_req_rec_data, $sys_req_rec_rules);

        if ($validate_sys_req_rec_fields->fails()) {
            return redirect()->route('admin.edit-game', $game_id)
                             ->withErrors($validate_sys_req_rec_fields)
                             ->withInput();
        }

        //saving image files
        $file_data = [];
        $path      = public_path('uploads/games/') . Str::slug($request->name);

        //if the game images are to be relocated(if game name changes), copies the old pictures to the new folder, renames them and deletes the old ones
        if (!file_exists($path)) {
            $old_path = public_path('uploads/games/') . $game->slug;
            mkdir($path, 0777, true);
            $this->customCopy($old_path, $path);

            if ($game->cover_image) {
                $file_extension           = substr($game->cover_image, strpos($game->cover_image, '.'));
                $coverImageName           = Str::slug($request->name) . '-cover' . $file_extension;
                $file_data['cover_image'] = '/uploads/games/' . Str::slug($request->name) . '/' . $coverImageName;
                if (file_exists($old_path)) {
                    rename($old_path . '/' . $game->slug . '-cover' . $file_extension, $path . '/' . Str::slug($request->name) . '-cover' . $file_extension);
                    unlink($path . '/' . $game->slug . '-cover' . $file_extension);
                }
            }

            if ($game->image1) {
                $file_extension      = substr($game->image1, strpos($game->image1, '.'));
                $imageName           = Str::slug($request->name) . '-1' . $file_extension;
                $file_data['image1'] = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
                if (file_exists($old_path)) {
                    rename($old_path . '/' . $game->slug . '-1' . $file_extension, $path . '/' . Str::slug($request->name) . '-1' . $file_extension);
                    unlink($path . '/' . $game->slug . '-1' . $file_extension);
                }
            }

            $this::deleteDirWithFiles($old_path);
        }

        if ($request->hasFile('cover_image')) {
            $image          = $request->file('cover_image');
            $coverImageName = Str::slug($request->name) . '-cover.' . $request->cover_image->getClientOriginalExtension();
            Image::make($image->getRealPath())->resize(230, 300)->save($path . '/' . $coverImageName);
            $file_data['cover_image'] = '/uploads/games/' . Str::slug($request->name) . '/' . $coverImageName;
        }

        if ($request->hasFile('image1')) {
            $image     = $request->file('image1');
            $imageName = Str::slug($request->name) . '-1.' . $request->image1->getClientOriginalExtension();
            Image::make($image->getRealPath())->resize(1920, 1080)->save($path . '/' . $imageName);
            $file_data['image1'] = '/uploads/games/' . Str::slug($request->name) . '/' . $imageName;
        }

        $game->update($game_data);
        $game->update($file_data);

        $game->platforms()->sync($platform_data);
        $game->genres()->sync($genre_data);

        $game->details->update($detail_data);
        $game->systemReqMin->update($sys_req_min_data);
        $game->systemReqRec->update($sys_req_rec_data);

        //update or create game images
        $image_fields['path']       = $request->file('path');
        $image_fields['image_hash'] = $request->input('image_hash');
        $game_image_count           = $game->images->count();
        $image_hash_order           = 0;
        $image_hash_data            = [];

        if ($image_fields['path'] && $image_fields['image_hash']) {
            foreach ($image_fields['image_hash'] as $image_hash) {
                $image_hash_data[] = $image_hash;
            }

            foreach ($image_fields['path'] as $image_path) {
                $image_name = Str::slug($request->name) . '-' . $game_image_count + 2 . '.' . $image_path->getClientOriginalExtension();
                Image::make($image_path->getRealPath())->resize(1920, 1080)->save($path . '/' . $image_name);

                $image_data = [
                    'game_id'    => $game->id,
                    'path'       => '/uploads/games/' . Str::slug($request->name) . '/' . $image_name,
                    'image_hash' => \Str::random(20)
                ];

                GameImage::updateOrCreate(
                    [
                        'game_id'    => $game->id,
                        'image_hash' => $image_hash_data[$image_hash_order]
                    ],
                    $image_data
                );
                $game_image_count++;
                $image_hash_order++;
            }
        }

        //update or create game videos
        $video_fields['url']        = $request->input('url');
        $video_fields['video_hash'] = $request->input('video_hash');
        $video_hash_data            = [];
        $video_hash_order           = 0;

        if ($video_fields['url'] && $video_fields['video_hash']) {
            foreach ($video_fields['video_hash'] as $video_hash) {
                $video_hash_data[] = $video_hash;
            }

            foreach ($video_fields['url'] as $url) {
                $video_data = [
                    'game_id'    => $game->id,
                    'url'        => 'https://www.youtube.com/embed/' . $url,
                    'video_hash' => \Str::random(20)
                ];

                GameVideo::updateOrCreate(
                    [
                        'game_id'    => $game->id,
                        'video_hash' => $video_hash_data[$video_hash_order]
                    ],
                    $video_data
                );
                $video_hash_order++;
            }
        }

        return redirect()->route('admin.games')->with('message', 'Oyun Bilgileri Başarıyla Güncellendi.');
    }

    public static function destroy($id)
    {
        /**
         * @var Game $game
         */
        $game = Game::with('details', 'systemReqMin', 'systemReqRec', 'videos', 'images')->findOrFail($id);

        File::delete(public_path($game->cover_image));
        File::delete(public_path($game->image1));

        foreach ($game->images as $image) {
            if (File::exists(public_path($image->path))) {
                File::delete(public_path($image->path));
            }
            $image->delete();
        }

        $path = public_path('uploads/games/') . Str::slug($game->name);
        array_map('unlink', glob("$path/*.*"));
        if (File::exists($path) && is_dir($path)) {
            rmdir($path);
        }

        foreach ($game->videos as $video) {
            $video->delete();
        }

        $game->details->delete();
        $game->systemReqMin->delete();
        $game->systemReqRec->delete();
        $game->delete();

        return redirect()->route('admin.games')->with('message', 'Oyun Başarıyla Silindi.');
    }

    public function switchStatus(Request $request)
    {
        $game             = Game::findOrFail($request->id);
        $category_status  = $game->category->status;
        $developer_status = $game->developer->status;
        $publisher_status = $game->publisher->status;

        if ($category_status == 1 && $developer_status == 1 && $publisher_status == 1) {
            $game->status = $request->state == 'true' ? 1 : 0;
            $game->save();
            return [
                'result' => true
            ];
        } else {
            return [
                'result' => false
            ];
        }
    }

    public function deleteSingleImage(Request $request)
    {
        /**
         * @var Game      $game
         * @var GameImage $image_to_be_deleted
         */
        if ($request->ajax()) {
            $game                = Game::with('images')->find($request->game_id);
            $image_to_be_deleted = $game->images->where('image_hash', '=', $request->image_hash)->first();

            if (File::exists(public_path($image_to_be_deleted->path))) {
                File::delete(public_path($image_to_be_deleted->path));
            }

            if ($image_to_be_deleted) {
                $image_to_be_deleted->delete();
            }

            return [
                'message' => 'Resim başarıyla silindi.',
                'result'  => true
            ];
        } else {
            return [
                'message' => 'Resim silinirken hata oluştu.',
                'result'  => false
            ];
        }
    }

    public function deleteGameVideo(Request $request)
    {
        /**
         * @var Game      $game
         * @var GameVideo $video_to_be_deleted
         */
        if ($request->ajax()) {
            $game                = Game::with('videos')->find($request->game_id);
            $video_to_be_deleted = $game->videos->where('video_hash', '=', $request->video_hash)->first();

            if ($video_to_be_deleted) {
                $video_to_be_deleted->delete();
            }

            return [
                'message' => 'Video başarıyla silindi.',
                'result'  => true
            ];
        } else {
            return [
                'message' => 'Video silinirken hata oluştu.',
                'result'  => false
            ];
        }
    }

    public function customCopy($source, $destination)
    {
        $dir = opendir($source);

        while ($file = readdir($dir)) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($source . '/' . $file)) {
                    $this->customCopy($source . '/' . $file, $destination . '/' . $file);
                } else {
                    copy($source . '/' . $file, $destination . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public static function deleteDirWithFiles($dir_path)
    {
        if (!is_dir($dir_path)) {
            throw new \InvalidArgumentException("$dir_path bir klasör değil.");
        }
        if (substr($dir_path, strlen($dir_path) - 1, 1) != '/') {
            $dir_path .= '/';
        }
        $files = glob($dir_path . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDirWithFiles($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dir_path);
    }
}