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
                        <h4 class="card-title">Edit a Product</h4>
                    </div>
                    {{-- <div class="header-title"><button type="submit" class="btn btn-success">save</button></div> --}}
                </div>

                <div class="card-body">
                    <div class="row h-100 justify-content-center align-items-center">
                        <div class="col-10 col-md-8 col-lg-6">

                            <form action="{{ route('admin.product.update', $product->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="title">Product Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="title" name="name" value="{{ $product->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Product Unit</label>
                                    <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                        id="title" name="unit" value="{{ $product->unit }}">
                                    @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Sale Price</label>
                                    <input type="number" class="form-control @error('sale_price') is-invalid @enderror"
                                        id="title" name="sale_price" value="{{ $product->sale_price }}">
                                    @error('sale_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Purchase Price</label>
                                    <input type="number" class="form-control @error('purchase_price') is-invalid @enderror"
                                        id="title" name="purchase_price" value="{{ $product->purchase_price }}">
                                    @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="body">Product Desctiption</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="body" name="description"
                                        rows="3">{{ $product->description }}</textarea>
                                    @error('description')
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
