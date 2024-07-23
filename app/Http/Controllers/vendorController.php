<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;

class vendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        // return view('admin.products.index');

         // get all the products
        $vendors = Vendor::paginate(5);

        // load the view and pass the products

        return view('admin.vendors.index', compact('vendors'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vendors.create');
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

        Vendor::create($request->all());
        return redirect()->route('admin.vendor.index')
        ->with('success', 'Vendor created successfully.');
    }

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
            $vendor = Vendor::find($id);
            return view('admin.vendors.edit', compact('vendor'));
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
            $vendor = Vendor::find($id);
            $vendor->update($request->all());
            return redirect()->route('admin.vendor.index')
            ->with('success', 'Vendor updated successfully.');


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
    public function destroy(string $id)
    {
         try {
            $post = Vendor::findOrFail($id); // Use findOrFail to throw an exception if the record is not found
            $post->delete();

            return redirect()->route('admin.vendor.index')
                            ->with('success', 'Vendor deleted successfully');
        } catch (\Exception $e) {
            // Handle the exception here, for example, log the error
            \Log::error('Error deleting Vendor: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                            ->with('error', 'An error occurred while deleting the vendor.');
        }
    }
}
