<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminPanelController extends Controller
{
    public function index(){

        if($user = Auth::user()){
            return view('admin.admin-panel', compact('user'));
        }

        return redirect()->route('home');
    }


    public function dashboard(){

        if($user = Auth::user()){
            return view('admin.dashboard', compact('user'));
        }

        return redirect()->route('home');
    }

    public function product(){

        if($user = Auth::user()){
            return redirect()->route('products.index');
        }

        return redirect()->route('home');
    }

    public function order(){

        if($user = Auth::user()){
            return redirect()->route('orders.index');
        }

        return redirect()->route('home');
    }

    public function config(){

        if($user = Auth::user()){
            return redirect()->route('configs.index');
        }

        return redirect()->route('home');
    }
}
