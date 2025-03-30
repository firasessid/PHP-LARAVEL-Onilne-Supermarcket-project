
@section('content')
@extends('layouts.back-main')
@section('main-container')
            <section class="content-main">
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
./* Small styles for SweetAlert */
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
                        <h2 class="content-title card-title">Products List</h2>
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
                    <form action="{{ route('product_list') }}" method="GET" class="mt-3">
    <div class="row gx-3">
        <!-- Filtre par catégorie -->
        <div class="col-lg-2 col-md-3 me-auto">
                                <input type="text" id="search-input"
                                 placeholder="Search..." class="form-control">
                            </div>
        <div class="col-lg-2 col-md-3 col-6">
            <select name="category" class="form-select" onchange="this.form.submit()">
                <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filtre par sous-catégorie -->
        <div class="col-lg-2 col-md-3 col-6">
            <select name="subcategory" class="form-select" onchange="this.form.submit()">
                <option value="all" {{ request('subcategory') == 'all' ? 'selected' : '' }}>All Sub-Categories</option>
                @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}" {{ request('subcategory') == $subcategory->id ? 'selected' : '' }}>
                        {{ $subcategory->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filtre par marque -->
        <div class="col-lg-2 col-md-3 col-6">
            <select name="brand" class="form-select" onchange="this.form.submit()">
                <option value="all" {{ request('brand') == 'all' ? 'selected' : '' }}>All Brands</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filtre par statut -->
        <div class="col-lg-2 col-md-3 col-6">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
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
                                        <th>Product</th>
                                        <th>Rays</th>
                                        <th>Category</th>
                                        <th>Sub category </th>
                                        <th>Brand </th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Quantity</th>
                                        <th>Request</th>
                                        <th>Administrator</th>

                                        @if (auth()->user()->can('product-delete') || auth()->user()->can('product-edit'))
                                        <th class="text-end">Action</th>
                                        @else

            @endif
                                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($products as $p )

                                <tr>

                                        <td>
                                            <a  href="{{ route('products_view', ['id' => $p->id]) }}" class="itemside">
                                                <div class="left">
                                                    <img src="{{ asset('storage/images/' . optional($p->images->first())->image) }}" class="img-sm img-avatar" alt="Product Image" />
                                                </div>
                                                 <div class="left">
                                                </div>
                                                <div class="info pl-3">
                                                    <h6 class="mb-0 title">{{ $p->name }}</h6>
                                                    <small class="text-muted">Product ID: #{{ $p->id }}</small>
                                                </div>
                                            </a>
                                        </td>
                                        <td>{{ $p->rayName }}</td>
                                        <td>{{ $p->categoryName }} </td>
                                        <td>{{ $p->subcategoryName }}</td>

                                        <td>
                                          @if ($p->brandName == null)
                                          <div class="col-lg-2 col-sm-2 col-4 col-status">
                                            <span class="badge rounded-pill alert-warning">No brand given</span>
                                          </div>
                                          @else
                                        {{ $p->brandName }}
                                         @endif
                                         </td>

                                        <td>€{{ $p->sale_price }}</td>
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

                                        <td><span class="badge rounded-pill alert-danger">{{$p->quantity}} </span></td>







                                         <td>
                                            @if ($p->userName == 'admin')
                                                <div class="col-lg-2 col-sm-2 col-4 col-status">
                                                    <span class="badge rounded-pill alert-primary">Admin content  </span>
                                                </div>
                                            @else
                                                @if ($p->is_approved == 1)
                                                    <div class="col-lg-2 col-sm-2 col-4 col-status">
                                                        <span class="badge rounded-pill alert-success">Approved</span>
                                                    </div>
                                                @elseif($p->is_approved == 2)
                                                    <div class="col-lg-2 col-sm-2 col-4 col-status">
                                                        <span class="badge rounded-pill alert-primary">In process </span>
                                                    </div>
                                                    @else
                                                    <div class="col-lg-2 col-sm-2 col-4 col-status">
                                                        <span class="badge rounded-pill alert-danger">Rejected </span>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                        <div class="col-lg-2 col-sm-2 col-4 col-status">
                                                        <span class="badge rounded-pill alert-primary">{{$p->userName}} </span>
                                                    </div>
                                        </td>



                                        <td class="text-end">

                                            {{-- <form method="POST" action="{{ route('admin.products.approve', $product) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit">Accept</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.products.reject', $product) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit">Reject</button>
                                            </form> --}}

                                        <form method="POST" action="{{ route('delete', $p->id) }}">
    @csrf
    <input name="_method" type="hidden" value="DELETE">
    <!-- Edit Button -->
    @if ($p->is_approved == 1 && $p->user->id === auth()->user()->id)

    @can('product-edit')

    <a href="{{ route('edit', $p->id) }}" class="btn btn-xs btn-primary btn-flat " id="showAlertButton" data-toggle="tooltip" title="Edit">Edit</a>
    @endcan
@else
<a href="{{ route('request',[$p->id]) }}" class="btn btn-xs btn-primary btn-flat " id="showAlertButton" data-toggle="tooltip" title="Edit">view</a>
@endif
<!-- Delete Button -->

    @can('product-delete')

    <a href="#"   class="btn btn-sm font-sm btn-light rounded show_confirm "> Delete </a>
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
                <div class="pagination-area mt-30 mb-50">
    @if ($products->hasPages())
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($products->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="material-icons md-chevron_left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">
                            <i class="material-icons md-chevron_left"></i>
                        </a>
                    </li>
                @endif

                {{-- Page Numbers --}}
                @php
                    $start = max(1, $products->currentPage() - 2);
                    $end = min($products->lastPage(), $products->currentPage() + 2);
                @endphp

                @if ($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->url(1) }}">{{ sprintf('%02d', 1) }}</a>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page === $products->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ sprintf('%02d', $page) }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->url($page) }}">{{ sprintf('%02d', $page) }}</a>
                        </li>
                    @endif
                @endfor

                @if ($end < $products->lastPage())
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->url($products->lastPage()) }}">
                            {{ sprintf('%02d', $products->lastPage()) }}
                        </a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($products->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">
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

document.getElementById("showAlertButton").addEventListener("click", function() {
    let timerInterval
Swal.fire({
    title: '<span style="color: green;">Waiting...!</span>',
  html: 'Updating product.....',
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

$('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();

swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this Product ",
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
      'Product has been deleted.',
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
      'Your Product is safe :)',
      'error'
    )
  }
})




      });

</script>
@endsection
