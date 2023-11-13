<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    public function index()
    {
        $admins = User::where('admin', true)->get();
        return view('admin.users.admins', compact('admins'));
    }
}
