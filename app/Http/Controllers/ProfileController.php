<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordChange;
use App\Http\Requests\UserProfileChange;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class ProfileController extends Controller
{
    public function create()
    {
        return view('user.profile');
    }

    public function changeProfile(UserProfileChange $request)
    {
        $user = User::find(session()->get('user')->id);
        //dd($user);
        if ($user) {
            $user->update(
                [
                    'name' => $request->fullname,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                ],
            );
            session()->forget('user');
            session()->put('user', $user);
        }
        if ($user) {
            return redirect()->route('profile.create')->with('success', 'Profile successfully updated');
        } else {
            return back()->with('fail', 'Password not updated');
        }

    }

    public function viewPassword()
    {
        return view('user.changeProfilePassword');
    }

    public function changePassword(UserPasswordChange $request)
    {
        $user = User::find(session()->get('user')->id);
//        dd($user);
        if ($user) {
            if (Hash::check($request->old_password, $user->password)) {

                $user->update(
                    [
                        'password' => Hash::make($request->password),
                    ],
                );
                session()->forget('user');
                session()->put('user', $user);
                //dd($user);
                return redirect()->route('profile.create')->with('success', 'Password changed successfully');
            } elseif($request->old_password == $request->password){
                return redirect()->route('view.profile.password')->with('fail', 'The old password and new password can not be same.');
            } else{
                return redirect()->route('view.profile.password')->with('fail', 'The old password does not match');
            }
        }

    }

    public function exportUserData()
    {
        return Excel::download(new UsersExport, 'users.csv');
    }

}
