<?php

namespace App\Http\Controllers;

use App\Events\GstBillCreated;
use App\Models\Gstbill;
use App\Models\Invoice;
use App\Models\Invoiceitem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class GstbillController extends Controller
{

    public function getUsers(Request $request)
    {
            $users = User::where('name','like','%'.$request->term.'%')->limit(10)->get();
            ;
            return response()->json($users);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function index()
    {
        return view('showgstbills');
    }

    public
    function getUser(Request $request
    ) {
        $id = $request->post('id');
        $user = User::find($id);
        return response($user);
    }

    public
    function getProducts(Request $request
    ) {
        $id = $request->post('id');
        $product = Product::find($id);
        return response($product);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public
    function create()
    {
        $invoice = null;
        $users = User::all();
        $products = Product::all();
        return view('gstcal', compact('users', 'products', 'invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public
    function store(Request $request
    ) {

        if ($request->invoiceId == null) {


            $invoice = Invoice::updateOrCreate(
                [
                    'id' => $request->invoiceId,
                ],
                [
                    'user_id' => $request->client,
                    'subtotal' => $request->total_sub_total,
                    'total_cgst' => $request->total_cgst,
                    'total_sgst' => $request->total_sgst,
                    'totalamount' => $request->total_amount,
                    'discount' => $request->discount,
                    'grandtotal' => $request->grand_total_amount,
                ]
            );

            foreach ($request->data as $key => $arr) {
                //dump($arr);

                $invoice->invoiceItems()->updateOrCreate(
                    [
                        'invoice_id' => $invoice->id,
                        'product_id' => $arr['product'],
                        'quantity' => $arr['quantity'],
                        'row_key' => $invoice->id . '_' . $key . '_' . rand(0, 1000000),
                    ],
                    [
                        'price' => $arr['price'],
                        'totalsubtotal' => $arr['subtotal'],
                        'cgst' => $arr['cgst'],
                        'sgst' => $arr['sgst'],
                        'totalamount' => $arr['amount'],
                    ]
                );
            }
            $gstData = $request->all();
            event(new GstBillCreated($gstData));
            if (true) {
                return redirect(route('index.show'))->with('success', 'Bill Inserted  Successfully');
            } else {
                return back()->with('fail', 'Something went wrong');
            }

        } else {

            $invoice = Invoice::updateOrCreate(
                [
                    'id' => $request->invoiceId,
                ],
                [
                    'user_id' => $request->client,
                    'subtotal' => $request->total_sub_total,
                    'total_cgst' => $request->total_cgst,
                    'total_sgst' => $request->total_sgst,
                    'totalamount' => $request->total_amount,
                    'discount' => $request->discount,
                    'grandtotal' => $request->grand_total_amount,
                ]
            );

            foreach ($request->data as $key => $arr) {

                $items[] = $invoice->invoiceItems()->updateOrCreate(
                    [
                        'invoice_id' => $invoice->id,
                        'row_key' => $arr['row_key'] ?? $invoice->id . '_' . $key . '_' . rand(0, 1000000),
                    ],
                    [
                        'product_id' => $arr['product'],
                        'quantity' => $arr['quantity'],
                        'price' => $arr['price'],
                        'totalsubtotal' => $arr['subtotal'],
                        'cgst' => $arr['cgst'],
                        'sgst' => $arr['sgst'],
                        'totalamount' => $arr['amount'],
                    ]
                )->id;

            }
            //dump($items);
            Invoiceitem::whereNotIn('id', $items)
                       ->where('invoice_id', $invoice->id)
                       ->delete();
            if (true) {
                return redirect(route('index.show'))->with('success', 'Bill Updated  Successfully');
            } else {
                return back()->with('fail', 'Something went wrong');
            }
        }


    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Gstbill $gstbill
     * @return \Illuminate\Http\Response
     */
    public
    function show(Request $request
    ) {
        $data = Invoice::with('invoiceItems')->get();
        //dd($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                             ->addIndexColumn()
                             ->addColumn('action', function ($data) {

                                 $btn = '<td><a href="javascript:void(0)" class="edit btn btn-primary btn-sm ">View</a>
                    <a href="' . route("invoice-edit", [$data->id]) . '" class="edit btn btn-info btn-sm editProduct"  data-id="' . $data->id . '">Edit</a>
                    <a href="' . route("invoice-delete", [$data->id]) . '"  class="edit btn btn-danger btn-sm" data-id="' . $data->id . '">Delete</a></td>';

                                 return $btn;
                             })
                             ->rawColumns(['action', 'invoice'])
                             ->make(true);
            //dd($info);
        }
        return view('showgstbills');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Gstbill $gstbill
     * @return \Illuminate\Http\Response
     */
    public
    function edit($invoice
    ) {
        $invoice = Invoice::with(['invoiceItems', 'user'])->find($invoice);
        //dd($invoice);
        $users = User::all();
        $products = Product::all();
        return view('gstcal', compact('users', 'products', 'invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request             $request
     * @param \App\Models\Gstbill $gstbill
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, Gstbill $gstbill
    ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Gstbill $gstbill
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Invoice $invoice
    ) {
        $invoice->delete();
        if (true) {
            return redirect()->route('view-gst-list')->with('success', 'Deleted Successfully');
        } else {
            return redirect()->route('view-gst-list')->with('fail', 'Something went wrong');
        }
    }
}
