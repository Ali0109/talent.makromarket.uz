<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\File;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index() {
        // Если юзер авторизовался через 10 минут после лайка
        if(Cookie::get('talent_id')) {
            $talent_id = Cookie::get('talent_id');
            return redirect()->route('auth.user.like_talent', ['talent_id' => $talent_id])->withCookie(Cookie::forget('talent_id'));
        }
        // Если юзер уже отправил свой талант
        if(Talent::where('user_id', Auth::id())->first()) {
            return redirect()->route('auth.user.success_talent')->with('success', __('home.file.talent_has'));
        }

        $user = User::where('id', Auth::id())->with('phone')->first();
        return view('auth.user.home.index', compact('user'));
    }

    public function fileStore(Request $request) {
        if(count($request->file('file')) == 1) {
            $request->validate([
                'description' => 'required',
                'file.*' => 'required|max:50000|mimes:png,jpg,jpeg,svg,mp3,aac,mp4,mkv,ogx,oga,ogv,ogg,webm',
            ],[
                'file.*.required' => __('home.file.required'),
                'file.*.mimes' => __('home.file.1.mimes'),
                'file.*.max' => __('home.file.max'),
            ]);
        } else {
            $request->validate([
                'description' => 'required',
                'file.*' => 'required|max:50000|mimes:png,jpg,jpeg,svg',
            ],[
                'file.*.required' => __('home.file.required'),
                'file.*.mimes' => __('home.file.*.mimes'),
                'file.*.max' => __('home.file.max'),
            ]);
        }
        $files = $request->file('file');

        foreach ($files as $file) {
            $size = $file->getSize();
            $full_name = Str::random('10') . "_" . $file->getClientOriginalName();
            $name = explode(".", $full_name)[0];
            $extension = $file->extension();
            $mime_type = $file->getClientMimeType();

            if(in_array($extension, ['png','jpg','jpeg','svg'])) {
                $src = "upload/photo";
            } else if(in_array($extension, ['mp3','aac'])) {
                $src = "upload/audio";
            } else if(in_array($extension, ['mp4','mkv','ogx','oga','ogv','ogg','webm'])) {
                $src = "upload/video";
            } else {
                return back()->withErrors([
                    'file' => __('home.file.error'),
                ]);
            }

            $file->move($src, $full_name);

            $talent = Talent::where('user_id', Auth::id())->first();

            if($talent) {
                File::create([
                    'model_type' => 'App\Models\Talent',
                    'model_id' => $talent->id,
                    'size' => $size,
                    'src' => $src,
                    'mime_type' => $mime_type,
                    'name' => $name,
                    'full_name' => $full_name,
                    'extension' => $extension,
                    'disk' => 'public',
                ]);
            } else {
                $description = $request->input('description');
                $create_talent = Talent::create([
                    'user_id' => Auth::id(),
                    'description' => $description,
                ]);

                File::create([
                    'model_type' => 'App\Models\Talent',
                    'model_id' => $create_talent->id,
                    'size' => $size,
                    'src' => $src,
                    'mime_type' => $mime_type,
                    'name' => $name,
                    'full_name' => $full_name,
                    'extension' => $extension,
                    'disk' => 'public',
                ]);
            }
        }

        return redirect()->route('auth.user.success_talent')->with('success', __('home.file.success'));
    }

    public function successTalent() {
        return view('auth.user.success_message');
    }

    public function likeTalent($talent_id) {
        $user_id = Auth::id();

        $user = User::where('id', $user_id)->first();
        $talent = Talent::where('id', $talent_id)->first();
        if($user->like > 0) {
            return redirect()->route('auth.user.success_talent')->with('error', __('home.file.error_like_disable'));
        } else {
            $talent_likes = $talent->likes_count;
            Talent::where('id', $talent_id)->update([
                'likes_count' => $talent_likes + 1,
            ]);

            User::where('id', $user->id)->update([
                'like' => $talent_id
            ]);

            return redirect()->route('auth.user.success_talent')->with('success', __('home.file.like_successfully'));
        }
    }
}
