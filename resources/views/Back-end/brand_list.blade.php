
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
                        <h2 class="content-title card-title">Brands List</h2>
                    </div>


                    <div>
                        <a href="#" class="btn btn-light rounded font-md">Export</a>
                        <a href="#" class="btn btn-light rounded font-md">Import</a>
                        @can('brand-create')

                        <a href="{{route('add_brand')}}" class="btn btn-primary btn-sm rounded">Create new</a>
                        @endcan

                    </div>
                </div>
                <form action="" method="get">
                <script>
     @if(session('success'))
    Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: 'Brand created successfully',
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
                    <form action="{{ route('brand_list') }}" method="GET" class="mt-3">
    <div class="row gx-3">
    
<div class="col-lg-4 col-md-6 me-auto">
                                <input type="text" id="search-input"
                                 placeholder="Search..." class="form-control">
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


                   @foreach ($brands as $p )


                        <article class="itemlist" id="category-table"
>
                            <div class="row align-items-center">
                                <div class="col col-check flex-grow-0">

                                </div>
                                <div class="col-lg-4 col-sm-4 col-8 flex-grow-1 col-name">
                                    <a class="itemside" href="#">
                                        <div class="left">

                                        <img src="{{ asset('storage/images/' . $p->image) }}" alt="{{ $p->name }}" width="50">
                                        </div>
                                        <div class="info">
                                            <h6 class="mb-0">{{$p->name}}</h6>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-4 col-price"><span>{{$p->slug}}</span></div>
                               @if ($p->status == 1)

                                <div class="col-lg-2 col-sm-2 col-4 col-status">
                                    <span class="badge rounded-pill alert-success">Active</span>
                                </div>

                               @else

                               <div class="col-lg-2 col-sm-2 col-4 col-status">
                                <td><span class="badge rounded-pill alert-danger">Inactive</span></td>
                               </div>

                                @endif
                                <div class="col-lg-2 col-sm-2 col-4 col-action text-end">
                                    @can('brand-delete')

                                    <form method="POST" action="{{ route('deletebrand', $p->id) }}">
                                        @endcan

                                        @csrf
    <!-- Edit Button -->
    @can('brand-edit')

    <a href="{{ route('edit', $p->id) }}" class="btn btn-xs btn-primary btn-flat " id="showAlertButton" data-toggle="tooltip" title="Edit">Edit</a>
   @endcan
    <!-- Delete Button -->
    <a href="#"   class="btn btn-sm font-sm btn-light rounded show_confirm "> <i class="material-icons md-delete_forever"></i> Delete </a>
</form>


                                </div>
                            </div>
                            <!-- row .// -->
                        </article>

                        @endforeach
                    </div>
                    <!-- card-body end// -->
                </div>
            </form>

                <!-- card end// -->
               <!-- Pagination -->
<div class="pagination-area mt-30 mb-50">
    @if ($brands->hasPages())
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($brands->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="material-icons md-chevron_left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $brands->previousPageUrl() }}" rel="prev">
                            <i class="material-icons md-chevron_left"></i>
                        </a>
                    </li>
                @endif

                {{-- Page Numbers --}}
                @php
                    $start = max(1, $brands->currentPage() - 2);
                    $end = min($brands->lastPage(), $brands->currentPage() + 2);
                @endphp

                @if ($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $brands->url(1) }}">{{ sprintf('%02d', 1) }}</a>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page === $brands->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ sprintf('%02d', $page) }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $brands->url($page) }}">{{ sprintf('%02d', $page) }}</a>
                        </li>
                    @endif
                @endfor

                @if ($end < $brands->lastPage())
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $brands->url($brands->lastPage()) }}">
                            {{ sprintf('%02d', $brands->lastPage()) }}
                        </a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($brands->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $brands->nextPageUrl() }}" rel="next">
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

<script type="text/javascript">


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






$('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();

swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this Brand ",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#08a25f',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
    swal.fire(
      'Deleted!',
      'Brand has been deleted.',
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
      'Your Brand is safe :)',
      'error'
    )
  }
})




      });



document.getElementById("showAlertButton").addEventListener("click", function() {
    let timerInterval
Swal.fire({
  title: '<span style="color: green;">Waiting...!</span>',
  html: 'Updating brand.....',
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




</script>
@endsection
