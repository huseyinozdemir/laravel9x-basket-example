<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Customer\Collection;
use App\Http\Resources\Customer\Resource;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;

use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(): Collection
    {
        $customers = Customer::all();
        return new Collection($customers);
    }

    public function store(StoreRequest $request): Resource
    {
        $data = $request->validated();
        return new Resource(Customer::create($data));
    }

    public function update(UpdateRequest $request, Customer $customer): CustomerResource
    {
        $data = $request->validated();
        $customer->update($data);
        return new Resource($customer);
    }

    public function show(Customer $customer): Resource
    {
        return new Resource($customer);
    }

    public function delete(Customer $customer): Resource
    {
        $customer->delete();
        return new Resource($customer);
    }

}
