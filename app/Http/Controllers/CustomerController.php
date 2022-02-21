<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;

use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(): CustomerCollection
    {
        $customers = Customer::all();
        return new CustomerCollection($customers);
    }

    public function store(CustomerStoreRequest $request): CustomerResource
    {
        $data = $request->validated();
        return new CustomerResource(Customer::create($data));
    }

    public function update(CustomerUpdateRequest $request, Customer $customer): CustomerResource
    {
        $data = $request->validated();
        $customer->update($data);
        return new CustomerResource($customer);
    }

    public function show(Customer $customer): CustomerResource
    {
        return new CustomerResource($customer);
    }

    public function delete(Customer $customer): CustomerResource
    {
        $customer->delete();
        return new CustomerResource($customer);
    }

}
