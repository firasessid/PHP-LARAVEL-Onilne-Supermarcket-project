@section('content')
@extends('layouts.back-main')
@section('main-container')
<section class="content-main">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Coupons List</h2>
        </div>
        <div>
            <a href="#" class="btn btn-light rounded font-md">Export</a>
            <a href="#" class="btn btn-light rounded font-md">Import</a>
            <a href="{{route('add_coupon')}}" class="btn btn-primary btn-sm rounded">+ Add</a>
        </div>
    </div>
    <form action="" method="get">
        <script>
            @if(session('success'))
            Swal.fire({
                position: 'top-end'
                , icon: 'success'
                , title: 'Product created successfully'
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
                                <th>Code</th>

                                <th>Segment</th>
                                <th>Required points</th>
                                <th>Max use </th>
                                <th>Max user use</th>

                                <th>Discount</th>
                                <th>Min amount</th>
                                <th>Staus</th>
                                <th>Starts at</th>
                                <th>Expires at</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupon as $p )

                            <tr>

                                <td >
                                    <a class="fw-bold">#{{ $p->code}}</a>

                                </td>
                                
                                <td>{{$p->target_segment}} </td>
                                <td>{{$p->points_required}} </td>
                                <td>{{$p->max_uses}} </td>
                                <td>{{$p->max_uses_user}} </td>

                                <td>
                                    @if ($p->type == 'percent') {{$p->discount_amount}}%
                                    @else €{{$p->discount_amount}}
                                     @endif

                                </td>
                                

                                <td>€{{$p->min_amount}} </td>

                                <td>
                                    @if ($p->status == 1)
                                    <div class="col-lg-2 col-sm-2 col-4 col-status">
                                        <span class="badge badge-pill badge-soft-success">Active</span>
                                    </div>
                                    @else
                                    <div class="col-lg-2 col-sm-2 col-4 col-status">
                                        <span class="badge badge-pill badge-soft-danger">Inactive</span>
                                    </div>
                                    @endif
                                </td>
                                <td> <span class="badge badge-pill badge-soft-success">{{ $p->starts_at }}</span>
                                </td>
                                <td><span class="badge badge-pill badge-soft-danger">  {{ $p->expires_at }} </span>
                                  </td>
                                   
                              <td class="text-end">
                              <form method="POST" action="{{ route('deletecoupon', $p->id) }}">
    @csrf
    <input name="_method" type="hidden" value="DELETE">
    <div class="d-flex gap-2 align-items-center"> <!-- Retirez flex-column -->
        <a href="{{ route('edit', $p->id) }}" class="btn btn-xs btn-primary btn-flat">Edit</a>
        <a href="#" class="btn btn-sm font-sm btn-light rounded show_confirm">
            <i class="material-icons md-delete_forever"></i> Delete
        </a>
    </div>
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
   .table-hover thead th {
        white-space: nowrap;
        padding: 12px 15px !important;
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
  html: 'Updating coupon.....',
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
  text: "You won't be able to revert this Coupon ",
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
      'Coupon has been deleted.',
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
      'Your Coupon is safe :)',
      'error'
    )
  }
})




      });

</script>
@endsection
