@extends('layouts.mazer-admin')

@section('heading')
    Customers
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
                        <a class="navbar-brand h1 " href={{ route('admin.customer.index') }}></a>
                        <div class="justify-end ">
                            <div class="col ">
                                <a class="btn btn-sm btn-success" href={{ route('admin.customer.create') }}>Add Customer</a>
                            </div>
                        </div>
                    </div>
                </nav>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Address</td>
                            <td>Phone Number</td>


                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->address }}</td>
                                <td>{{ $value->phone }}</td>


                                <!-- we will also add show, edit, and delete buttons -->
                                <td>

                                    <!-- delete the shark (uses the destroy method DESTROY /sharks/{id} -->
                                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                                    <!-- show the shark (uses the show method found at GET /sharks/{id} -->
                                    <a class="btn btn-small btn-danger delete_row"
                                        href="{{ URL::to('admin/customer/' . $value->id . '/delete') }}">Delete</a>


                                    <!-- edit this shark (uses the edit method found at GET /sharks/{id}/edit -->
                                    <a style="background-color: #435ebe" class="btn btn-small btn-info"
                                        href="{{ URL::to('admin/customer/' . $value->id . '/edit') }}">Edit
                                        this </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- <div class="pagination justify-content-left">
                    {{ $customers->links() }}
                </div> --}}
                <div class="pagination justify-content-left">
                    {{-- {{ $products->links() }} --}}
                    {{ $customers->appends(request()->query())->links() }}
                </div>


            </div>







        </div>
    </div>
@endsection
