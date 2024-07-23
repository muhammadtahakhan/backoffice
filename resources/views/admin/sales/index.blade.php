@extends('layouts.mazer-admin')

@section('heading')
    Sales Invoices
@endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center">


            <!-- will be used to show any messages -->
            @if (Session::has('success'))
                <div style="background-color: #435ebe" class="alert alert-info">{{ Session::get('success') }}</div>
            @endif
            @if (Session::has('error'))
                <div style="background-color: #dc3545" class="alert alert-info">{{ Session::get('error') }}</div>
            @endif

            <div class="card">
                <nav class="navbar navbar-expand-lg navbar-light ">
                    <div class="container-fluid page-heading">
                        <a class="navbar-brand h1 " href={{ route('admin.sale.index') }}></a>
                        <div class="justify-end ">
                            <div class="col">
                                <a class="btn btn-sm" href={{ route('admin.sale.balance') }}>Print Balances</a>
                                <a class="btn btn-sm" href={{ route('admin.sale.create') }}>Add Sale</a>
                            </div>

                        </div>

                    </div>
                </nav>
                <form action="{{ route('admin.sale.index') }}" method="GET">
                    {{-- <input value="{{ $_GET['query'] }}" type="text" name="query" placeholder="Search products...">
                    <button type="submit">Search</button> --}}
                    <div class="row">
                        <div class="col-4">
                            <div class="input-group">
                                <input id="email" type="search" class="form-control" value="{{ $_GET['query'] ?? '' }}"
                                    type="text" name="query" placeholder="Search">
                            </div>

                        </div>

                    </div>


                </form><br />

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Customer</td>
                            <td>Invocie Date</td>
                            <td>Quantity</td>
                            <td>Invoice Amount</td>
                            <td>Paid Amount</td>
                            <td>Balance</td>

                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $key => $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->customer_name }}</td>
                                <td>{{ $value->invoice_date }}</td>
                                <td>{{ $value->quantity }}</td>
                                <td>{{ $value->amount }}</td>
                                <td>{{ $value->paid_amount }}</td>
                                <td>{{ $value->balance }}</td>


                                <!-- we will also add show, edit, and delete buttons -->
                                <td>

                                    <!-- delete the shark (uses the destroy method DESTROY /sharks/{id} -->
                                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                                    <!-- show the shark (uses the show method found at GET /sharks/{id} -->
                                    <a class="btn btn-small btn-danger delete_row"
                                        href="{{ URL::to('admin/sale/invoice/' . $value->id . '/delete') }}">Delete</a>


                                    <a target="_blank" style="background-color: #435ebe" class="btn btn-small btn-info"
                                        href="{{ URL::to('admin/sale/invoice/' . $value->id) }}">Show Invoice </a>

                                    <a target="_blank" style="background-color: #435ebe" class="btn btn-small btn-info"
                                        href="{{ URL::to('admin/sale/payment/' . $value->id) }}">Payment </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination justify-content-left">
                    {{-- {{ $products->links() }} --}}
                    {{ $sales->appends(request()->query())->links() }}
                </div>


            </div>







        </div>
    </div>
@endsection
