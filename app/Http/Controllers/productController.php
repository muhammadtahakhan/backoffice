<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    try {

        $query = $request->input('query');

        $products = Product::where('name', 'like', "%$query%")
                        ->orWhere('unit', 'like', "%$query%")
                        ->orWhere('sale_price', 'like', "%$query%")
                        ->orWhere('purchase_price', 'like', "%$query%")
                        ->orWhere('description', 'like', "%$query%")
                        ->paginate(5)
                        ->appends($request->query());

        return view('admin.products.index', compact('products'));

    } catch (\Exception $e) {
        // Handle the exception here, for example, log the error
        \Log::error('Error displaying product index: ' . $e->getMessage());

        // Redirect back with an error message
        return redirect()->back()
                         ->with('error', 'An error occurred while displaying the product index.');
    }
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.products.create');
        } catch (\Exception $e) {
            // Handle the exception here, for example, log the error
            \Log::error('Error displaying create product view: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                            ->with('error', 'An error occurred while displaying the create product view.');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'unit' => 'nullable',
                'sale_price' => 'required|numeric',
                'purchase_price' => 'required|numeric',
                'description' => 'required',
            ]);
            if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
            }

            Product::create($request->all());

            return redirect()->route('admin.product.index')
                            ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            // Handle the exception here, for example, log the error
            \Log::error('Error creating product: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                            ->with('error', 'An error occurred while creating the product.');
        }
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
            $product = Product::find($id);
            return view('admin.products.edit', compact('product'));
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
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'unit' => 'nullable',
                'sale_price' => 'required|numeric',
                'purchase_price' => 'required|numeric',
                'description' => 'required',
            ]);
            if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
            }
            $product = Product::find($id);
            $product->update($request->all());
            return redirect()->route('admin.product.index')
            ->with('success', 'Product updated successfully.');


        } catch (\Exception $e) {
            // Handle the exception here, for example, log the error
            \Log::error('Error creating product: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                            ->with('error', 'An error occurred while creating the product.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
 public function destroy($id)
    {
        try {
            $post = Product::findOrFail($id); // Use findOrFail to throw an exception if the record is not found
            $post->delete();

            return redirect()->route('admin.product.index')
                            ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            // Handle the exception here, for example, log the error
            \Log::error('Error deleting product: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                            ->with('error', 'An error occurred while deleting the product.');
        }
    }

}
