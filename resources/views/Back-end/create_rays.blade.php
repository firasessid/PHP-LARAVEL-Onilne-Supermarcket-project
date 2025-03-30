@section('content')
@extends('layouts.back-main')

@section('main-container')

<style>

.input-container {
        position: relative;
    }

    .is-invalid {
        border: 1px solid red; /* Red border */
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

    input.error, select.error {
        border: 1px solid red;
    }
</style>

<section class="content-main">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row">
<script>
    @if ($errors->any())


    Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Something went wrong!',
  footer: '<a href="">Why do I have this issue?</a>'
})
    @endif
</script>
                <form action="{{ route('store4') }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                   <div class="col-9">
                        <div class="content-header">
                            <h2 class="content-title">Add New Ray</h2>
                            <div>
                                <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Cancel</button>
                                <button id="showAlertButton" type="submit" class="btn btn-md rounded font-sm hover-up">Create</button>
                            </div>

                        </div>

                        </div>

                        <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Basic</h4>

                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="mb-4">
                                        <label for="name" class="form-label">Ray name</label>
                                        <div class="input-container">
                                            <input type="text" id="name" name="name" placeholder="Ray Name" class="form-control @error('name') is-invalid @enderror">
                                            @error('name')
                                             <i class="fas fa-exclamation-circle"></i>
                                             <div class="error-message">{{ $message }}</div>

                                             @enderror
                                        </div>                                     </div>

                                    <div class="row">
                                            <div class="mb-4">
                                                <label  for="slug" class="form-label">slug</label>
                                                <div class="row gx-2">
                                                <div class="input-container">
                                            <input readonly type="text" id="slug" name="slug" placeholder="Ray Slug" class="form-control @error('slug') is-invalid @enderror">
                                            @error('slug')
                                             <i class="fas fa-exclamation-circle"></i>
                                             <div class="error-message">{{ $message }}</div>

                                             @enderror
                                        </div>                                            </div>


                                 <div class="card-body">
                                     <div class="input-upload">
                                        <img for="image" src="assets/imgs/theme/upload.svg" alt="" />
                                        <div class="input-container">
                                         <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                          @error('image')
                                          <i class="fas fa-exclamation-circle"></i>
                                          @enderror
    </div>                                     </div>                                     </div>
                                 </div>
                                 <div class="col-lg-12">
                                            <label for="status" class="form-label">Status</label>
                                            <select  type="text" id="status" name="status" required class="form-select">
                                                <option value="1" >Active</option>
                                                <option value="0" >Inactive</option>

                                            </select>
                                        </div>

                                </div>

                                </form>
                            </div>
                        </div>
                        <!-- card end// -->

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
    title: '<span style="color: green;">Waiting...!</span>',
  html: 'Creating new Ray.',
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










$("#name").change(function(){
    element = $(this);

    $.ajax ({
    url :'{{ route("getSlug") }}',
      type : 'get',
      data : { title : element.val()},
      dataType : 'json' ,
      success : function (response){
    if (response ["status"] == true){
        $("#slug").val(response["slug"]);
                                    }
    }
    });

      });


</script>
@endsection

