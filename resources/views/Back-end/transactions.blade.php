
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
                        <h2 class="content-title card-title">Transactions List</h2>
                    </div>
                   
                </div>
                


                <form action="" method="get">
    <div class="card mb-4">
        <header class="card-header">
        <form method="GET" action="{{ route('transactions') }}" class="mb-3">
  
        <div class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <input type="text" id="search-input" placeholder="Search..." class="form-control">
                </div>
               
                <div class="col-lg-2 col-md-3 col-6">
                <select name="per_page" class="form-select" onchange="this.form.submit()">
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                <option value="40" {{ request('per_page') == 40 ? 'selected' : '' }}>40</option>
            </select>
                </div>
            </div>
            </form>
        </header>

        <div class="card-body">
            <div class="table-responsive">
                <table id="category-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Paid amount</th>
                            <th>Method</th>
                            <th>Customer</th>
                            <th>Transaction date</th>

                            <!-- Show Action column only for admin roles (except client) -->
                            @if(!Auth::user()->hasRole('client'))
                                <th class="text-end">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $p)
                            @if($p->payment_method == 'card' || $p->payment_method == 'paypal')
                                <!-- If user is not a client, show all transactions -->
                                @if(!Auth::user()->hasRole('client'))
                                    <tr>
                                        <td><h6 class="mb-0 title">#{{ $p->id }}</h6></td>
                                        <td><h6 class="mb-0 title">€{{ $p->grand_total }}</h6></td>

                                        @if($p->payment_method == 'card')
                                            <td>
                                                <div class="icontext">
                                                    <img class="icon border" src="assets/imgs/card-brands/2.png" alt="Payment" />
                                                    <span class="text text-muted">Master card</span>
                                                </div>
                                            </td>
                                        @elseif($p->payment_method == 'paypal')
                                            <td>
                                                <div class="icontext">
                                                    <img class="icon border" src="assets/imgs/card-brands/3.png" alt="Payment" />
                                                    <span class="text text-muted">Paypal</span>
                                                </div>
                                            </td>
                                        @endif

                                        <td>
                                            <a href="#" class="itemside">
                                                <div class="info pl-3">
                                                    <h6 class="mb-0 title">{{ $p->userName }}</h6>
                                                    <small class="text-muted">User ID: #{{ $p->userID }}</small>
                                                </div>
                                            </a>
                                        </td>

                                        <td>
                                            <span class="badge badge-pill badge-soft-success">{{$p->created_at}}</span>
                                        </td>

                                        <!-- Show delete button only for admin roles -->
                                        @if(!Auth::user()->hasRole('client'))
                                            <td class="text-end">
                                                <form method="POST" action="{{ route('delete', $p->id) }}">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <a href="#" class="btn btn-sm font-sm btn-light rounded show_confirm">
                                                        <i class="material-icons md-delete_forever show_confirm"></i> Delete
                                                    </a>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @elseif($p->userID == Auth::user()->id) <!-- Show only the transactions of the logged-in client -->
                                    <tr>
                                        <td><h6 class="mb-0 title">#{{ $p->id }}</h6></td>
                                        <td><h6 class="mb-0 title">€{{ $p->grand_total }}</h6></td>

                                        @if($p->payment_method == 'card')
                                            <td>
                                                <div class="icontext">
                                                    <img class="icon border" src="assets/imgs/card-brands/2.png" alt="Payment" />
                                                    <span class="text text-muted">Master card</span>
                                                </div>
                                            </td>
                                        @elseif($p->payment_method == 'paypal')
                                            <td>
                                                <div class="icontext">
                                                    <img class="icon border" src="assets/imgs/card-brands/3.png" alt="Payment" />
                                                    <span class="text text-muted">Paypal</span>
                                                </div>
                                            </td>
                                        @endif

                                        <td>
                                            <a href="#" class="itemside">
                                                <div class="info pl-3">
                                                    <h6 class="mb-0 title">{{ $p->userName }}</h6>
                                                    <small class="text-muted">User ID: #{{ $p->userID }}</small>
                                                </div>
                                            </a>
                                        </td>

                                        <td>
                                            <span class="badge badge-pill badge-soft-success">{{$p->created_at}}</span>
                                        </td>

                                        <!-- No delete button for clients -->
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
@unless (Auth::user()->hasRole('client'))

                
                <!-- card end// -->
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
                        <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">
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
                        <a class="page-link" href="{{ $orders->url(1) }}">{{ sprintf('%02d', 1) }}</a>
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
                            <a class="page-link" href="{{ $orders->url($page) }}">{{ sprintf('%02d', $page) }}</a>
                        </li>
                    @endif
                @endfor

                @if ($end < $orders->lastPage())
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->url($orders->lastPage()) }}">
                            {{ sprintf('%02d', $orders->lastPage()) }}
                        </a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($orders->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">
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
