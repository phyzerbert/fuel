<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tank;
use App\Models\Fuel;

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
        $data = Tank::get();
        return view('admin.settings.tank', compact('data', 'fuels'));
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required',
            'fuel'=>'required',
            'capacity'=>'required',
            'low_level'=>'required',
        ]);
        $item = Tank::find($request->get("id"));
        $item->name = $request->get("name");
        $item->fuel_id = $request->get("fuel");
        $item->capacity = $request->get("capacity");
        $item->low_level = $request->get("low_level");
        $item->description = $request->get("description");
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|string',
            'fuel'=>'required',
            'capacity'=>'required',
            'low_level'=>'required',
        ]);
        
        Tank::create([
            'name' => $request->get('name'),
            'fuel_id' => $request->get('fuel'),
            'capacity' => $request->get('capacity'),
            'low_level' => $request->get('low_level'),
            'description' => $request->get('description'),
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
