<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Unloading;
use App\Models\Unit;
use App\Models\Tank;
use App\Models\Vehicle;
use App\User;

use Auth;

class UnloadingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        config(['site.page' => 'unloading']);
        $units = Unit::all();
        $tanks = Tank::all();
        $users = User::where('role_id', '3')->get();
        $user = Auth::user();
        $vehicles = Vehicle::all();
        $user_vehicles = Vehicle::all();
        $reference_no = $tank_id = $vehicle_id = $user_id = $period = '';
        $mod = new Unloading();

        if($user->hasRole('user')){
            if($user->tank){
                $user_vehicles = Vehicle::where('fuel_id', $user->tank->fuel_id)->get();
            }
        }

        if($request->get('reference_no') != ''){
            $reference_no = $request->get('reference_no');
            $mod = $mod->where('reference_no', 'like', "%$reference_no%");
        }

        if($request->get('user_id') != ''){
            $user_id = $request->get('user_id');
            $mod = $mod->where('user_id', $user_id);
        }

        if($request->get('tank_id') != ''){
            $tank_id = $request->get('tank_id');
            $mod = $mod->where('tank_id', $tank_id);
        }

        if($request->get('vehicle_id') != ''){
            $vehicle_id = $request->get('vehicle_id');
            $mod = $mod->where('vehicle_id', $vehicle_id);
        }
        
        if($request->has('period') && $request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
            $mod = $mod->whereBetween('unloading_date', [$from, $to]);
        }
        
        $pagesize = session('pagesize');
        $data = $mod->orderBy('unloading_date', 'desc')->paginate($pagesize);
        $total_amount = $mod->sum('amount');
        return view('unloading.index', compact('data', 'units', 'tanks', 'users', 'vehicles', 'user_vehicles', 'reference_no', 'tank_id', 'vehicle_id', 'user_id', 'period', 'total_amount'));
    }

    public function edit(Request $request){
        $request->validate([
            'reference_no'=>'required|string',
            'date' => 'required',
            'amount' => 'required',
        ]);
        $data = $request->all();
        $user = Auth::user();
        $item = Unloading::find($request->get("id"));
        $item->reference_no = $data['reference_no'];
        $item->unloading_date = $data['date'];
        $item->vehicle_id = $data['vehicle'];
        $item->amount = $data['amount'];
        $item->description = $data['description'];
        if($request->file('attachment') != null){
            $attachment = request()->file('attachment');
            $imageName = time().'.'.$attachment->getClientOriginalExtension();
            $attachment->move(public_path('images/uploaded/unloading_files'), $imageName);
            $item->attachment = 'images/uploaded/unloading_files/'.$imageName;
        }
        $item->save();
        return response()->json('success');
    }

    public function create(Request $request){
        $request->validate([
            'reference_no'=>'required|string',
            'date' => 'required',
            'amount' => 'required',
        ]);

        $data = $request->all();
        $user = Auth::user();
        if(!$user->hasRole('user')) {
            return response()->json('error');
        }
        $item = new Unloading();
        $item->reference_no = $data['reference_no'];
        $item->unloading_date = $data['date'];
        $item->unit_id = $user->unit_id;
        $item->user_id = $user->id;
        $item->tank_id = $user->tank_id;
        $item->vehicle_id = $data['vehicle'];
        $item->amount = $data['amount'];
        $item->description = $data['description'];
        if($request->file('attachment') != null){
            $attachment = request()->file('attachment');
            $imageName = time().'.'.$attachment->getClientOriginalExtension();
            $attachment->move(public_path('images/uploaded/unloading_files'), $imageName);
            $item->attachment = 'images/uploaded/unloading_files/'.$imageName;
        }
        $item->save();
        
        return response()->json('success');
    }

    public function delete($id){
        $item = Unloading::find($id);
        if(!$item){
            return back()->withErrors(["delete" => 'Something went wrong.']);
        }
        $item->delete();
        return back()->with("success", 'Deleted Successfully');
    }
}
