<?php

namespace App\Http\Controllers\Client;

use App\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    /**
     * Display all unpaid orders of current user
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->where('payment_status', 'unpaid')->get();

        return view('client/orders', ['orders' => $orders]);
    }

    /**
     * Display all paid orders of current user
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())->where('payment_status', 'paid')->get();

        return view('client/history', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client/book');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'laundry' => 'bail|required|numeric|min:0|max:100',
            'ironing' => 'bail|required|numeric|min:0|max:100',
            'pickup' => 'bail|required|date|after:tomorrow',
            'delivery' => 'bail|required|date|after:pickup',
            'notes' => 'bail|nullable|string|max:255',
        ]);

        $order = new Order($request->all());

        $order->user_id = Auth::id();

        $order->laundry_status = "initial";

        $order->payment_status = "unpaid";

        $order->total = ($order->laundry + $order->ironing) * 5;

        if ($order->save()) {
            return redirect()->to('user_orders');
        } else {
            return redirect()->to('error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        if ($order->user_id != Auth::id()) {
            return redirect('error');
        }
        return view('client/edit', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'laundry' => 'required|numeric|min:0|max:100',
            'ironing' => 'required|numeric|min:0|max:100',
            'pickup' => 'required|date|after:tomorrow',
            'delivery' => 'required|date|after:pickup',
            'notes' => 'nullable|string|max:255'
        ]);

        DB::transaction(function() use ($request, $id) {
            $order = Order::find($id);
            if ($order->user_id != Auth::id()) {
                return redirect('error');
            }
            $order->fill($request->all());
            $order->total = ($order->laundry + $order->ironing) * 5;
            $order->update();
        });

        return redirect('user_orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function() use ($id) {
            Order::find($id)->delete();
        });
        return redirect('user_orders');
    }

}
