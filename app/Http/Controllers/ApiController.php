<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiStoreUser;
use App\Http\Requests\ApiUpdateUser;
use App\Models\City;
use App\Models\Country;
use App\Models\Prod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class ApiController extends Controller
{

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getCountry()
    {
        $countries = Country::get();
        return response()->json($countries);
    }

    public function store(Request $request)
    {
        dd($request->all());
        if ($request->id == null) {
            $user = new User;
//            $user->hobbies = implode(',', $request->chk);
            $filename = time() . '-jsk.' . $request->file('profile')->getClientOriginalExtension();
            //$register->profile =
            $request->file('profile')->storeAs('public/uploads', $filename);
            $user->profile_photo = $filename;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->gender = $request->gender;

//        $user->hobbies = implode(',', $request->chk);


        // dd($user);
        $user->save();
        return $user;

    }

    public function show($user, $cityId)
    {
        $details = User::find($user);
        $country = City::with('state')->find($cityId);
        $countries = Country::all();
        $cities = City::all();
        $data = [
            'details' => $details,
            'country' => $country,
            'countries' => $countries,
            'cities' => $cities,
        ];
        return response()->json($data);
    }

    public function update(ApiUpdateUser $request)
    {
//        return $request->all();
        $user = User::find($request->id);
        $file = public_path("/storage/uploads/" . User::where('id', $request->id)->first()->profile_photo);
        if ($request->has('profile')) {
            if (File::exists($file)) {
                File::delete($file);
            }
            $filename = time() . '-jsk.' . $request->file('profile')->getClientOriginalExtension();
            //$user->profile =
            $request->file('profile')->storeAs('public/uploads', $filename);
            $user->profile_photo = $filename;


        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->gender = $request->gender;
        // dd($user);
        $user->update();
        return $user;
    }

//        return $user;
//        $user->update([
//            'name' => $user->name,
//            'phone' => $user->phone,
//            'city' => $user->city,
//            'gender'=>$user->gender,
//        ]);
////        dd($user);
//        return response()->json([
//            "message" => "Record Updated successfully",
//            'status' => true,
//            'user' => $user,
//        ], 200);


    public
    function destroy(User $user
    ) {
//        return $user;
        $user->delete();
        return response()->json([
            "message" => "Record Deleted successfully",
            'status' => true,
        ]);
    }

}
