<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unloading;
use App\Models\Vehicle;

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
    public function index(Request $request)
    {
        config(['site.page' => 'home']);

        $limit = 10;
        $period_range = array();
        $period = '';
        $vehicles = Vehicle::all();

        if($request->get('period') != ''){
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
            $period_range = [$from, $to];
        }

        $vehicles_data = $vehicles->sortByDesc(function ($vehicles) use($period_range) {
                        $mod = $vehicles->unloadings();
                        if(count($period_range)){
                            $mod = $mod->whereBetween('unloading_date', $period_range);
                        }
                        return $mod->sum('amount');
                    })->take($limit);
        return view('home', compact('vehicles_data', 'period'));
    }

    public function set_pagesize(Request $request){
        $pagesize = $request->get('pagesize');
        if($pagesize == '') $pagesize = 100000;
        $request->session()->put('pagesize', $pagesize);
        return back();
    }
}
