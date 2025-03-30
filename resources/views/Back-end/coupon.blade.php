@section('content')
@extends('layouts.back-main')
@section('main-container')
<section class="content-main">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="row">
        <form action="{{ route('coupon_create') }}" id="couponForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-9">
                <div class="content-header">
                    <h2 class="content-title">Add New Coupon</h2>
                    <div>
                        <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Cancel</button>
                        <button id="showAlertButton" class="btn btn-md rounded font-sm hover-up show_alert">Create</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Distribution</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="segment" class="form-label">Segment </label>
                                    <div class="input-container">
                                    <input type="text" id="segment" name="segment" placeholder="Segment" class="form-control ">
                                    <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="points" class="form-label">Points</label>
                                    <div class="input-container">
                                    <input type="text" id="points" name="points" placeholder="Point required" class="form-control ">
                                    <p></p>
                                    </div>
                                </div>
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
                                    <label for="expires_at" class="form-label">Expires at</label>
                                    <div class="input-container">
                                        <input type="datetime-local" id="expires_at" name="expires_at" placeholder="$US" class="form-control ">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Info</h4>
                    </div>

                    <div class="card-body">
                        <!-- Code and Name in same line -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Code</label>
                                    <div class="input-container">
                                        <input type="text" id="code" name="code" placeholder=" Type Code" class="form-control ">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Name</label>
                                    <div class="input-container">
                                        <input type="text" id="name" name="name" placeholder="Coupon name" class="form-control ">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Max uses and Max uses user in same line -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Max uses</label>
                                    <div class="input-container">
                                        <input type="text" id="max_uses" name="max_uses" placeholder="Type here" class="form-control ">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Max uses user</label>
                                    <div class="input-container">
                                        <input type="text" id="max_uses_user" name="max_uses_user" placeholder="Type here" class="form-control ">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional fields -->
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <label class="form-label">Min amount</label>
                                    <div class="input-container">
                                        <input type="number" id="min_amount" name="min_amount" placeholder="min" class="form-control ">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <label class="form-label">Status</label>
                                    <select type="text" id="status" name="status" required class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <label class="form-label">Type</label>
                                    <select class="form-select" id="type" name="type">
                                        <option value="percent">Percent</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Discount amount</label>
                            <div class="input-container">
                                <input type="number" id="discount_amount" name="discount_amount" placeholder="Discount" class="form-control ">
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card end// -->
            </div>
        </form>
    </div>
</section>
@endsection
@endsection

@section('customJs')

<script>







    document.getElementById("showAlertButton").addEventListener("click", function() {
        let timerInterval
        Swal.fire({
            title: '<span style="color: green;">Waiting...!</span>'
            , html: 'Creating new Coupon.'
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




    $("#couponForm").submit(function(event){
    event.preventDefault();

    $.ajax ({
          url :'{{ route("coupon_create") }}',
          type : 'post',
          data : $(this).serializeArray(),
          dataType : 'json' ,
          success : function (response){
          var errors = response.errors;

        if (response.status==false)
        {
            if(errors.code)
          {

                $("#code").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.code);
          } else {
                $("#code").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('');
          }
            if(errors.name)
          {

                $("#name").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.name);
          } else {
                $("#name").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('');
          }

          if(errors.max_uses)
          {

                $("#max_uses").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.max_uses);
          } else {
                $("#max_uses").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('');
          }


          if(errors.max_uses_user)
          {

                $("#max_uses_user").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.max_uses_user);
          } else {
                $("#max_uses_user").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('');
          }
// Inside the success callback after checking response.status == false
if (errors.segment) {
    $("#segment").addClass('is-invalid')
        .siblings('p')
        .addClass('invalid-feedback')
        .html(errors.segment);
} else {
    $("#segment").removeClass('is-invalid')
        .siblings('p')
        .removeClass('invalid-feedback')
        .html('');
}

if (errors.points) {
    $("#points").addClass('is-invalid')
        .siblings('p')
        .addClass('invalid-feedback')
        .html(errors.points);
} else {
    $("#points").removeClass('is-invalid')
        .siblings('p')
        .removeClass('invalid-feedback')
        .html('');
}


          if(errors.discount_amount)
          {

                $("#discount_amount").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.discount_amount);
          } else {
                $("#discount_amount").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('');
          }

          if(errors.min_amount)
          {

                $("#min_amount").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.min_amount);
          } else {
                $("#min_amount").removeClass('is-invalid')
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

          if(errors.expires_at)
          {

                $("#expires_at").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.expires_at);
          } else {
                $("#expires_at").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('');
          }
        }
       else {
           window.location.href="{{ url('coupon_list') }}" ;
             }

        }
    })
    });




    function toggleBrandInput() {
        var brandInputContainer = document.getElementById("brand_input_container");
        var hasBrandCheckbox = document.getElementById("has_brand");
        var brandSelect = document.getElementById("brand");

        if (hasBrandCheckbox.checked) {
            brandInputContainer.style.display = "inline-flex";
        } else {
            brandInputContainer.style.display = "none";
            // Set the value of the brand select to null and disable it
            brandSelect.value = "";
            brandSelect.disabled = true;
        }
    }

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

