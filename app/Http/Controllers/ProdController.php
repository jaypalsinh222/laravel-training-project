<?php

namespace App\Http\Controllers;

use App\Models\Prod;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ProdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $product = null;
        return view('listproducts', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->id == null) {
            $product = new Prod;
            $product->name = $request->name;
            $product->price = $request->price;
            $filename = time() . '-jsk.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/uploads', $filename);
            $product->image = $filename;
        } else {
            $product = Prod::find($request->id);
            $product->name = $request->name;
            $product->price = $request->price;
            $file = public_path("/storage/uploads/" . Prod::where('id', $request->id)->first()->profile_photo);
            if ($request->has('image')) {
                if (File::exists($file)) {
                    File::delete($file);
                }
                $filename = time() . '-jsk.' . $request->file('image')->getClientOriginalExtension();
                //$user->profile =
                $request->file('image')->storeAs('public/uploads', $filename);
                $product->image = $filename;
            }
        }
        $product->save();
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $data = Prod::get();
        //dd($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                             ->addIndexColumn()
                             ->addColumn('action', function ($data) {
                                 $btnDelete = null;
                                 $btnEdit = null;

                                 $btn = '<td><a href="javascript:void(0)" class="edit btn btn-primary btn-sm ">View</a> ';
                                 if (session()->get('user')->hasPermissionTo("product-edit")) {
                                     $btnEdit = ' <a href="' . route("product-edit", [$data->id]) . '" class="edit btn btn-info btn-sm editProduct" data-toggle="modal" data-target="#exampleModal" data-id="' . $data->id . '">Edit</a> ';
                                 }
                                 if (session()->get('user')->hasPermissionTo("product-delete")) {
                                     $btnDelete = ' <a href = "' . route("product-delete", [$data->id]) . '"  class="edit btn btn-danger btn-sm" data-id = "' . $data->id . '" > Delete</a ></td > ';
                                 }

                                 return $btn . $btnEdit . $btnDelete;
                             })
                             ->addColumn('image', function ($row) {

                                 //return public_path('storage / uploads / '.$row->profile);
                                 //return "<img src='".asset('" / storage / uploads / "'.$row->profile)' />"
                                 return '<img  src="' . asset('storage/uploads/' . $row->image) . '" height="50px" width="50px" />';
                                 //return "asdgas";
                             })
                             ->rawColumns(['action', 'image'])
                             ->make(true);
            //dd($info);
        }
        return view('listproducts');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Prod $prod
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Prod $id)
    {
        //dd($id);
        $product = $id;
//        dd($product);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Prod                     $prod
     * @return Response
     */
    public function update(Request $request, Prod $prod)
    {
        //return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Prod $prod
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Prod $product)
    {
        $file = public_path("/storage/uploads/" . $product->image);

        if (File::exists($file)) {
            File::delete($file);
        }

        $product->delete();

        return redirect()->route('product-list');
    }
}
