<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        config(['site.page' => 'driver']);
        $data = Driver::all();
        return view('admin.driver', compact('data'));
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $item = Driver::find($request->get("id"));
        $item->name = $request->get("name");
        $item->surname = $request->get("surname");
        $item->national_id = $request->get("national_id");
        $item->social_number = $request->get("social_number");
        $item->mobile = $request->get("mobile");
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|string',
        ]);
        Driver::create([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'national_id' => $request->get('national_id'),
            'social_number' => $request->get('social_number'),
            'mobile' => $request->get('mobile'),
        ]);
        return back()->with('success', 'Created Successfully');
    }

    
    public function ajax_create(Request $request){
        $request->validate([
            'name'=>'required|string',
        ]);
        
        $driver = Driver::create([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'national_id' => $request->get('national_id'),
            'social_number' => $request->get('social_number'),
            'mobile' => $request->get('mobile'),
        ]);
        return response()->json($driver);
    }

    public function delete($id){
        $item = Driver::find($id);
        if(!$item){
            return back()->withErrors(["delete" => 'Something went wrong.']);
        }
        $item->delete();
        return back()->with("success", 'Deleted Successfully');
    }
}
