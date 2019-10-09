<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Unit;
use App\Models\Tank;

use Auth;
use Hash;

class UserController extends Controller
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
        config(['site.page' => 'user']);
        $user = Auth::user();
        $units = Unit::all();
        $tanks = Tank::all();
        $mod = new User();
        if($user->unit){
            $mod = $user->unit->users();
        }
        $unit_id = $name = '';
        if ($request->get('unit_id') != ""){
            $unit_id = $request->get('unit_id');
            $mod = $mod->where('unit_id', "$unit_id");
        }
        if ($request->get('name') != ""){
            $name = $request->get('name');
            $mod = $mod->where('name', 'LIKE', "%$name%");
        }
        $pagesize = session('pagesize');
        if(!$pagesize){$pagesize = 15;}
        $data = $mod->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('admin.users', compact('data', 'units', 'tanks', 'unit_id', 'name', 'phone_number'));
    }

        
    public function profile(Request $request){
        $user = Auth::user();
        config(['site.page' => 'profile']);
        $units = Unit::all();
        return view('profile', compact('user', 'units'));
    }

    public function updateuser(Request $request){
        $request->validate([
            'name'=>'required',
            'password' => 'confirmed',
        ]);
        $user = Auth::user();
        $user->name = $request->get("name");
        $user->first_name = $request->get("first_name");
        $user->last_name = $request->get("last_name");

        if($request->get('password') != ''){
            $user->password = Hash::make($request->get('password'));
        }

        if($request->has("picture")){
            $picture = request()->file('picture');
            $imageName = time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/profile_pictures'), $imageName);
            $user->picture = 'images/profile_pictures/'.$imageName;
        }
        $user->update();
        return back()->with("success", 'Updated Successfully');
    }

    public function edituser(Request $request){
        $validate_array = array(
            'name'=>'required|string|unique:users',
            'password'=>'confirmed'
        );
        $user = User::find($request->get("id"));
        if($user->hasRole('admin')){
            $validate_array['unit'] = 'required';
        }
        if($user->hasRole('user')){
            $validate_array['unit'] = 'required';
            $validate_array['tank'] = 'required';
        }
        $request->validate($validate_array);
        
        $user->name = $request->get("name");
        $user->unit_id = $request->get("unit");
        $user->first_name = $request->get("first_name");
        $user->last_name = $request->get("last_name");
        $user->tank_id = $request->get("tank");

        if($request->get('password') != ''){
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();
        return response()->json('success');
    }

    public function create(Request $request){
        $validate_array = array(
            'name'=>'required|string|unique:users',
            'role'=>'required',
            'password'=>'required|string|min:6|confirmed'
        );
        if($request->get('role') == 2){
            $validate_array['unit'] = 'required';
        }
        if($request->get('role') == 3){
            $validate_array['unit'] = 'required';
            $validate_array['tank'] = 'required';
        }
        $request->validate($validate_array);
        
        User::create([
            'name' => $request->get('name'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'unit_id' => $request->get('unit'),
            'tank_id' => $request->get('tank'),
            'role_id' => $request->get('role'),
            'password' => Hash::make($request->get('password'))
        ]);
        return response()->json('success');
    }

    public function approve($id){
        $user = User::find($id);
        if($user->status == 0){
            $user->status = 1;
        }else {
            $user->status = 0;
        }
        $user->save();
        return back()->with("success", 'Updated Successfully');
    }
    
    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return back()->with("success", 'Delete Successfully');
    }

}
