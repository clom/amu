<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(Auth::user()->checkAdmin())
            return view('admin.index');
        else
            return abort(403, 'Forbitten!');
    }

    public function place(){
        if(Auth::user()->checkAdmin())
            return view('admin.place');
        else
            return abort(403, 'Forbitten!');
    }

    public function schedule(){
        if(Auth::user()->checkAdmin())
            return view('admin.schedule');
        else
            return abort(403, 'Forbitten!');
    }

    public function timeline(){
        if(Auth::user()->checkAdmin())
            return view('admin.timeline');
        else
            return abort(403, 'Forbitten!');
    }

    public function information(){
        if(Auth::user()->checkAdmin())
            return view('admin.info');
        else
            return abort(403, 'Forbitten!');
    }


    public function changeAdmin(){
        if(Auth::user()->checkAdmin())
            return view('admin.changeadmin');
        else
            return abort(403, 'Forbitten!');
    }


}
