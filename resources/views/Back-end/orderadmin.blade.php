
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
                        <h2 class="content-title card-title">Orders List</h2>
                    </div>
                   
                </div>
                <form action="" method="get">

                    <div class="card mb-4">
                          <!-- card-header end// -->
                          <form method="GET" action="{{ route('orderadmin') }}" class="card mb-4">
    <header class="card-header">
        <div class="row gx-3 align-items-center">
            <div class="col-lg-4 col-md-6 me-auto">
                <input type="text" id="search-input" name="search" placeholder="Search..." class="form-control" value="{{ request('search') }}">
            </div>
            <div class="col-lg-2 col-md-3 col-6">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Show all</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-3 col-6">
                <select name="per_page" class="form-select" onchange="this.form.submit()">
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>Show 50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>Show 100</option>
                    <option value="150" {{ request('per_page') == 150 ? 'selected' : '' }}>Show 150</option>
                </select>
            </div>
        </div>
    </header>
</form>
                          <div class="card-body">
                        <div class="table-responsive">
                            <table id="category-table" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Date Purchased</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $p)
    @if(Auth::user()->hasRole('client') && $p->user_id == Auth::id())
        <!-- Client: Display only their own orders and no delete button -->
        <tr>
            <td>
                <a href="#" class="itemside">
                    <div class="info pl-3">
                        <h6 class="mb-0 title">{{ $p->userName }}</h6>
                        <small class="text-muted">Order ID: #{{ $p->id }}</small>
                    </div>
                </a>
            </td>
            <td>{{ $p->userEmail }} </td>
            <td>{{ $p->phone }} </td>
            <td>
                @if($p->status == 'pending')
                    <span class="badge badge-pill badge-soft-danger">Pending</span>
                @elseif($p->status == 'shipped')
                    <span class="badge badge-pill badge-soft-warning">Shipped</span>
                @else
                    <span class="badge badge-pill badge-soft-success">Delivered</span>
                @endif
            </td>
            <td>${{ $p->grand_total }}</td>
            <td>
                <span class="badge badge-pill badge-soft-success">{{ $p->created_at }}</span>
            </td>
            <td class="text-end">
                <!-- Details Button -->
                <a href="{{ route('orderDetails', [$p->id]) }}" 
                   class="btn btn-xs btn-primary btn-flat" 
                   title="Details">Details</a>
            </td>
        </tr>
    @elseif(!Auth::user()->hasRole('client'))
        <!-- Admin: Display all orders with the delete button -->
        <tr>
            <td>
                <a href="#" class="itemside">
                    <div class="info pl-3">
                        <h6 class="mb-0 title">{{ $p->userName }}</h6>
                        <small class="text-muted">Order ID: #{{ $p->id }}</small>
                    </div>
                </a>
            </td>
            <td>{{ $p->userEmail }} </td>
            <td>{{ $p->phone }} </td>
            <td>
                @if($p->status == 'pending')
                    <span class="badge badge-pill badge-soft-danger">Pending</span>
                @elseif($p->status == 'shipped')
                    <span class="badge badge-pill badge-soft-warning">Shipped</span>
                @else
                    <span class="badge badge-pill badge-soft-success">Delivered</span>
                @endif
            </td>
            <td>${{ $p->grand_total }}</td>
            <td>
                <span class="badge badge-pill badge-soft-success">{{ $p->created_at }}</span>
            </td>
            <td class="text-end">
                <!-- Details Button -->
                <a href="{{ route('orderDetails', [$p->id]) }}" 
                   class="btn btn-xs btn-primary btn-flat" 
                   title="Details">Details</a>

                <!-- Delete Button -->
                <form method="POST" action="{{ route('delete', $p->id) }}" style="display:inline;">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button type="button" 
                            class="btn btn-sm font-sm btn-light rounded show_confirm">
                        <i class="material-icons md-delete_forever"></i> Delete
                    </button>
                </form>
            </td>
        </tr>
    @endif
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
                @unless (Auth::user()->hasRole('client'))

                <div class="pagination-area mt-30 mb-50">
    @if ($orders->hasPages())
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($orders->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="material-icons md-chevron_left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->previousPageUrl() }}{{ request()->getQueryString() ? '?' . request()->merge(['page' => $orders->currentPage() - 1])->getQueryString() : '' }}" rel="prev">
                            <i class="material-icons md-chevron_left"></i>
                        </a>
                    </li>
                @endif

                {{-- Page Numbers --}}
                @php
                    $start = max(1, $orders->currentPage() - 2);
                    $end = min($orders->lastPage(), $orders->currentPage() + 2);
                @endphp

                @if ($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->url(1) }}{{ request()->getQueryString() ? '?' . request()->merge(['page' => 1])->getQueryString() : '' }}">{{ sprintf('%02d', 1) }}</a>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page === $orders->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ sprintf('%02d', $page) }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $orders->url($page) }}{{ request()->getQueryString() ? '?' . request()->merge(['page' => $page])->getQueryString() : '' }}">{{ sprintf('%02d', $page) }}</a>
                        </li>
                    @endif
                @endfor

                @if ($end < $orders->lastPage())
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->url($orders->lastPage()) }}{{ request()->getQueryString() ? '?' . request()->merge(['page' => $orders->lastPage()])->getQueryString() : '' }}">
                            {{ sprintf('%02d', $orders->lastPage()) }}
                        </a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($orders->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->nextPageUrl() }}{{ request()->getQueryString() ? '?' . request()->merge(['page' => $orders->currentPage() + 1])->getQueryString() : '' }}" rel="next">
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
@endunless
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
  html: 'Order details .....',
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
      'Order has been deleted.',
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
      'The order is safe :)',
      'error'
    )
  }
})




      });

</script>
@endsection
