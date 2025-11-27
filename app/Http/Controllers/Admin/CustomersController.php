<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = Customer::all(); 

        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {

        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $customer = Customer::create($request->all());

        return redirect()->route('admin.customers.index');
    }

    public function edit(Customer $customer)
    {

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());

        return redirect()->route('admin.customers.index');
    }

    public function show(Customer $customer)
    {

        return view('admin.customers.show', compact('customer'));
    }

    public function destroy(Customer $customer)
    {

        $customer->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Customer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}