
@section('content')
@extends('layouts.back-main')
@section('main-container')

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
    

<style>
    .button-container {
    display: flex;
    align-items: center; /* Center vertically */
}

.button-container form {
    margin-right: -2px; /* Adjust as needed */
}
</style>    
    <div class="col-9">
        <div class="content-header">
        <h2 class="content-title">Product request for Supernet {{ $product->userName }}</h2>
        @if(auth()->user()->hasRole('admin'))
            <div class="button-container">
                <form method="POST" action="{{ route('admin.products.reject', $product) }}">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Reject</button>
                </form>
    
                <form method="POST" action="{{ route('admin.products.approve', $product) }}">
                    @csrf
                    @method('PATCH')
                    <button id="showAlertButton" class="btn btn-md rounded font-sm hover-up show_alert">Accept</button>
                </form>
            </div>
            @else
            @endif
        </div>
    </div>
       
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Basic</h4>
                    </div>










                    <div class="card-body">
                        <div class="mb-4">
                            <label for="name" class="form-label">Product name</label>
                            <div class="input-container">
                                <input readonly type="text" id="name"  name="name" placeholder="Category Name" value="{{ $product->name }}" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <i class="fas fa-exclamation-circle"></i>
                                <div class="error-message">{{ $message }}</div>

                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Full description</label>

                            <div class="input-container">
                                <textarea  readonly name="description" placeholder="Type here" class="form-control @error('description') is-invalid @enderror" rows="4">{{ $product->description }}</textarea>
                                @error('description')
                                <i class="fas fa-exclamation-circle"></i>
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="form-label">slug</label>

                            <input readonly value="{{ $product->slug }}" type="text" id="slug" name="slug" placeholder="Category Slug" class="form-control @error('slug') is-invalid @enderror">
                            @error('slug')
                            <i class="fas fa-exclamation-circle"></i>
                            <div class="error-message">{{ $message }}</div>

                            @enderror




                        </div>
                        <div class="row">
                            <div class="mb-4">
                                <label for="short_description" class="form-label">Short description</label>
                                <div class="input-container">
                                    <input readonly type="text" value="{{ $product->short_description }}" id="short_description" name="short_description" placeholder="Type here" class="form-control @error('short_description') is-invalid @enderror">
                                    @error('short_description')
                                    <i class="fas fa-exclamation-circle"></i>
                                    <div class="error-message">{{ $message }}</div>

                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <div class="row gx-2">
                                        <div class="input-container">
                                            <input readonly value="{{ $product->quantity }}" type="text" id="quantity" name="quantity" placeholder="?" class="form-control @error('quantity') is-invalid @enderror">
                                            @error('quantity')
                                            <i class="fas fa-exclamation-circle"></i>
                                            <div class="error-message">{{ $message }}</div>

                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label  for="is_featured" class="form-label">Featured</label>
                                <select disabled class="form-select" id="is_featured" value="{{ $product->is_featured }}" name="is_featured">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label  for="status" class="form-label">Status</label>
                                <select disabled type="text" id="status" value="{{ $product->status }}" name="status" required class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>

                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="sku" class="form-label">SKU</label>
                            <div class="input-container">
                                <input readonly type="text" id="sku" value="{{ $product->sku }}" name="sku" placeholder="sku" class="form-control @error('sku') is-invalid @enderror">
                                @error('sku')
                                <i class="fas fa-exclamation-circle"></i>
                                <div class="error-message">{{ $message }}</div>

                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
                <!-- card end// -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Prices</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="sale_price" class="form-label">Sale Price</label>
                                    <div class="input-container">
                                        <input readonly type="text" id="sale_price" value="{{ $product->sale_price }}" name="sale_price" placeholder="$US" class="form-control @error('sale_price') is-invalid @enderror">
                                        @error('sale_price')
                                        <i class="fas fa-exclamation-circle"></i>
                                        <div class="error-message">{{ $message }}</div>

                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="regular_price" class="form-label">Regular Price</label>
                                    <div class="input-container">
                                        <input readonly value="{{ $product->regular_price }}" type="text" id="regular_price" name="regular_price" placeholder="$US" class="form-control @error('regular_price') is-invalid @enderror">
                                        @error('regular_price')
                                        <i class="fas fa-exclamation-circle"></i>
                                        <div class="error-message">{{ $message }}</div>

                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card end// -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Organization</h4>
                    </div>
                    <div class="card-body">

                        <div class="card-body">
                            <div class="row gx-2">
                                <div class="mb-4">
                                    <label for="rays" class="form-label">Rays</label>
                                    <div class="input-container">
                                        <select disabled class="form-select" id="rays" name="rays">
                                            @if ($data['rays']->isNotEmpty())
                                                <option value="">Select Ray</option>
                                                @foreach ($data['rays'] as $ray)
                                                    <option value="{{ $ray->id }}" {{ $ray->id == $product->ray_id ? 'selected' : '' }}>{{ $ray->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select disabled class="form-select" id="category" name="category">
                                        <option value="">Select Category</option>
                                        @foreach ($data['categories'] as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label for="subcategory" class="form-label">Subcategory</label>
                                    <select disabled class="form-select" id="subcategory" name="subcategory">
                                        <option value="">Select Subcategory</option>
                                        @foreach ($data['subcategories'] as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ $subcategory->id == $product->sub_category_id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                            $(document).ready(function () {
                                $('#rays').on('change', function () {
                                    var selectedRayId = $(this).val();
                                    var categorySelect = $('#category');
                                    var subcategorySelect = $('#subcategory');

                                    // Clear existing options in the category and subcategory select boxes
                                    categorySelect.empty().append('<option value="">Select Category</option>');
                                    subcategorySelect.empty().append('<option value="">Select Subcategory</option>');

                                    // Make an AJAX request to get categories based on the selected ray
                                    $.ajax({
                                        url: '/get-categories/' + selectedRayId, // Replace with your route
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function (data) {
                                            $.each(data.categories, function (key, value) {
                                                categorySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                                            });
                                        }
                                    });
                                });

                                $('#category').on('change', function () {
                                    var selectedCategoryId = $(this).val();
                                    var subcategorySelect = $('#subcategory');

                                    // Clear existing options in the subcategory select box
                                    subcategorySelect.empty().append('<option value="">Select Subcategory</option>');

                                    // Make an AJAX request to get subcategories based on the selected category
                                    $.ajax({
                                        url: '/get-subcategories/' + selectedCategoryId, // Replace with your route
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function (data) {
                                            $.each(data.subcategories, function (key, value) {
                                                subcategorySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                                            });
                                        }
                                    });
                                });
                            });
                            </script>

                            <!-- row.// -->
                        </div>
                        <div class="card-body" style="margin-left: 20px;">
                            <div style="display: flex; align-items: center;">
                                <div class="form-check form-switch col-sm-6 mb-3">
                                    <input disabled class="form-check-input" type="checkbox" id="has_brand" name="has_brand" role="switch" id="flexSwitchCheckDefault" onchange="toggleBrandInput()" style="transform: scale(1.2);" @if($product->brand_id) checked @endif>
                                    <label disabled class="form-check-label" for="flexSwitchCheckDefault">Do you need Brand for the product?</label>
                                </div>
                                <div class="col-sm-6 mb-3" id="brand_input_container" @if (!$product->brand_id) style="display: none;" @endif>
                                    <select disabled class="form-select" id="brand" name="brand">
                                        <option value="">Select Brand</option>
                                        @foreach ($data['brands'] as $brand)
                                            <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>
                        </div>

                        <script>
                        function toggleBrandInput() {
var brandInputContainer = document.getElementById("brand_input_container");
var hasBrandCheckbox = document.getElementById("has_brand");
var brandSelect = document.getElementById("brand");

if (hasBrandCheckbox.checked) {
brandInputContainer.style.display = "inline-flex";
brandSelect.disabled = false; // Enable the select field
} else {
brandInputContainer.style.display = "none";
brandSelect.value = ""; // Clear the selected value
brandSelect.disabled = true; // Disable the select field
}
}

                        </script>






                    </div>






                    <div class="card-header">
                        <h4>Media</h4>
                    </div>
                    <div class="card-body">
                        <div class="input-upload">
                            <img src="{{ asset('storage/images/' . $product->image) }}" alt="Product Image" width="200">
                           
                        </div>
                    </div>
                    
                </div>
                <!-- card end// -->
            </div>

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
            , html: 'Accepting product request.'
            , timer: 4000
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




    $("#name").change(function() {
        element = $(this);

        $.ajax({
            url: '{{ route("getSlug") }}'
            , type: 'get'
            , data: {
                title: element.val()
            }
            , dataType: 'json'
            , success: function(response) {
                if (response["status"] == true) {
                    $("#slug").val(response["slug"]);
                }
            }
        });

    });

</script>
@endsection

