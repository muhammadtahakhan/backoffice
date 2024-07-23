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
                        <h4 class="card-title">Add a Product</h4>
                    </div>
                    {{-- <div class="header-title"><button type="submit" class="btn btn-success">save</button></div> --}}
                </div>

                <div class="card-body">
                    <div class="row h-100 justify-content-center align-items-center">
                        <div class="col-10 col-md-8 col-lg-6">

                            <form action="{{ route('admin.product.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Product Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="title" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Product Unit</label>
                                    <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                        id="title" name="unit" value="{{ old('unit') }}">
                                    @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Sale Price</label>
                                    <input type="number" class="form-control @error('sale_price') is-invalid @enderror"
                                        id="title" name="sale_price" value="{{ old('sale_price') }}">
                                    @error('sale_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Purchase Price</label>
                                    <input type="number" class="form-control @error('purchase_price') is-invalid @enderror"
                                        id="title" name="purchase_price" value="{{ old('purchase_price') }}">
                                    @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="body">Product Desctiption</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="body" name="description"
                                        rows="3">{{ old('description') }}</textarea>
                                    @error('description')
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
