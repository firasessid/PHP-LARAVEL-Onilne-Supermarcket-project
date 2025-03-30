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
@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong...',
            footer: '<a href="#">Why do I have this issue?</a>'
        });
    </script>
@endif

<form action="{{ isset($category) ? route('category.update', $category->id) : route('store1') }}" 
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($category))
        @method('PUT') <!-- Add PUT method for updates -->
    @endif

    <div class="col-9">
        <div class="content-header">
            <h2 class="content-title">
                {{ isset($category) ? 'Edit Category' : 'Add New Category' }}
            </h2>
            <div>
                <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Cancel</button>
                <button id="showAlertButton" type="submit" class="btn btn-md rounded font-sm hover-up">
                    {{ isset($category) ? 'Update' : 'Create' }}
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Basic</h4>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label for="name" class="form-label">Category title</label>
                    <div class="input-container">
                        <input type="text" id="name" name="name" placeholder="Category Name" 
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ isset($category) ? $category->name : old('name') }}">
                        @error('name')
                            <i class="fas fa-exclamation-circle"></i>
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="slug" class="form-label">Slug</label>
                    <div class="input-container">
                        <input type="text" id="slug" name="slug" placeholder="Category Slug" 
                               class="form-control @error('slug') is-invalid @enderror"
                               value="{{ isset($category) ? $category->slug : old('slug') }}">
                        @error('slug')
                            <i class="fas fa-exclamation-circle"></i>
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="input-upload mb-4">
                   
                    @if(isset($category) && $category->image)
                        <img src="{{ asset('storage/images/' . $category->image) }}" width="100" alt="Category Image">
                    @endif
                    <img for="image" src="assets/imgs/theme/upload.svg" alt="" />

                    <div class="input-container">
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <i class="fas fa-exclamation-circle"></i>
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <div class="input-container">
                            <select id="status" name="status" class="form-select">
                                <option value="1" {{ (isset($category) && $category->status == '1') ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ (isset($category) && $category->status == '0') ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                <div class="mb-4">
                        <label for="rays" class="form-label">Ray</label>
                        <div class="input-container">
                            <select class="form-select" id="rays" name="rays">
                                @foreach ($rays as $ray)
                                    <option value="{{ $ray->id }}" 
                                        {{ (isset($category) && $category->ray_id == $ray->id) ? 'selected' : '' }}>
                                        {{ $ray->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

            </div>
        </div>
    </div>

 
</form>
</div>
</section>

@endsection

@section('customJs')
<script>
document.getElementById("showAlertButton").addEventListener("click", function() {
    let timerInterval;
    Swal.fire({
        title: '<span style="color: green;">Processing...</span>',
        html: 'Please wait while we save your changes.',
        timer: 4000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    });
});

$("#name").change(function() {
    $.ajax({
        url: '{{ route("getSlug") }}',
        type: 'get',
        data: { title: $(this).val() },
        dataType: 'json',
        success: function(response) {
            if (response["status"] == true) {
                $("#slug").val(response["slug"]);
            }
        }
    });
});
</script>
@endsection
