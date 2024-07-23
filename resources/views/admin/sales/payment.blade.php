@extends('layouts.mazer-admin')

@section('heading')
    Payments
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

                </nav>

                <div class="row h-100  ">
                    <div class="col-4 col-md-4 col-lg-4">

                        <form action="{{ route('admin.create.sale.payment', ['id' => $id]) }}" method="post">
                            @csrf


                            <div class="form-group">
                                <label for="title">Paid Amount</label>
                                <input type="number" value="{{ $balance }}"
                                    class="form-control @error('amount') is-invalid @enderror" id="title" name="amount"
                                    value="{{ old('amount') }}">
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="title">Payment Date</label>
                                <input class="datepicker  @error('payment_date') is-invalid @enderror" id="title"
                                    name="payment_date" value="{{ old('payment_date') }}">
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Create</button>
                        </form>
                    </div>
                </div>

                <br />

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Paid Amount</td>
                            <td>Payment Date</td>


                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $key => $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->amount }}</td>
                                <td>{{ $value->payment_date }}</td>


                                <!-- we will also add show, edit, and delete buttons -->
                                <td>

                                    <!-- delete the shark (uses the destroy method DESTROY /sharks/{id} -->
                                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                                    <!-- show the shark (uses the show method found at GET /sharks/{id} -->
                                    <a class="btn btn-small btn-danger delete_row"
                                        href="{{ URL::to('admin/sale/invoice/' . $value->id . '/delete') }}">Delete</a>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>







        </div>
    </div>
@endsection
