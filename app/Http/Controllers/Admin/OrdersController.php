<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\Setting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::all()->sortByDesc('created_at');
        return view('admin.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.orders.index');
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return redirect()->route('admin.orders.index');
    }

    public function show(Order $order)
    {
        $settings = Setting::first();
        $orderCustomer = OrderCustomer::where('id', $order->id)->first();
        return view('admin.orders.show', compact('order', 'settings', 'orderCustomer'));
    }

    public function destroy(Order $order)
    {

        $order->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Order::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
