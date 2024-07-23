@extends('layouts.mazer-admin')

@section('heading')
    Sales Invoices
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Add a Invoice</h4>
                    </div>
                    {{-- <div class="header-title"><button type="submit" class="btn btn-success">save</button></div> --}}
                </div>

                <div class="card-body">
                    <div class="row h-100 justify-content-center align-items-center">
                        <div class="col-10 col-md-10 col-lg-10">

                            <form action="{{ route('admin.sale.store') }}" method="post">
                                @csrf

                                <div class="form-group row">

                                    <div class="col-md-4">
                                        <label for="sel1">Select Customer:</label>
                                        <select name="customer_id" class="form-control select2" id="sel1">

                                            @foreach ($customers as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputValue" class="control-label">Invoice Date</label>
                                        <input name="invoice_date" value="{{ old('invoice_date') }}"
                                            class="datepicker @error('invoice_date') is-invalid @enderror" width="276" />

                                    </div>
                                    <div class="col-md-4">

                                        @error('invoice_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <br>
                                    <div class="col-12">
                                        <br />
                                        <table class="table table-bordered sale_product_table">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Unit</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                    <th><button class="btn add"><i style="color: #435ebe"
                                                                class="fa fa-plus"></i></button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="product_id[]" class="select2 product_id">

                                                            @foreach ($products as $item)
                                                                <option data-unit={{ $item->unit }}
                                                                    data-sale-price={{ $item->sale_price }}
                                                                    value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input required name="unit[]" class="form-control unit"
                                                            type="text" placeholder="unit">
                                                    </td>
                                                    <td><input required name="quantity[]" class="form-control quantity"
                                                            type="number" placeholder="quantity">
                                                    </td>
                                                    <td><input required name="unit_price[]" class="form-control price"
                                                            type="number" placeholder="unit price">
                                                    </td>
                                                    <td><input readonly name="total[]" class="form-control row_total"
                                                            type="text">
                                                    </td>
                                                    <td><button class="btn remove"><i style="color: red"
                                                                class="fa fa-minus"></i></button></td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-8"></div>
                                    <div class="col-3">
                                        <div>Total Quantity:<input readonly name="total_quantity"
                                                class="form-control total_quantity" type="text"></div>
                                    </div>
                                    <div class="col-8"></div>
                                    <div class="col-3">
                                        <div>Total Amount:<input readonly name="total_amount"
                                                class="form-control total_amount" type="text">
                                        </div>
                                    </div>
                                </div>


                                <br>
                                <button type="submit" class="btn btn-success"
                                    style="background-color: #435ebe">Create</button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // -----------------------------------------------Invoice Page

            // Removing Row on click to Remove button
            $('.sale_product_table').on('click', '.remove', function() {
                $(this).closest('tr').remove();
                calculate();
            });

            // Adding row on click to Add New Row button
            $('.sale_product_table').on('click', '.add', function(event) {
                event.preventDefault();
                let dynamicRowHTML = `
                <tr>
                    <td>
                        <select name="product_id[]" class="select2 product_id">

                            @foreach ($products as $item)
                                <option data-unit={{ $item->unit }}
                                        data-sale-price={{ $item->sale_price }} value="{{ $item->id }}">{{ $item->name }}
                                </option>
                            @endforeach

                        </select>
                    </td>
                    <td>
                        <input required name="unit[]" class="form-control unit" type="text"
                            placeholder="unit">
                    </td>
                    <td><input name="quantity[]" class="form-control quantity"
                            type="number" placeholder="quantity">
                    </td>
                    <td><input required name="unit_price[]"  class="form-control price" type="number"
                            placeholder="unit price">
                    </td>
                    <td><input required readonly name="total[]" class="form-control row_total"
                            type="text">
                    </td>
                    <td><button class="btn remove"><i style="color: red"
                                class="fa fa-minus"></i></button></td>
                </tr>
                `;
                $('.sale_product_table>tbody').append(dynamicRowHTML);
                $('.select2').select2({
                    theme: "bootstrap4"
                });

            });

            $(document).on('change', '.quantity, .price', function(event) {

                calculate();
            })



            $(document).on('change', '.product_id ', function(event) {
                let unit = $(this).closest('tr').find(".product_id :selected").data("unit");
                let sale_price = $(this).closest('tr').find(".product_id :selected").data("sale-price");

                $(this).closest('tr').find("input.unit").val(unit);
                $(this).closest('tr').find("input.price").val(sale_price);
            })

            function calculate() {

                let total_amount = 0;
                let total_quantity = 0;
                $('tbody tr').each(function(index, tr) {

                    let quantity = $(tr).find("input.quantity").val() ?? 0;
                    let price = $(tr).find("input.price").val() ?? 0;
                    let total = $(tr).find("input.row_total") ?? 0;
                    let row_total = quantity * price;
                    total.val(row_total);

                    // work for total product and total amount
                    total_amount = parseFloat(total_amount) + parseFloat(row_total);
                    total_quantity = parseFloat(total_quantity) + parseFloat(quantity);
                    $(".total_amount").val(total_amount);
                    $(".total_quantity").val(total_quantity);


                });
            }

        });
    </script>
@endsection
