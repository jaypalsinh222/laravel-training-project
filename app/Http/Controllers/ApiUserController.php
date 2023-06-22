<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class ApiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
//        dd(env('APP_URL') . 'users');
        $data = Http::get(env('APP_URL') . 'users');

        if ($request->ajax()) {
            return DataTables::of($data)
                             ->addIndexColumn()
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
                                 return '<td>
                                             <a href="' . route("get.user.details", ['id' => $row->id, 'cityId' => $row->city]) . '" class="edit btn btn-info btn-sm editRegister" data-id="' . $row->id . '">Edit</a>
                                             <a href="javascript:void(0)"  class="edit btn btn-danger btn-sm deleteRegister" data-id="' . $row->id . '">Delete</a>
                                         </td>';
                             })
                             ->addColumn('profile', function ($row) {
                                 return '<img  src="' . asset('storage/uploads/' . $row->profile_photo) . '" height="50px" width="50px" />';
                             })
                             ->rawColumns(['gender', 'city', 'profile', 'action'])
                             ->make(true);
            //dd($info);
        }
        return view('listregister');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
//        dd(24324);
        $details = null;
        $countries = Http::get(route('get.country'));
//        dd(gettype($countries));
        $countries = $countries->object();
        return view('index', compact('details', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd(route('api.user.store'));
        if ($request->id == null) {
//            $user = new User;
//            $filename = time() . '-jsk.' . $request->file('profile')->getClientOriginalExtension();
//            //$register->profile =
//            $request->file('profile')->storeAs('public/uploads', $filename);
//
//            $file =  asset(env('ASSET_URL').'/storage/uploads/1664359513-jsk.jpeg');
//            dd($file);
            $data = $request->except('chk');
            $data = $request->all();
//            dd($data['name']);
//            dd($re)
//            dd($image);

            if ($request->hasFile('profile') && $request->file('profile')->isValid()) {
//                dd($request->file('profile')->getContent());
                $image = $request->file('profile');
//                $data = $request->all();
//                $data['profile'] = ;

                $response = Http::attach('profile', file_get_contents($image), $image->getFilename())->post(route('api.user.store'), $data);
//                dd('hasfile', $response->object());
            } else {
//                dd(1111);
                $response = Http::withHeaders([
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ])->post(route('api.user.store'), $data);
//                dd('hasno file', $response->json());
            }
        } else {
//            dd(2387);
//            dd($request->file('profile')->isValid());
            $data = $request->except('chk');
//            dd($data);
            if ($request->hasFile('profile') && $request->file('profile')->isValid()) {
//                dd(39457);
//                dd($request->file('profile')->getContent());
                $image = $request->file('profile');
//                dd($image);
//                $data = $request->all();
//                $data['profile'] = ;
                $hobbies = implode(',', $request->chk);
                $response = Http::attach('profile', file_get_contents($image), $image->getFilename())->post(route('api.update.user'), $data);
//                dd('hasfile', $response->object());
            } else {
//                dd(1111);
                $response = Http::withHeaders([
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ])->post(route('api.update.user'), $data);
//                dd('hasno file', $response->json());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($user, $cityId)
    {
//        dd($user,$cityId);
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->get(route('api.edit.user', ['id' => $user, 'cityId' => $cityId]));
//        dd($response->json());
        $res = $response->json();
//        dd($res['details']);
        $details = $res['details'];
        $cities = $res['cities'];
        $country = $res['country'];
        $countries = $res['countries'];
//        dump($country['state']['name']);
        return view('index', compact('details', 'cities', 'country', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
//        dd($user);
//        dd(route('api.user.delete').'/'. $id);
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->delete(route('api.user.delete', $user));
    }
}
