<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Prod;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Prod::all();
        $discount = null;
        return view('listdiscounts', compact('products', 'discount'));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //dd("hello");
        if ($request->did == null) {
            $discount = new Discount();
            $discount->name = $request->name;
            $discount->percentage = $request->percentage;
            $discount->discount_for = $request->discountfor;
            $discount->save();

            if ($request->products != null) {
                $products = $request->products;
                foreach ($products as $product) {
                    $product = Prod::find($product);
                    $discount->products()->attach($product);
                }
            }
        } else {
            //dd($request->did);
            //dd($request->all());
            $discount = Discount::with('products')->find($request->did);
            $discount->name = $request->name;
            $discount->percentage = $request->percentage;
            $discount->discount_for = $request->discountfor;
            $discount->save();
            if ($request->products != null) {
                $discount->products()->detach();
                $products = $request->products;
                //dd($request->products);
                foreach ($products as $product) {
                    $product = Prod::find($product);
                    $discount->products()->attach($product);
                }
            }
        }
        return response()->json($discount);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Discount $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount, Request $request)
    {
        $data = Discount::with('products')->get();
        //dd($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                             ->addIndexColumn()
                             ->addColumn('action', function ($row) {

                                 $btn = '<td><a href="javascript:void(0)" class="edit btn btn-primary btn-sm ">View</a>
                    <a href="' . route("discount-edit", [$row->id]) . '" class="edit btn btn-info btn-sm editDiscount" data-toggle="modal" data-target="#exampleModal" data-id="' . $row->id . '">Edit</a>
                    <a href="' . route("discount-delete", [$row->id]) . '"  class="edit btn btn-danger btn-sm deleteDiscount" data-id="' . $row->id . '">Delete</a></td>';

                                 return $btn;
                             })
                             ->addColumn('products', function ($row) {

                                 //return public_path('storage/uploads/'.$row->profile);
                                 //return "<img src='".asset('"/storage/uploads/"'.$row->profile)' />"
//                                 return '<img  src="' . asset('storage/uploads/' . $row->image) . '" height="50px" width="50px" />';
                                 return implode(',', $row->products->pluck('name')->toArray());
//                                 return '<td>"'+$row->products+'"</td>';
                                 //return "asdgas";
                             })
                             ->rawColumns(['action', 'products'])
                             ->make(true);
            //dd($info);
        }
        return view('listdiscounts');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Discount $discount
     * @return \Illuminate\Http\Response
     */
    public function edit($discount)
    {
        //dd('Hello');
        $discount = Discount::with('products')->find($discount);
        //dd($discount);
        return response()->json($discount);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Discount     $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Discount $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->products()->detach();
        $discount->delete();

        return redirect()->route('discount-list');
    }
}
