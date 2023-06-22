<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = User::paginate(5);
        //if ($request->ajax()) {
//            return DataTables::of($data)
//                             ->addIndexColumn()
//                             ->editColumn('name', 'Hi {{$name}}!')
//                             ->addColumn('gender', function ($row) {
//                                 $gender = config('constant.gender');
//                                 return $gender[$row->gender] ?? '';
//                             })
//                             ->addColumn('city', function ($row) {
//                                 $cities = City::get();
//                                 foreach ($cities as $city) {
//                                     if ($row->city == $city->id) {
//                                         return $city->name;
//                                     }
//                                 }
//                             })
//                             ->addColumn('action', function ($row) {
//                                 return '<td><a href="javascript:void(0)" class="edit btn btn-primary btn-sm ">View</a>
//                                             <a href="' . route("get.user.details", ['id' => $row->id, 'cityId' => $row->city]) . '" class="edit btn btn-info btn-sm editRegister" data-id="' . $row->id . '">Edit</a>
//                                             <a href="javascript:void(0)"  class="edit btn btn-danger btn-sm deleteRegister" data-id="' . $row->id . '">Delete</a>
//                                         </td>';
//                             })
//                             ->addColumn('profile', function ($row) {
//                                 return '<img  src="' . asset('storage/uploads/' . $row->profile_photo) . '" height="50px" width="50px" />';
//                             })
//                             ->rawColumns(['gender', 'city', 'profile', 'action'])
//                             ->make(true);
//            return $data;
//        }
        return view('datatable',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
