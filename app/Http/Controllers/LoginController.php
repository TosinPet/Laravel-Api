<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function welcome()
    {
        try
        {
            return view('welcome');
        } catch(\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
    public function login()
    {
        try
        {
            return view('login');
        } catch(\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function privacy()
    {
        try
        {
            return view('privacy');
        } catch(\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
