<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Fuel;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        config(['site.page' => 'vehicle']);
        $fuels = Fuel::all();
        $data = Vehicle::get();
        return view('admin.settings.vehicle', compact('data', 'fuels'));
    }

    public function edit(Request $request){
        $request->validate([
            'number'=>'required',
            'fuel' => 'required',
            'driver' => 'required',
        ]);
        $item = Vehicle::find($request->get("id"));
        $item->number = $request->get("number");
        $item->fuel_id = $request->get("fuel");
        $item->type = $request->get("type");
        $item->driver = $request->get("driver");
        $item->description = $request->get("description");
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function create(Request $request){
        $request->validate([
            'number'=>'required',
            'fuel' => 'required',
            'driver' => 'required',
        ]);
        
        Vehicle::create([
            'number' => $request->get('number'),
            'fuel_id' => $request->get('fuel'),
            'type' => $request->get('type'),
            'driver' => $request->get('driver'),
            'description' => $request->get('description'),
        ]);
        return back()->with('success', 'Created Successfully');
    }

    public function delete($id){
        $item = Vehicle::find($id);
        if(!$item){
            return back()->withErrors(["delete" => 'Something went wrong.']);
        }
        $item->delete();
        return back()->with("success", 'Deleted Successfully');
    }
}
