
@section('content')
@extends('layouts.back-main')
@section('main-container')
            <section class="content-main">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Products Views</h2>
                    </div>
                    <div>
                        <a href="#" class="btn btn-light rounded font-md">Export</a>
                        <a href="#" class="btn btn-light rounded font-md">Import</a>
                        @can('product-create')

                        <a href="{{route('add_product')}}" class="btn btn-primary btn-sm rounded">Create new</a>
                        @endcan

                    </div>
                </div>
                <form action="" method="get">
               

                    <div class="card mb-4">
                    <header class="card-header">
                        <div class="row gx-3">

                            <div class="col-lg-4 col-md-6 me-auto">
                                <input type="text" id="search-input"
                                 placeholder="Search..." class="form-control">
                            </div>


                            <div class="col-lg-2 col-md-3 col-6">
                                <select class="form-select">
                                    <option>Status</option>
                                    <option>Active</option>
                                    <option>Disabled</option>
                                    <option>Show all</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-6">
                                <select class="form-select">
                                    <option>Show 20</option>
                                    <option>Show 30</option>
                                    <option>Show 40</option>
                                </select>
                            </div>
                        </div>
                    </header>
                    <!-- card-header end// -->
                   <div class="card-body">
                        <div class="table-responsive">
                        <table id="category-table" class="table table-hover">
    <thead>
        <tr>
            <th>Rank</th>
            <th>Product Name</th>
            <th>Total Views</th>
            <th>Quantity Sold</th>
            <th>Total Orders</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rankedProducts as $product)
            <tr>
                <td>{{ $product->rank }}</td>
                <td>
                    <a href="{{ route('products_view', ['id' => $product->id]) }}" class="itemside">
                        <div class="left">
                            <img src="{{ asset('storage/images/' . $product->image) }}" class="img-sm img-avatar" alt="Product Image">
                        </div>
                        <div class="info pl-3">
                            <h6 class="mb-0 title">{{ $product->name }}</h6>
                            <small class="text-muted">Product ID: #{{ $product->id }}</small>
                        </div>
                    </a>
                </td>
                <td>{{ $product->views }}</td>
                <td>{{ $product->quantity_sold ?? 0 }}</td>
                <td>{{ $product->total_orders ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


            
                            <!-- table-responsive.// -->
                        </div>
                    </div>
                    </div>
                    <!-- card-body end// -->
                </div>
            </form>
                <!-- card end// -->
                <div class="pagination-area mt-30 mb-50">
                    <nav aria-label="Page navigation example">

                        <ul class="pagination justify-content-start">
                            <li class="page-item active"><a class="page-link" href="#">01</a></li>
                            <li class="page-item"><a class="page-link" href="#">02</a></li>
                            <li class="page-item"><a class="page-link" href="#">03</a></li>
                            <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">16</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="material-icons md-chevron_right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </section>
            <!-- content-main end// -->

@endsection
@endsection
