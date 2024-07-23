<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\SalePayment;


class saleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve search parameters from request// Retrieve search parameters from request
    $search = $request->input('query');

        // Base query

    $saleDetailsSubquery = DB::table('sale_details')
    ->select('sale_id',
             DB::raw('SUM(quantity) as total_quantity'),
             DB::raw('SUM(total) as total_amount'))
    ->groupBy('sale_id');

    $salePaymentsSubquery = DB::table('sale_payments')
        ->select('sale_id',
                DB::raw('SUM(amount) as total_paid_amount'))
        ->groupBy('sale_id');

    $query = Sale::select(
                'sales.*',
                'customers.name as customer_name',
                DB::raw('COALESCE(sd.total_quantity, 0) as quantity'),
                DB::raw('COALESCE(sd.total_amount, 0) as amount'),
                DB::raw('COALESCE(sp.total_paid_amount, 0) as paid_amount'),
                DB::raw('COALESCE(sd.total_amount, 0) - COALESCE(sp.total_paid_amount, 0) as balance')
            )
            ->leftJoinSub($saleDetailsSubquery, 'sd', 'sales.id', '=', 'sd.sale_id')
            ->leftJoinSub($salePaymentsSubquery, 'sp', 'sales.id', '=', 'sp.sale_id')
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->orderBy('sales.id');

    // Apply search filter if search parameter is provided
    if (!empty($search)) {
        $query->havingRaw("
            customers.name LIKE :search
            OR sum(sale_details.quantity) LIKE '%$search%'
            OR sum(sale_details.total) LIKE '%$search%'
            OR COALESCE(SUM(sale_payments.amount), 0) LIKE '%$search%'
            OR COALESCE(SUM(sale_details.total), 0) - COALESCE(SUM(sale_payments.amount), 0) LIKE '%$search%'
        ", ['search' => '%' . $search . '%']);
    }

    // Paginate the results and append the search query parameter to pagination links
    $sales = $query->paginate(10)->appends($request->query());

        // load the view and pass the products

        return view('admin.sales.index', compact('sales'));

    }

     public function invoice(Request $request, $id)
    {
        $invoice_total = 0;
        $paid_total = 0;

        $sale = Sale::with(['customer', 'detail.product'])->find($id);
        if($sale && $sale->payment){
            $paid_total = $sale->payment->sum('amount');
        }

        if($sale && $sale->detail){
            $invoice_total = $sale->detail->sum('total');
        }

        $balance = $invoice_total - $paid_total;
         return view('admin.sales.invoice', compact('sale', 'invoice_total', 'paid_total', 'balance'));
    }

      public function payment(Request $request, $id)
    {
        $invoice_total = 0;
        $paid_total = 0;

        $payments = SalePayment::where('sale_id', $id)->get();
        $sale = Sale::with(['customer', 'detail.product', 'payment'])->find($id);
        if($sale && $sale->payment){
             $paid_total = $sale->payment->sum('amount');
        }

          if($sale && $sale->detail){
             $invoice_total = $sale->detail->sum('total');
        }


        $balance = $invoice_total - $paid_total;
        // dd([$balance, $invoice_total, $paid_total]);
         return view('admin.sales.payment', compact('id', 'payments', 'sale', 'invoice_total', 'paid_total', 'balance'));
    }

    function createPayment(Request $request, $id){
         try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required',
                'payment_date' => 'required',
            ]);
            if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
            }

            $payment['sale_id'] = $id;
            $payment['amount'] = $request->input('amount');
            $payment['payment_date'] = date("Y-m-d H:i:s", strtotime($request->input('payment_date')));

            $new_payment = SalePayment::create($payment);

            return redirect()->route('admin.sale.payment',['id'=>$id])
                            ->with('success', 'Payment created successfully.');
        } catch (\Exception $e) {
            // Handle the exception here, for example, log the error
            \Log::error('Error creating product: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                            ->with('error', 'An error occurred while creating the product.');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('admin.sales.create', compact('customers', 'products'));
    }

    public function balance_list(){
         $results =  Sale::balances();
         return view('admin.sales.balance_list',  compact('results'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required',
                'invoice_date' => 'required',
                'product_id.*' => 'required',
                'unit.*' => 'required',
                'quantity.*' => 'required',
                'unit_price.*' => 'required',
                'total.*' => 'required',
                'total_quantity' => 'required',
                'total_amount' => 'required',
            ]);
            if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
            }

            $sale_invoice['customer_id'] = $request->input('customer_id');
            $sale_invoice['invoice_date'] = date("Y-m-d H:i:s", strtotime($request->input('invoice_date')));
            $new_sale = Sale::create($sale_invoice);
            if($new_sale){

            $input = $request->all();
            foreach($input['product_id'] as $key => $val){
                 $sale_details['sale_id'] = $new_sale->id;
                $sale_details['product_id'] = $input['product_id'][$key];
                $sale_details['unit'] = $input['unit'][$key];
                $sale_details['quantity'] = $input['quantity'][$key];
                $sale_details['unit_price'] = $input['unit_price'][$key];
                $sale_details['total'] = $input['total'][$key];
                SaleDetail::create($sale_details);
            }

            }



            return redirect()->route('admin.sale.index')
                            ->with('success', 'Invoice created successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
    {
        try {
            $post = Sale::findOrFail($id); // Use findOrFail to throw an exception if the record is not found
            $post->delete();

            return redirect()->route('admin.sale.index')
                            ->with('success', 'Invocie deleted successfully');
        } catch (\Exception $e) {
            // Handle the exception here, for example, log the error
            \Log::error('Error deleting product: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                            ->with('error', 'An error occurred while deleting the product.');
        }
    }
}
