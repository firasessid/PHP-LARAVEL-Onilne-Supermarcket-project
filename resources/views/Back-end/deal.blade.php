@section('content')
@extends('layouts.back-main')
@section('main-container')

<section class="content-main">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="row">

        <form action="{{ route('deals.store') }}" id="dealForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-9">
                <div class="content-header">
                    <h2 class="content-title">Create Deal</h2>
                    <div>
                        <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Cancel</button>
                        <button id="showAlertButton" class="btn btn-md rounded font-sm hover-up show_alert">Create</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Info</h4>
                    </div>

                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label">Choose product</label>
                            <div class="custom_select">
                                <select class="form-select select-nice" id="product" name="product_id"> <!-- Change 'name' to 'product_id' -->
                                    <option>All Products</option>
                                    @if ($products->isNotEmpty())
                                        @foreach ($products as $p)
                                            <option value="{{$p->id}}">{{$p->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>




                        <div class="mb-4">

                            <label  class="form-label">Discount amount</label>
                            <div class="input-container">
                                <input type="number" id="discount_percentage" name="discount_percentage" placeholder="Discount" class="form-control ">
                                <p></p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Date</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="starts_at" class="form-label">Starts at </label>
                                    <div class="input-container">
                                        <input type="datetime-local" id="starts_at" name="starts_at" placeholder="$US" class="form-control ">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="ends_at" class="form-label">Ends at</label>
                                    <div class="input-container">
                                        <input type="datetime-local" id="ends_at" name="ends_at"  class="form-control ">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="input-upload">
                                        <img for="image" src="assets/imgs/theme/upload.svg" alt="" />
                                        <div class="input-container">
                                            <input type="file" name="image"
                                                class="form-control @error('image') is-invalid @enderror">
                                            @error('image')
                                                <i class="fas fa-exclamation-circle"></i>
                                            @enderror
                                        </div>
                                    </div>
                        </div>



                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</section>
<!-- content-main end// -->

@endsection
@endsection

@section('customJs')

<script>







    document.getElementById("showAlertButton").addEventListener("click", function() {
        let timerInterval
        Swal.fire({
            title: '<span style="color: green;">Waiting...!</span>'
            , html: 'Creating new deal.'
            , timer: 1200
            , timerProgressBar: true
            , didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                }, 100)
            }
            , willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
        })

    });



    $("#dealForm").submit(function(event){
    event.preventDefault();

    // Create a FormData object to handle the form data, including files
    var formData = new FormData($(this)[0]);

    $.ajax({
        url: '{{ route("deals.store") }}',
        type: 'post',
        data: formData, // Use the FormData object here
        dataType: 'json',
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting content type
        success: function(response) {
          var errors = response.errors;

        if (response.status==false)
        {



            if(errors.image)
          {

                $("#image").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.image);
          } else {
                $("#image").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('');
          }



          if(errors.discount_percentage)
          {

                $("#discount_percentage").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.discount_percentage);
          } else {
                $("#discount_percentage").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('');
          }


          if(errors.starts_at)
          {

                $("#starts_at").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.starts_at);
          } else {
                $("#starts_at").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('');
          }

          if(errors.ends_at)
          {

                $("#ends_at").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.ends_at);
          } else {
                $("#ends_at").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('');
          }
        }
       else {
           window.location.href="{{ url('deals') }}" ;
             }

        }
    })
    });



</script>

<style>
    .input-container {
        position: relative;
    }

    .is-invalid {
        border: 1px solid red;
        /* Red border */
    }

    .fa-exclamation-circle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: red;
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }

    input.error,
    select.error {
        border: 1px solid red;
    }

</style>

@endsection

