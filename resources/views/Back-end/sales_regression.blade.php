
@section('content')
@extends('layouts.back-main')
@section('main-container')
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


            <section class="content-main">
           
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Regression sales analysis</h2>
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
                                    <option>Show 20</option>
                                    <option>Show 30</option>
                                    <option>Show 40</option>
                                </select>
                            </div>
                        </div>
                    </header>
                    <!-- card-header end// -->
                   <div class="card-body">

                   @if(isset($message))
        <div class="alert alert-warning">
            {{ $message }}
        </div>
    @else
                   <div class="table-responsive">
                            <table id="category-table" class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>Product ID</th>
                        <th>Last Month</th>
                        <th>Previous Month</th>
                        <th>Regression Percentage</th>
                        <th>Last Month Revenue</th>
                        <th>Previous Month Revenue</th>
                                                </tr>
                                </thead>
                                <tbody>
    @foreach($data as $result)
        <tr>
            <td>
                <a href="#" class="itemside">
                    <div class="left">
                        <img src="{{ asset('storage/images/' . $result['product_image']) }}" class="img-sm img-avatar" alt="{{ $result['product_name'] }}" />
                    </div>
                    <div class="info pl-3">
                        <h6 class="mb-0 title">{{ $result['product_name'] }}</h6>
                        <small class="text-muted">Product ID: #{{ $result['product_id'] }}</small>
                    </div>
                </a>
            </td>
            <td>{{ isset($result['last_month_range']) ? implode(' - ', $result['last_month_range']) : 'N/A' }}</td>
            <td>{{ isset($result['previous_month_range']) ? implode(' - ', $result['previous_month_range']) : 'N/A' }}</td>
            <td>
                @if (isset($result['regression_percentage']))
                    @if ($result['regression_percentage'] < 0)
                        <span class="badge badge-pill badge-soft-danger">
                            {{ number_format($result['regression_percentage'], 2) }}%
                        </span>
                    @else
                        <span class="badge badge-pill badge-soft-success">
                            +{{ number_format($result['regression_percentage'], 2) }}%
                        </span>
                    @endif
                @else
                    N/A
                @endif
            </td>
            <td>€{{ isset($result['last_month_revenue']) ? number_format($result['last_month_revenue'], 2) : '0.00' }}</td>
            <td>€{{ isset($result['previous_month_revenue']) ? number_format($result['previous_month_revenue'], 2) : '0.00' }}</td>
        </tr>
    @endforeach
</tbody>

                            </table>
                            <!-- table-responsive.// -->
                        </div>
                        @endif
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
