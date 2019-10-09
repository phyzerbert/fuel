<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\City;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        config(['site.page' => 'location']);
        $cities = City::all();
        $data = Location::get();
        return view('admin.location', compact('data', 'cities'));
    }

    public function edit(Request $request){
        $request->validate([
            'city'=>'required',
        ]);
        $item = Location::find($request->get("id"));
        $item->city_id = $request->get("city");
        $item->district = $request->get("district");
        $item->distance_to_hq = $request->get("distance_to_hq");
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function create(Request $request){
        $request->validate([
            'city'=>'required',
        ]);
        
        Location::create([
            'city_id' => $request->get('city'),
            'district' => $request->get('district'),
            'distance_to_hq' => $request->get('distance_to_hq'),
        ]);
        return back()->with('success', 'Created Successfully');
    }

    public function delete($id){
        $item = Location::find($id);
        if(!$item){
            return back()->withErrors(["delete" => 'Something went wrong.']);
        }
        $item->delete();
        return back()->with("success", 'Deleted Successfully');
    }

    public function city_index()
    {
        config(['site.page' => 'city']);
        $data = City::get();
        return view('admin.city', compact('data'));
    }

    public function city_edit(Request $request){
        $request->validate([
            'city'=>'required',
        ]);
        $item = City::find($request->get("id"));
        $item->name = $request->get("name");
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function city_create(Request $request){
        $request->validate([
            'city'=>'required',
        ]);
        
        City::create([
            'name' => $request->get('name'),
        ]);
        return back()->with('success', 'Created Successfully');
    }

    public function city_delete($id){
        $item = City::find($id);
        if(!$item){
            return back()->withErrors(["delete" => 'Something went wrong.']);
        }
        $item->delete();
        return back()->with("success", 'Deleted Successfully');
    }
}
