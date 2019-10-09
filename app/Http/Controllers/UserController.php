<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Location;
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
        $locations = Location::all();
        $tanks = Tank::all();
        $mod = new User();
        $name = $location_id = $tank_id = '';
        if($request->location_id != ''){
            $location_id = $request->get('location_id');
            $mod = $mod->where('location_id', $location_id);
        }
        if($request->tank_id != ''){
            $tank_id = $request->get('tank_id');
            $tank = Tank::find($tank_id);
            $mod = $mod->where('id', $tank->user_id);
        }
        if ($request->get('name') != ""){
            $name = $request->get('name');
            $mod = $mod->where(function($query) use($name) {
                return $query->where('name', 'LIKE', "%$name%")
                            ->orWhere('surname', 'LIKE', "%$name%");
            });                    
        }
        $pagesize = session('pagesize');
        if(!$pagesize){$pagesize = 15;}
        $data = $mod->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('admin.users', compact('data', 'locations', 'tanks', 'location_id', 'tank_id', 'name'));
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
        $user->surname = $request->get("surname");
        $user->location_id = $request->get("location_id");

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
            'name'=>'required|string',
            'password'=>'confirmed'
        );
        $user = User::find($request->get("id"));
        if($user->hasRole('user')){
            $validate_array['tank'] = 'required';
        }
        $request->validate($validate_array);
        
        $user->name = $request->get("name");
        $user->surname = $request->get("surname");
        $user->location_id = $request->get("location");

        if($request->get('password') != ''){
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();
        Tank::find($request->tank)->update(['user_id' => $user->id]);
        return response()->json('success');
    }

    public function create(Request $request){
        $validate_array = array(
            'name'=>'required|string|unique:users',
            'role'=>'required',
            'password'=>'required|string|min:6|confirmed'
        );
        if($request->get('role') == 3){
            $validate_array['tank'] = 'required';
        }
        $request->validate($validate_array);
        
        $user = User::create([
                'name' => $request->get('name'),
                'surname' => $request->get('surname'),
                'location_id' => $request->get('location'),
                'role_id' => $request->get('role'),
                'password' => Hash::make($request->get('password'))
            ]);
        Tank::find($request->tank)->update(['user_id' => $user->id]);
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
