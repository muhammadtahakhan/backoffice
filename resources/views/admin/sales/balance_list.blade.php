@extends('layouts.mazer-blank')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">


                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Phone</th>
                            <th>Total Invoiceed</th>
                            <th>Total Paid Amount</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->total_sale }}</td>
                                <td>{{ $item->paid_amount }}</td>
                                <td>{{ $item->balance }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>


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
