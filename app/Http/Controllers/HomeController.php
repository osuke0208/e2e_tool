<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
      $id = Auth::user()->id;
      return redirect('/home/'.$id);
    }

    public function home(){
      $data_array = [
        'id' => Auth::user()->id,
        'name' => Auth::user()->name,
      ];
      return view('home',$data_array);
    }
}
