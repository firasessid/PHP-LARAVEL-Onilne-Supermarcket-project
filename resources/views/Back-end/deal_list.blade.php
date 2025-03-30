@section('content')
@extends('layouts.back-main')
@section('main-container')
<section class="content-main">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Deals List</h2>
        </div>
        <div>
            <a href="#" class="btn btn-light rounded font-md">Export</a>
            <a href="#" class="btn btn-light rounded font-md">Import</a>
            <a href="{{route('deals.create')}}" class="btn btn-primary btn-sm rounded">+ Add</a>
        </div>
    </div>
    <form action="" method="get">
        <script>
            @if(session('success'))
            Swal.fire({
                position: 'top-end'
                , icon: 'success'
                , title: 'Deal created successfully'
                , showConfirmButton: false
                , timer: 3500
                , customClass: {
                    popup: 'small-popup-class'
                    , title: 'small-title-class'
                    , icon: 'small-icon-class'
                }
                , timerProgressBar: true
            });

            @endif

        </script>

        <div class="card mb-4">
            <header class="card-header">
                <div class="row gx-3">

                    <div class="col-lg-4 col-md-6 me-auto">
                        <input type="text" id="search-input" placeholder="Search..." class="form-control">
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
                                <th>Product</th>
                                <th>Discount</th>
                                <th>Starts at</th>
                                <th>Ends at</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deals as $p )

                            <tr>
                                <td>
                                    <a  href="#" class="itemside">
                                        <div class="left">
                                            <img src="{{ asset('storage/images/' . optional($p->product->images->first())->image) }}" class="img-sm img-avatar" alt="Product Image" />
                                        </div>
                                         <div class="left">
                                        </div>
                                        <div class="info pl-3">
                                            <h6 class="mb-0 title">{{ $p->product->name }}</h6>
                                            <small class="text-muted">Product ID: #{{ $p->product->id }}</small>
                                        </div>
                                    </a>

                                </td>

                                <td>
                                    €{{ $p->discount_percentage}}

                                </td>

                                <td> <span class="badge badge-pill badge-soft-success">{{ $p->starts_at }}</span>
                                </td>
                                <td><span class="badge badge-pill badge-soft-danger">  {{ $p->ends_at }} </span>
                                  </td>
                                    {{-- <td>
                                        @if ($p->brandName == null)
                                        <div class="col-lg-2 col-sm-2 col-4 col-status">
                                            <span class="badge rounded-pill alert-warning">No brand given</span>
                                        </div>
                                        @else
                                        {{ $p->brandName }}
                                        @endif
                                    </td> --}}
                                <td class="text-end">
                                    <form method="POST" action="{{ route('deletecoupon', $p->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <!-- Edit Button -->
                                        <a href="{{ route('edit', $p->id) }}" class="btn btn-xs btn-primary btn-flat " id="showAlertButton" data-toggle="tooltip" title="Edit">Edit</a>
                                        <!-- Delete Button -->
                                        <a href="#" class="btn btn-sm font-sm btn-light rounded show_confirm "> <i class="material-icons md-delete_forever show_confirm"></i> Delete </a>
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
  html: 'Updating deal.....',
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
  text: "You won't be able to revert this Deal ",
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
      'Deal has been deleted.',
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
      'Your Deal is safe :)',
      'error'
    )
  }
})




      });

</script>
@endsection
