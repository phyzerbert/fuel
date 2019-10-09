<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Fuel;
use App\Models\VehicleType;
use App\Models\Driver;

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
        $vehicle_types = VehicleType::all();
        $drivers = Driver::all();
        $mod = new Vehicle();

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.vehicle', compact('data', 'fuels', 'vehicle_types', 'drivers'));
    }

    public function edit(Request $request){
        $request->validate([
            'plate'=>'required',
            'fuel' => 'required',
            'driver' => 'required',
        ]);
        $item = Vehicle::find($request->get("id"));
        $item->plate = $request->get("plate");
        $item->model = $request->get("model");
        $item->brand = $request->get("brand");
        $item->capacity = $request->get("capacity");
        $item->fuel_id = $request->get("fuel");
        $item->vehicle_type_id = $request->get("type");
        $item->driver_id = $request->get("driver");
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function create(Request $request){
        $request->validate([
            'plate'=>'required',
            'fuel' => 'required',
            'driver' => 'required',
        ]);
        
        Vehicle::create([
            'plate' => $request->get('plate'),
            'model' => $request->get('model'),
            'brand' => $request->get('brand'),
            'capacity' => $request->get('capacity'),
            'fuel_id' => $request->get('fuel'),
            'vehicle_type_id' => $request->get('type'),
            'driver_id' => $request->get('driver'),
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
