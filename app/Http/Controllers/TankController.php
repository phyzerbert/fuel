<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tank;
use App\Models\Fuel;
use App\Models\Location;
use App\User;

class TankController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        config(['site.page' => 'tank']);
        $fuels = Fuel::all();
        $locations = Location::all();
        $users = User::where('role_id', 2)->get();
        $data = Tank::get();
        return view('admin.tank', compact('data', 'fuels', 'users', 'locations'));
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required',
            'fuel'=>'required',
            'capacity'=>'required',
        ]);
        $item = Tank::find($request->get("id"));
        $item->name = $request->get("name");
        $item->fuel_id = $request->get("fuel");
        $item->capacity = $request->get("capacity");
        $item->location_id = $request->get("location");
        $item->user_id = $request->get("user");
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|string',
            'fuel'=>'required',
            'capacity'=>'required',
        ]);
        
        Tank::create([
            'name' => $request->get('name'),
            'fuel_id' => $request->get('fuel'),
            'capacity' => $request->get('capacity'),
            'location_id' => $request->get('location'),
            'user_id' => $request->get('user'),
        ]);
        return back()->with('success', 'Created Successfully');
    }

    public function delete($id){
        $item = Tank::find($id);
        if(!$item){
            return back()->withErrors(["delete" => 'Something went wrong.']);
        }
        $item->delete();
        return back()->with("success", 'Deleted Successfully');
    }
}
