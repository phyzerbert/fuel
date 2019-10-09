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
        $units = Unit::all();
        $tanks = Tank::all();
        $mod = new User();
        $unit_id = $name = $phone_number = '';
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
        $request->validate([
            'name'=>'required',
            'password' => 'confirmed',
        ]);
        $user = User::find($request->get("id"));
        $user->name = $request->get("name");
        $user->unit_id = $request->get("unit_id");
        if($user->hasRole('user')){
            $user->tank_id = $request->get("tank_id");
        }       

        if($request->get('password') != ''){
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();
        return response()->json('success');
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|string|unique:users',
            'role'=>'required',
            'password'=>'required|string|min:6|confirmed'
        ]);
        
        User::create([
            'name' => $request->get('name'),
            'unit_id' => $request->get('unit_id'),
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
