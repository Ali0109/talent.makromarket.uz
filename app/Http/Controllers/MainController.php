<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Http\Request;


class MainController extends Controller
{
    public function members() {
        $talents = Talent::with('user')
            ->get();
        return view('members', compact('talents'));
    }

    public function talents ($user_id) {
        $user = User::where('id', $user_id)->first();
        $talent = Talent::where('user_id', $user_id)
            ->with('user')
            ->first();
        $files = File::where('model_id', $talent->id)
            ->get();

        return view('talents', compact('user', 'files','talent'));
    }

    public function likeTalentCookie(Request $request) {
        $talent_id = $request->input('talent_id');
        $minute = 10;

        return redirect()->route('login')->withCookie(cookie('talent_id', $talent_id, $minute));
    }
}
