














@section('content')
@extends('layouts.back-main')
@section('main-container')


            <section class="content-main">
            <style>
    /* General table styling */
    table th, table td {
        padding: 10px 5px; /* Adjust padding for compactness */
        text-align: center;
        vertical-align: middle; /* Ensure content aligns vertically */
    }

    /* Styling for the product name column */
    td:first-child {
        text-align: left; /* Align product names to the left */
        white-space: normal; /* Allow wrapping for long product names */
        word-wrap: break-word; /* Break words if they're too long */
        max-width: 200px; /* Set a max width to avoid excessive stretching */
    }

    /* Styling for images */
  

    /* Styling for product name and product ID text */
    .info {
        display: inline-block;
        vertical-align: middle;
        max-width: calc(100% - 50px); /* Leave space for the image */
    }

    .info h6 {
        margin: 0;
        font-size: 14px; /* Adjust font size for better readability */
        word-wrap: break-word; /* Allow word breaks */
    }

    .info small {
        font-size: 12px; /* Reduce size for Product ID */
        color: #999;
    }
</style>


                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Sales predictions</h2>
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
                <script>
    @if(session('success'))
    Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: 'Product created successfully',
    showConfirmButton: false,
    timer: 3500,
    customClass: {
        popup: 'small-popup-class',
        title: 'small-title-class',
        icon: 'small-icon-class'
    },
    timerProgressBar: true
});

    @endif
              </script>

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
            <th>Products</th>
            <th>Current Quantity</th>
            <th>Monthly Sales</th>
            <th>Total Sales</th>
            <th>Predicted Sales</th>
            <th>Predictions From</th>
            <th>Predictions To</th>
            <th>Recommended Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($forecastData as $data)
        <tr>
            <td>
                <a href="#" class="itemside">
                    <div class="left">
                        <img src="{{ asset('storage/images/' . $data['product_image']) }}" class="img-sm img-avatar" alt="{{ $data['product_name'] }}" />
                    </div>
                    <div class="info pl-3">
                        <h6 class="mb-0 title">{{ $data['product_name'] }}</h6>
                        <small class="text-muted">Product ID: #{{ $data['product_id'] }}</small>
                    </div>
                </a>
            </td>
            <td><span class="badge badge-pill badge-soft-danger">{{ $data['current_quantity'] }} in stock</span></td>
            <td>{{ $data['monthly_sales'] }}</td>
            <td>{{ $data['total_sales'] }}</td>
            <td>
                <span class="badge badge-pill badge-soft-success">
                    {{ number_format($data['predicted_sales'], 0) }}
                </span> 
                out of stock
            </td>
            <td>
                    {{ now()->format('d/m/Y') }}
            </td>
            <td>
                    {{ now()->addDays(30)->format('d/m/Y') }}
            </td>
            <td>{{ $data['recommended_quantity'] }}</td>
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
@section('customJs')

@endsection
