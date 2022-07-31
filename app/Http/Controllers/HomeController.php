<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Salon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role > 9) {
            $salons = Salon::all();
            return view('back.salons.index', ['salons'=> $salons]);
        }
        if (Auth::user()->role < 9 && Auth::user()->role >= 1) {
            $salons = Salon::all();
            return view('front.salons', ['salons' => $salons]);
        }
        if (Auth::user()->role < 1) {
            return view('auth.login');
        }
        
    }
}
