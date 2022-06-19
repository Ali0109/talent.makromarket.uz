<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $talents = Talent::with('user')
            ->get();

        return view('auth.admin.home.index', compact('talents'));
    }
}
