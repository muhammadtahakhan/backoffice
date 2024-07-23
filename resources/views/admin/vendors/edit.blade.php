@extends('layouts.mazer-admin')

@section('heading')
    Vendor
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit a Vendor</h4>
                    </div>
                    {{-- <div class="header-title"><button type="submit" class="btn btn-success">save</button></div> --}}
                </div>

                <div class="card-body">
                    <div class="row h-100 justify-content-center align-items-center">
                        <div class="col-10 col-md-8 col-lg-6">

                            <form action="{{ route('admin.vendor.update', $vendor->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="title">Customer Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="title" name="name" value="{{ $vendor->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Customer Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="title" name="address" value="{{ $vendor->address }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Customer Phone No</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="title" name="phone" value="{{ $vendor->phone }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <br>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
@endsection
