<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    //
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
    public function adminHome(){
        $data = [];

        $data['countProducts'] = DB::table('products')->count();
        $data['countCategories'] = DB::table('category')->count();
        $data['countOrders'] = DB::table('orders')->count();
        $countUser = DB::table('users')->select(DB::raw('count(*) as user_count, is_admin'))
        ->where('is_admin', '<>', 1)
        ->groupBy('is_admin')
        ->get();

        $data['countUser'] = $countUser[0]->user_count;

        return view('backend.dashboard.home', $data); 
    }
}
