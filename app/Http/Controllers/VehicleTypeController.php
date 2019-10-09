<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleType;

class VehicleTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        config(['site.page' => 'vehicle_type']);
        $data = VehicleType::get();
        return view('admin.vehicle_type', compact('data'));
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $item = VehicleType::find($request->get("id"));
        $item->name = $request->get("name");
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|string',
        ]);
        
        VehicleType::create([
            'name' => $request->get('name'),
        ]);
        return back()->with('success', 'Created Successfully');
    }

    public function delete($id){
        $item = VehicleType::find($id);
        if(!$item){
            return back()->withErrors(["delete" => 'Something went wrong.']);
        }
        $item->delete();
        return back()->with("success", 'Deleted Successfully');
    }
}
