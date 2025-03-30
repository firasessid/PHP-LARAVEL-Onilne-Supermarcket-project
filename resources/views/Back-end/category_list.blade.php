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
    </style>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Category List</h2>
        </div>


        <div>
            <a href="#" class="btn btn-light rounded font-md">Export</a>
            <a href="#" class="btn btn-light rounded font-md">Import</a>
            @can('category-create')

                <a href="{{route('add_categorie')}}" class="btn btn-primary btn-sm rounded">Create new</a>
            @endcan

        </div>
    </div>
    <form action="" method="get">
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
            <header class="card-header">
              
            <form action="{{ route('categorie_list') }}" method="GET" class="mt-3">
    <div class="row gx-3">
    <div class="col-lg-4 col-md-6 me-auto">
                            <input type="text" id="search-input" placeholder="Search..." class="form-control">
                        </div>

    <!-- Filtre par statut -->
        <div class="col-lg-2 col-md-3 col-6">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Filtre par rayon -->
        <div class="col-lg-2 col-md-3 col-6">
            <select name="ray" class="form-select" onchange="this.form.submit()">
                <option value="all" {{ request('ray') == 'all' ? 'selected' : '' }}>All Rays</option>
                @foreach ($rays as $ray)
                    <option value="{{ $ray->id }}" {{ request('ray') == $ray->id ? 'selected' : '' }}>
                        {{ $ray->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sélecteur pour définir le nombre d'éléments par page -->
        <div class="col-lg-2 col-md-3 col-6">
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
                    <table id="category-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Rays</th>
                                <th>Status</th>
                                @if (auth()->user()->can('user-category') || auth()->user()->can('category-edit'))
                                    <th class="text-end">Action</th>
                                @else

                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $p)

                                <tr id="search-results">


                                    <td width="40%">
                                        <a href="#" class="itemside">
                                            <div class="left">
                                                <img src="{{ asset('storage/images/' . $p->image) }}"
                                                    class="img-sm img-avatar" alt="Userpic" />
                                            </div>
                                            <div class="left">
                                            </div>
                                            <div class="info pl-3">
                                                <h6 class="mb-0 title">{{ $p->name }}</h6>
                                                <small class="text-muted">Category ID: #{{ $p->id }}</small>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="info pl-3">
                                            <h6 class="mb-0 title">{{ $p->rayName }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($p->status == 1)

                                            <div class="col-lg-2 col-sm-2 col-4 col-status">
                                                <span class="badge rounded-pill alert-success">Active</span>
                                            </div>

                                        @else

                                            <div class="col-lg-2 col-sm-2 col-4 col-status">
                                                <span class="badge rounded-pill alert-danger">Inactive</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('deletecateg', $p->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <!-- Edit Button -->
                                            @can('category-edit')

                                                <a href="{{ route('category.edit', $p->id) }}"
                                                    class="btn btn-xs btn-primary btn-flat " id="showAlertButton"
                                                    data-toggle="tooltip" title="Edit">Edit</a>
                                            @endcan
                                            <!-- Delete Button -->
                                            @can('category-delete')

                                                <a href="#" class="btn btn-sm font-sm btn-light rounded show_confirm "> <i
                                                        class="material-icons md-delete_forever show_confirm"></i> Delete </a>
                                            @endcan
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
    </form>
    <!-- card end// -->
    <!-- Pagination -->
    <div class="pagination-area mt-30 mb-50">
    @if ($categories->hasPages())
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($categories->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="material-icons md-chevron_left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev">
                            <i class="material-icons md-chevron_left"></i>
                        </a>
                    </li>
                @endif

                {{-- Page Numbers --}}
                @php
                    $start = max(1, $categories->currentPage() - 2);
                    $end = min($categories->lastPage(), $categories->currentPage() + 2);
                @endphp

                @if ($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $categories->url(1) }}">{{ sprintf('%02d', 1) }}</a>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page === $categories->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ sprintf('%02d', $page) }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $categories->url($page) }}">{{ sprintf('%02d', $page) }}</a>
                        </li>
                    @endif
                @endfor

            

                {{-- Next Page Link --}}
                @if ($categories->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next">
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
</div>
</section>
<!-- content-main end// -->

@endsection
@endsection
@section('customJs')




<script>

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
            html: 'Updating category.....',
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
            text: "You won't be able to revert this Category ",
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
                    'Category has been deleted.',
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
                    'Your Category is safe :)',
                    'error'
                )
            }
        })




    });

</script>
@endsection