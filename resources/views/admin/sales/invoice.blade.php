@extends('layouts.mazer-blank')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="invoice">
                    {{-- Company Logo and Information --}}
                    <div class="text-center mb-4">
                        {{-- <img src="COMPANY LOGO URL" alt="Company Logo" style="max-width: 150px;"> --}}
                        <h4>Saeed & Sons</h4>
                        <div>Sabzi Mandi Karachi</div>
                        <div>090078601 | saeed@gmail.com</div>
                    </div>

                    <h2 class="text-center">Invoice</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="invoice-details">
                                <div><strong>To:</strong> {{ $sale->customer->name }}</div>
                                <div><strong>Phone:</strong> {{ $sale->customer->phone }}</div>
                                <div><strong>Address:</strong> {{ $sale->customer->address }}
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="invoice-details  " style="float: right">
                                <div><strong>Invoice Number:</strong> INV-00{{ $sale->id }}</div>
                                <div><strong>Invoice Date:</strong>
                                    {{ \Carbon\Carbon::parse($sale->invoice_date)->format('d/m/Y') }}</div>
                                <div><strong>Due Date:</strong>
                                    {{ \Carbon\Carbon::parse($sale->due_date)->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="invoice-items">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale->detail as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->unit }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->unit_price }}</td>
                                        <td>{{ $item->total }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="total">
                        <div><strong>Total Amount:</strong> {{ $invoice_total }}</div>
                        <div><strong>Paid Amount:</strong> {{ $paid_total }}</div>
                        <div><strong>Balance:</strong>{{ $balance }}</div>
                    </div>

                    {{-- Print Button --}}
                    <div class="text-center mb-4">
                        <button class="btn btn-primary" onclick="printInvoice()">Print Invoice</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script to handle printing --}}
    <script>
        function printInvoice() {
            // Print the invoice section
            window.print();
        }
    </script>
@endsection
