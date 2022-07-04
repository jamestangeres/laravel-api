<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Customer;
use App\Filters\v1\CustomersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreCustomerRequest;
use App\Http\Resources\v1\CustomerResource;
use App\Http\Requests\v1\UpdateCustomerRequest;
use App\Http\Resources\v1\CustomerCollection;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new CustomersFilter();
        $filterItems = $filter->transform($request); // [['column','operate','value']]

        // including related data
        $includingInvoices = $request->query('includeInvoices');

        $customers = Customer::where($filterItems);
        
        if ($includingInvoices) {

            // invoices is the method in the customer model
            $customers = $customers->with('invoices');
        }

        // use appends in order to fix the pagination issue + add the query items to the response
        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        // including related data
        $includingInvoices = request()->query('includeInvoices');

        if($includingInvoices){
            return new CustomerResource($customer->loadMissing('invoices'));
        }   

        return new CustomerResource($customer);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
