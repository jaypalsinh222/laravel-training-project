<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\Capital;
use App\Models\City;
use App\Models\Country;
use App\Models\Image;
use App\Models\Post;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Psy\Readline\Hoa\Console;
use Yajra\DataTables\Facades\DataTables;
use function GuzzleHttp\Promise\all;

class UserController extends Controller
{

    public function test(Request $request)
    {
        dd($request->test);
    }

    public function index()
    {
        $details = null;
        $countries = Country::all();
        $roles = Role::all();
        $role = [''];
        return view('index', compact('countries', 'details', 'roles', 'role'));
    }


    public function getState(Request $request)
    {
        $state = State::where('county_id', $request->cid)->get();
        $html = '<option value="">Select State</option>';
        foreach ($state as $list) {
            $html .= '<option {{ old("state")== "' . $list->name . '" ? "selected" : "" }} value="' . $list->id . '">' . $list->name . '</option>';
        }
        return $html;
    }

    public function getCity(Request $request)
    {

        $city = City::where('state_id', $request->sid)->get();
        $html = '<option value="">Select City</option>';
        foreach ($city as $list) {
            $html .= '<option {{ old("city")== "' . $list->name . '" ? "selected" : "" }} value="' . $list->id . '">' . $list->name . '</option>';
        }
        return $html;
    }

    public function store(Request $request)
    {

        if ($request->id == null) {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => '',
                'phone' => 'required',
                'city' => 'required',
                'gender' => 'required',
            ]);
            $user = new User;
            $user->hobbies = implode(',', $request->chk);
//            dd($user->hobbies);
            $filename = time() . '-jsk.' . $request->file('profile')->getClientOriginalExtension();
            $request->file('profile')->storeAs('public/uploads', $filename);
            $user->profile_photo = $filename;
            $user->hobbies = implode(',', $request->chk);
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'city' => 'required',
                'gender' => 'required',
            ]);
            $user = User::find($request->id);
            if ($request->has('profile')) {
            $file = public_path("/storage/uploads/" . User::where('id', $request->id)->first()->profile_photo);
                if (File::exists($file)) {
                    File::delete($file);
                }
                $filename = time() . '-jsk.' . $request->file('profile')->getClientOriginalExtension();
                $request->file('profile')->storeAs('public/uploads', $filename);
                $user->profile_photo = $filename;
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verification = '1';
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->gender = $request->gender;
        $user->assignRole($request->role);
        $user->save();
        return $user;
    }

    public function show(Request $request)
    {
        $data = User::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                             ->addIndexColumn()
                             ->editColumn('name', 'Hi {{$name}}!')
                             ->addColumn('gender', function ($row) {
                                 $gender = config('constant.gender');
                                 return $gender[$row->gender] ?? '';
                             })
                             ->addColumn('city', function ($row) {
                                 $cities = City::get();
                                 foreach ($cities as $city) {
                                     if ($row->city == $city->id) {
                                         return $city->name;
                                     }
                                 }
                             })
                             ->addColumn('action', function ($row) {
                                 return '<td><a href="javascript:void(0)" class="edit btn btn-primary btn-sm ">View</a>
                                             <a href="' . route("get.user.details", ['id' => $row->id, 'cityId' => $row->city]) . '" class="edit btn btn-info btn-sm editRegister" data-id="' . $row->id . '">Edit</a>
                                             <a href="javascript:void(0)"  class="edit btn btn-danger btn-sm deleteRegister" data-id="' . $row->id . '">Delete</a>
                                         </td>';
                             })
                             ->addColumn('profile', function ($row) {
                                 return '<img  src="' . asset('storage/uploads/' . $row->profile_photo) . '" height="50px" width="50px" />';
                             })
                             ->rawColumns(['gender', 'city', 'profile', 'action'])
                             ->make(true);
        }
        return view('listregister');
    }

    public function delete($id)
    {
        User::find($id)->delete();
        return view('listregister');
    }

    public function getUserDetails(Request $request, $id, $cityId)
    {


        // dd($country);
//        ----for learning relationship

        //return $city = City::with('country')->find(5);
        //------hasOneThrough
        //return $city = City::with('country')->find($cityId);
        //dd($countries);

        //------hasManyThrough
        //return $city = Country::find(1)->cities;

        // $country = City::with('state')->find(1);

        //---------end learning
        //dd($country);

        $country = City::with('state')->find($cityId);
        $countries = Country::all();
        $roles = Role::get();
        $cities = City::all();
        $details = User::find($id);
//            dd($details->getRoleNames()->all());
        $role = $details->getRoleNames()->all();
        //        dd(\auth()->user());
//        if (Gate::allows('super-admin')) {
        return view('index', compact('details', 'cities', 'country', 'countries', 'roles', 'role'));
//        }
//        abort(403);
    }

    public function relation($id)
    {
        //oneToOne
        //return $state = City::with('state')->find($id);
        //return $state = Capital::with('state')->find($id);
        //return $capital = State::with('capital')->find($id);
        //----------------------------------------------

        //OneToMany
        //return $cities = State::with('cities')->find($id);
        //ManyToOne
        //return $country = State::with('country')->find($id);

        //------------------------------------------------
        // hasOneThrough
        //return $country = Country::with('cities')->find($id);
        //return $country = City::with('state')->find($id);

        //------hasManyThrough
        // return $city = Country::find(1)->cities;

        //manyToMany
//        $user = User::find($id);
//        $user->roles()->attach(1);

        //user get multiple roles
        //return $data = User::with('roles')->find($id);

        //role get multiple users
        //return $data = Role::with('users')->find($id);

        //oneToOne(polymorphic) insert data to images table
//        $post = Post::find($id);
//        $image = new Image;
//        $image->url = "hello1.jpg";
//        $post->image()->save($image);

        //oneToOne(polymorphic) insert data to images table
//        $user = User::find($id);
//        $image = new Image;
//        $image->url = "hello.jpg";
//        $user->image()->save($image);

        //retrieve data of posts
//        return $post = Post::with('image')->find(1);
//        return $image = $post->image;

        //retrieve data of users
//        return $user = User::with('image')->find($id);

        //OneOfMany
        //return $post = Post::with('images')->find($id);
    }

    public function logout()
    {
        session()->pull('user');

//        dd(session()->get('username'));
        return redirect()->route('login');
    }

    public function import()
    {
        $import = Excel::import(new UsersImport(), request()->file('file'));
//        dd($user);
        if ($import) {
            return back()->with("success", "Import Success");
        } else {
            return back()->with("fail", "Some Issue");
        }
    }


    public function apiTest()
    {
        return User::find(101);
    }

    public function testHttp()
    {
//        dump(Http::get(env('ASSET_URL').'users'));
        $data = Http::get(env('ASSET_URL') . 'user/' . '118');
//        dd($data->json());
        return $data->json();
//        $data = $response->json();
//        $data1 = Arr::pluck($data,'title');
//        dd($data1);
    }

    public function demo()
    {
        return response()->json(['id' => '1']);
    }

}
