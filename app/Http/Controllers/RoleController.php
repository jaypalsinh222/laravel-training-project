<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = Role::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                             ->addIndexColumn()
                             ->addColumn('action', function ($row) {
                                 return '<td><a href="javascript:void(0)" class="edit btn btn-primary btn-sm ">View</a>
                                             <a href="' . route("roles.edit", [$row->id]) . '" class="edit btn btn-info btn-sm" data-id="' . $row->id . '">Edit</a>
                                             <a href="javascript:void(0)"  class="edit btn btn-danger btn-sm deleteRegister" data-id="' . $row->id . '">Delete</a>
                                         </td>';
                             })
                             ->rawColumns(['action'])
                             ->make(true);
            //dd($info);
        }
        return view('listroles');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        $role = null;
        $getPermissions = [];
        return view('roles', compact('permissions', 'role', 'getPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hid == null) {
            $request->validate(
                [
                    'roleName' => 'required|unique:roles,name',
                    'chk' => 'required',
                ],
                [
                    'roleName.required' => 'Please Enter Role Name.',
                    'roleName.unique' => 'Please Enter different role name',
                    'chk.required' => 'Please Select Permissions',
                ]
            );
            $role = Role::create(['name' => $request->roleName]);
            $role->syncPermissions($request->chk);
            if ($role) {
                return redirect(route('roles.index'))->with('success', 'Role added successfully');
            } else {
                return view('roles')->with('fail', 'Something went wrong');
            }
        } else {
            $request->validate(
                [
                    'roleName' => 'required',
                    'chk' => 'required',
                ],
                [
                    'roleName.required' => 'Please Enter Role Name.',
                    'chk.required' => 'Please Select Permissions',
                ]
            );
            $role = Role::updateOrCreate(
                [
                    'id' => $request->hid
                ],
                [
                    'name' => $request->roleName
                ]
            );
            $role->syncPermissions($request->chk);
            if ($role) {
                return redirect(route('roles.index'))->with('success', 'Role updated successfully');
            } else {
                return view('roles')->with('fail', 'Something went wrong');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $getPermissions = $role->permissions->pluck('name')->all();
        $permissions = Permission::all();
        return view('roles', compact('role', 'getPermissions', 'permissions'));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Role::where('id', $id)->delete();
        return response()->json();
    }
}
