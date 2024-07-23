<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class customerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */

    public function index()
    {
        // return view('admin.products.index');

         // get all the products
        $customers = Customer::paginate(5);

        // load the view and pass the products

        return view('admin.customers.index', compact('customers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|max:255',
        'address' => 'required',
        'phone' => 'required||min:11|numeric',
        ]);

        Customer::create($request->all());
        return redirect()->route('admin.customer.index')
        ->with('success', 'Customer created successfully.');
    }


    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            // dd($id);
            $customer = Customer::find($id);
            return view('admin.customers.edit', compact('customer'));
        } catch (\Exception $e) {
                // Handle the exception here, for example, log the error
                \Log::error('Error creating product: ' . $e->getMessage());

                // Redirect back with an error message
                return redirect()->back()
                                ->with('error', 'An error occurred while edit the product.'.$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // dd($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'address' => 'required',
                'phone' => 'required',
            ]);
            if ($validator->fails()) {
                // dd($validator);
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
            }
            $customer = Customer::find($id);
            $customer->update($request->all());
            return redirect()->route('admin.customer.index')
            ->with('success', 'Customer updated successfully.');


        } catch (\Exception $e) {
            // Handle the exception here, for example, log the error
            \Log::error('Error creating customer: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                            ->with('error', 'An error occurred while creating the customer.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
    {
        try {
            $post = Customer::findOrFail($id); // Use findOrFail to throw an exception if the record is not found
            $post->delete();

            return redirect()->route('admin.customer.index')
                            ->with('success', 'Customer deleted successfully');
        } catch (\Exception $e) {
            // Handle the exception here, for example, log the error
            \Log::error('Error deleting product: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                            ->with('error', 'An error occurred while deleting the product.');
        }
    }
}
