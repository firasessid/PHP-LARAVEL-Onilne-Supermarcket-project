@section('content')
@extends('layouts.back-main')
@section('main-container')

<section class="content-main">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
        }

        .alert.success {
            padding: 20px;
            background-color: #04AA6D;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }

        /* Compact styles for SweetAlert */
        .

        /* Small styles for SweetAlert */
        /* Small styles for SweetAlert */
        .small-popup-class {
            border-radius: 2px;
            padding: 3px;
            background-color: #fff;
        }

        .small-title-class {
            color: #4caf50;
            font-size: 15px;
            margin-bottom: 1px;
        }

        .small-icon-class {
            font-size: 12px;
            color: #4caf50;
        }

        .table-hover thead th {
            white-space: nowrap;
            padding: 19px 25px !important;
            text-align: center;
        }

        .table-hover tbody td {
            text-align: right;
            vertical-align: middle;
        }

        .table-hover tbody td:first-child,
        .table-hover tbody td:nth-child(2),
        .table-hover tbody td:nth-child(3) {
            text-align: left;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .table-hover tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn-flat {
            padding: 4px 10px;
            font-size: 12px;
        }

        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
        }

        .alert.success {
            padding: 20px;
            background-color: #04AA6D;
            color: white;
        }
        th, td {
    width: auto !important; /* This can override default behavior */
}
        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Shipping management</h2>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    </div>
    <script>
        @if(session('success'))
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Ctagory created successfully',
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
        <div class="card-header">
            <form method="POST" action="action=" {{ route('shipping.store') }}" id="shippingForm" name="shippingForm">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <div class="custom_select">
                                <select name="country" id="country" class="form-select select-nice">
                                    <option value="">Select a city</option>
                                    @foreach ($countries as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                    <option value="rest">Rest of the world</option>
                                </select>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <input type="text" name="amount" id="amount" placeholder="Enter amount" class="form-control"
                                id="product_name" />
                            <p></p>

                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm rounded" type="submit">Add amount<i
                                    class="fi-rs-sign-out ml-15"></i></button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <div class="card mb-4">
        <header class="card-header">
            <!-- Filtering and Pagination Form -->
            <form action="{{ route('shipping.create') }}" method="GET" class="mt-3">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-6 me-auto">
                        <input type="text" id="search-input" placeholder="Search..." class="form-control">
                    </div>

                    <!-- Filter by Countries -->
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <select name="country" class="form-select" onchange="this.form.submit()">
                            <option value="all" {{ request('country') == 'all' ? 'selected' : '' }}>All Countries</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ request('country') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                            <option value="rest" {{ request('country') == 'rest' ? 'selected' : '' }}>Rest of the World
                            </option>
                        </select>
                    </div>

                    <!-- Pagination Selector -->
                    <div class="col-lg-2 col-md-3 col-sm-6 ">
                        <select name="per_page" class="form-select" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>Show 10</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>Show 20</option>
                            <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>Show 30</option>
                        </select>
                    </div>
                </div>
            </form>

        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
               <!-- Table for Shipping Data -->
<table class="table table-bordered ">
    <thead class="text-black">
                        <tr>
                            <th>ID</th>

                            <th>City </th>
                            <th>Amount</th>
                            <th>Created at </th>
                            <th>Updated at</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shipping as $c)
                            <tr id="search-results">
                                <td width="20%">
                                    <span>#{{ $c->id}}</span>
                                </td>
                                <td>
                                    <a>
                                        @if ($c->country_id === 'rest')
                                            Rest of the World
                                        @else
                                            {{ $c->countryName ?? 'No Country' }}
                                        @endif
                                    </a>

                                </td>

                                <td>
                                    <div class="col-lg-2 col-sm-2 col-4 col-status">
                                        <span class="badge badge-pill badge-soft-danger">€{{ $c->amount }}</span>
                                    </div>
                                </td>
                                <td> <span class="badge badge-pill badge-soft-success">{{ $c->created_at }}</span>
                                </td>
                                <td><span class="badge badge-pill badge-soft-danger"> {{ $c->updated_at }} </span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('deleteshipping', $c->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <!-- Edit Button -->
                                        <a href="" class="btn btn-xs btn-primary btn-flat " id="showAlertButton"
                                            data-toggle="tooltip" title="Edit">Edit</a>
                                        <!-- Delete Button -->
                                        <a href="#" class="btn btn-sm font-sm btn-light rounded show_confirm "> <i
                                                class="material-icons md-delete_forever show_confirm"></i> Delete </a>
                                    </form>
                                </td>
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
        @if ($shipping->hasPages())
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        {{-- Previous Page Link --}}
                        @if ($shipping->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="material-icons md-chevron_left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $shipping->previousPageUrl() }}" rel="prev">
                                    <i class="material-icons md-chevron_left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                            $start = max(1, $shipping->currentPage() - 2);
                            $end = min($shipping->lastPage(), $shipping->currentPage() + 2);
                        @endphp

                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $shipping->url(1) }}">{{ sprintf('%02d', 1) }}</a>
                            </li>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif

                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page === $shipping->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ sprintf('%02d', $page) }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $shipping->url($page) }}">{{ sprintf('%02d', $page) }}</a>
                                </li>
                            @endif
                        @endfor

                        @if ($end < $shipping->lastPage())
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="{{ $shipping->url($shipping->lastPage()) }}">
                                    {{ sprintf('%02d', $shipping->lastPage()) }}
                                </a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($shipping->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $shipping->nextPageUrl() }}" rel="next">
                                    <i class="material-icons md-chevron_right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="material-icons md-chevron_right"></i></span>
                            </li>
                        @endif
                    </ul>
                </nav>
        @endif

</section>
<!-- content-main end// -->

@endsection
@endsection
@section('customJs')




<script>




    $("#shippingForm").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: '{{ route("shipping.store") }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (response) {
                var errors = response.errors;

                if (response.status == false) {

                    if (errors.country) {

                        $("#country").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors.country);
                    } else {
                        $("#country").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');
                    }

                    if (errors.amount) {

                        $("#amount").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors.amount);
                    } else {
                        $("#amount").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');
                    }


                }
                else {
                    window.location.href = "{{ url('shippings') }}";
                }


            }

        })
    });






















    $(document).ready(function () {
        $('#search-input').on('keyup', function () {
            var query = $(this).val().trim().toLowerCase();
            if (query !== '') {
                $('#category-table tbody tr').each(function () {
                    var rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.indexOf(query) > -1);
                });
            } else {
                $('#category-table tbody tr').show();
            }
        });
    });






    document.getElementById("showAlertButton").addEventListener("click", function () {
        let timerInterval
        Swal.fire({
            title: '<span style="color: green;">Waiting...!</span>',
            html: 'Updating Shipping amount.....',
            timer: 4000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
        })

    });





    $('.show_confirm').click(function (event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();

        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this Shipping amount ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                swal.fire(
                    'Deleted!',
                    'Shipping amount has been deleted.',
                    'success'
                )

                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }
                    });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swal.fire(
                    'Cancelled',
                    'Your Shipping amount is safe :)',
                    'error'
                )
            }
        })




    });

</script>
@endsection