@extends('layouts.mazer-admin')

@section('heading')
    Products
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Add a Customer</h4>
                    </div>
                    {{-- <div class="header-title"><button type="submit" class="btn btn-success">save</button></div> --}}
                </div>

                <div class="card-body">
                    <div class="row h-100 justify-content-center align-items-center">
                        <div class="col-10 col-md-8 col-lg-6">

                            <form action="{{ route('admin.customer.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Customer Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="title" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Customer Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="title" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Customer Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="title" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <br>
                                <button type="submit" class="btn btn-success">Create</button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
@endsection
