
@section('content')

@extends('layouts.main')
@section('main-container')

<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Checkout
            </div>
        </div>
    </div>
    <div class="container mb-80 mt-50">
        <div class="row">
            <div class="col-lg-8 mb-40">
                <h1 class="heading-2 mb-10">Checkout</h1>
                <div class="d-flex justify-content-between">
                </div>
            </div>
        </div>
        <form id="orderForm" name="orderForm" action="/session" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">


            <div class="col-lg-7">
                <div class="row mb-50 "> <!-- Add the mt-3 class to add some margin to the top -->
                    <div class="col-lg-6 mb-sm-15 mb-lg-0 mb-md-3">
                        <p class="mb-30"><span class="font-lg text-muted">Using A Promo Code?</p>
                            <form method="post" class="apply-coupon">
                                <div class="d-flex justify-content-between">
                                <input class="font-medium mr-15 coupon"  id="discount_code" placeholder="Enter Your Coupon">
                                <button class="btn btn-md" type="button" id="apply-discount"><i class="fi-rs-label mr-10"></i>Apply</button>
                                </div>
                            </form>
<br>
<div class="in mt-1" style="display: none;"> <!-- Add the mt-3 class here to add margin to the top -->
    <div class="in__icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none">
            <path fill="#393a37" d="m12 1.5c-5.79844 0-10.5 4.70156-10.5 10.5 0 5.7984 4.70156 10.5 10.5 10.5 5.7984 0 10.5-4.7016 10.5-10.5 0-5.79844-4.7016-10.5-10.5-10.5zm.75 15.5625c0 .1031-.0844.1875-.1875.1875h-1.125c-.1031 0-.1875-.0844-.1875-.1875v-6.375c0-.1031.0844-.1875.1875-.1875h1.125c.1031 0 .1875.0844.1875.1875zm-.75-8.0625c-.2944-.00601-.5747-.12718-.7808-.3375-.206-.21032-.3215-.49305-.3215-.7875s.1155-.57718.3215-.7875c.2061-.21032.4864-.33149.7808-.3375.2944.00601.5747.12718.7808.3375.206.21032.3215.49305.3215.7875s-.1155.57718-.3215.7875c-.2061.21032-.4864.33149-.7808.3375z"></path>
        </svg>
    </div>
    <div class="in__title"><strong> </strong></div>
    <div class="in__close">
        <svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
            <path d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z" fill="#393a37"></path>
        </svg>
    </div>
</div>



                        @if(session::has('code'))

                        <div class="info mt-1" id="discount-response"> <!-- Add the mt-3 class here to add margin to the top -->
                            <div class="info__icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none"><path fill="#393a37" d="m12 1.5c-5.79844 0-10.5 4.70156-10.5 10.5 0 5.7984 4.70156 10.5 10.5 10.5 5.7984 0 10.5-4.7016 10.5-10.5 0-5.79844-4.7016-10.5-10.5-10.5zm.75 15.5625c0 .1031-.0844.1875-.1875.1875h-1.125c-.1031 0-.1875-.0844-.1875-.1875v-6.375c0-.1031.0844-.1875.1875-.1875h1.125c.1031 0 .1875.0844.1875.1875zm-.75-8.0625c-.2944-.00601-.5747-.12718-.7808-.3375-.206-.21032-.3215-.49305-.3215-.7875s.1155-.57718.3215-.7875c.2061-.21032.4864-.33149.7808-.3375.2944.00601.5747.12718.7808.3375.206.21032.3215.49305.3215.7875s-.1155.57718-.3215.7875c-.2061.21032-.4864.33149-.7808.3375z"></path></svg>
                            </div>
                            <div class="info__title" ><strong> Your Coupon code : {{ Session::get('code')->code }}</strong>
                            </div>
                            <div  id="remove-discount" class="info__close"><svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z" fill="#393a37"></path></svg></div>
                        </div>
                        @endif
                    </div>

                </div>


                    <div class="row mb-50">

                        <div class="row">
                            <div class="heading_s1">
                                            <h4 class="mb-30">Shipping informations</h4>
                                            <p class="mb-30">Please inter your INFO</p>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <input type="text" name="adresse" id="adresse" placeholder="Adresse*" class="form-control " value="{{ (!empty($customerAddress)) ? $customerAddress->adresse :'' }}" />
                                                <p></p>

                                            </div>
                                            <div class="form-group col-lg-6">
                                                <input type="text" name="adresse2" id="adresse2" placeholder="Adresse line 2*" class="form-control " value="{{ (!empty($customerAddress)) ? $customerAddress->adresse2 :'' }}" />
                                                <p></p>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <input type="text" name="phone" id="phone" placeholder="Phone number*" class="form-control " value="{{ (!empty($customerAddress)) ? $customerAddress->phone :'' }}" />
                                                <p></p>

                                            </div>
                                            <div class="form-group col-lg-6">
                                                <input type="text" name="zip" id="zip" placeholder="Postcode/ZIP* " class="form-control " value="{{ (!empty($customerAddress)) ? $customerAddress->zip :'' }}" />
                                                <p></p>
                                            </div>

                                        </div>

                                       


                                <style>


.in {
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  width: 320px;
  padding: 12px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: start;
  background: #f04d41;
  border-radius: 8px;
  box-shadow: 0px 0px 5px -3px #111;
}

.in__icon {
  width: 20px;
  height: 20px;
  transform: translateY(-2px);
  margin-right: 8px;
}

.in__icon path {
  fill: #fff;
}

.in__title {
  font-weight: 500;
  font-size: 14px;
  color: #fff;
}

.in__close {
  width: 20px;
  height: 20px;
  cursor: pointer;
  margin-left: auto;
}

.in__close path {
  fill: #fff;
}





.info {
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  width: 320px;
  padding: 12px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: start;
  background: #3BB77E;
  border-radius: 8px;
  box-shadow: 0px 0px 5px -3px #111;
}

.info__icon {
  width: 20px;
  height: 20px;
  transform: translateY(-2px);
  margin-right: 8px;
}

.info__icon path {
  fill: #fff;
}

.info__title {
  font-weight: 500;
  font-size: 14px;
  color: #fff;
}

.info__close {
  width: 20px;
  height: 20px;
  cursor: pointer;
  margin-left: auto;
}

.info__close path {
  fill: #fff;
}









.cbx {
  display: inline-block;
  vertical-align: middle;
  position: relative;
  padding-left: 35px; /* Add padding for the check icon */
  cursor: pointer;
}

.cbx:before {
  content: "";
  position: absolute;
  left: 0;
  top: 50%; /* Vertically center the checkbox */
  transform: translateY(-40%); /* Offset the checkbox to center it */
  width: 27px;
  height: 27px;
  border: 1px solid #c8ccd4;
  border-radius: 3px;
  transition: background 0.1s ease;
  background-color: #fff; /* Default background color */
}

.cbx:after {
  content: "\2713"; /* Unicode checkmark character */
  font-size: 18px;
  color: transparent; /* Make it transparent by default */
  position: absolute;
  left: 7px;
  top: 50%; /* Vertically center the checkmark icon */
  transform: translateY(-50%); /* Offset the icon to center it */
  opacity: 0;
  transition: all 0.3s ease;
}

.lbl {
  display: inline-block;
  vertical-align: middle;
  cursor: pointer;
  margin-left: 3px; /* Add margin to move the label down */
}

#cbx-card:checked ~ .cbx:before,
#cbx-cod:checked ~ .cbx:before {
  border-color: transparent;
  background: #3BB77E;
  animation: jelly 0.6s ease;
}

#cbx-card:checked ~ .cbx:after,
#cbx-cod:checked ~ .cbx:after {
  color: #fff; /* Change the color to white when checked */
  opacity: 1;
}

.cntr {
  margin-bottom: 10px; /* Add some spacing between the checkboxes */
}

@keyframes jelly {
  /* ... (your existing keyframes) ... */
}

.hidden-xs-up {
  display: none !important;
}
                                  </style>
<br>

<br>


<div class="row">
    <div class="form-group col-lg-9">
        <br>
        <br>
        <p class="mb-30">Select your payment method :  </p>

        <div class="cntr">
            <input type="checkbox" id="cbx-card" name="payment_method" value="card" class="hidden-xs-up">
            <label for="cbx-card" class="cbx"></label>
            <span class="lbl">Stipe payment</span>
          </div>

          <div class="cntr">
            <input type="checkbox" id="cbx-cod" name="payment_method" value="cod" class="hidden-xs-up">
            <label for="cbx-cod" class="cbx"></label>
            <span class="lbl">Cash on Delivery</span>
          </div>


          <div class="cntr">
            <input type="checkbox" id="cbx-card" name="payment_method" value="paypal" class="hidden-xs-up">
            <label for="cbx-card" class="cbx"></label>
            <span class="lbl">Paypal payment</span>
          </div>

<br>
    </div>

</div>



                                  <script>
                                    const checkboxes = document.querySelectorAll('input[name="payment_method"]');

                                    checkboxes.forEach(checkbox => {
                                      checkbox.addEventListener('click', () => {
                                        // Uncheck all checkboxes
                                        checkboxes.forEach(cb => {
                                          if (cb !== checkbox) {
                                            cb.checked = false;
                                          }
                                        });
                                      });
                                    });
                                  </script>


<div class="row">
    <div class="form-group col-lg-6">
        <button class="btn btn-success" type="button" id="pay-and-save-button"><i class="fa fa-money"></i>Apply your order </button>

    </div>

</div>

                            </div>

                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<script>

$(document).ready(function () {
    $('#payment_card').change(function () {
        // Toggle the 'required' attribute for address fields based on the selected payment method
        $('#adresse, #adresse2, #phone, #zip').prop('required', this.checked);
    });

    $('#pay-and-save-button').click(function () {

        var selectedPaymentMethod = $('input[name="payment_method"]:checked').val();
        if (selectedPaymentMethod === 'cod') {
            // Handle saving data to the database for Cash on Delivery
            saveDataToDatabase();
        } else if (selectedPaymentMethod === 'card') {
            // Check if the address fields are valid
            if ($('#adresse').val() === '' || $('#adresse2').val() === '' || $('#phone').val() === '' || $('#zip').val() === '') {
                // Address fields are empty, display error messages
                if ($('#adresse').val() === '') {
                    $("#adresse").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html('The adresse field is required.');
                } else {
                    $("#adresse").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }

                if ($('#adresse2').val() === '') {
                    $("#adresse2").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html('The adresse2 field is required.');
                } else {
                    $("#adresse2").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }

                if ($('#phone').val() === '') {
                    $("#phone").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html('The phone field is required.');
                } else {
                    $("#phone").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }

                if ($('#zip').val() === '') {
                    $("#zip").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html('The zip field is required.');
                } else {
                    $("#zip").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }
            } else {
                // Address fields are valid, submit the form to initiate the Stripe payment
                $('#orderForm').submit();

            }
        }
    });

    function saveDataToDatabase() {
            $.ajax({
                url: '{{ route("front.processCheckout") }}',
                type: 'post',
                data: $('#orderForm').serializeArray(),
                dataType: 'json',
                success: function (response) {
                    var errors = response.errors;



if (response.status == false) {
    if (response.status==false)
{
if(errors.adresse)
{

    $("#adresse").addClass('is-invalid')
    .siblings('p')
    .addClass('invalid-feedback')
    .html(errors.adresse);
} else {
    $("#adresse").removeClass('is-invalid')
    .siblings('p')
    .removeClass('invalid-feedback')
    .html('');
}

if(errors.adresse2)
{

    $("#adresse2").addClass('is-invalid')
    .siblings('p')
    .addClass('invalid-feedback')
    .html(errors.adresse2);
} else {
    $("#adresse2").removeClass('is-invalid')
    .siblings('p')
    .removeClass('invalid-feedback')
    .html('');
}


if(errors.phone)
{

    $("#phone").addClass('is-invalid')
    .siblings('p')
    .addClass('invalid-feedback')
    .html(errors.phone);
} else {
    $("#phone").removeClass('is-invalid')
    .siblings('p')
    .removeClass('invalid-feedback')
    .html('');
}



if(errors.zip)
{

    $("#zip").addClass('is-invalid')
    .siblings('p')
    .addClass('invalid-feedback')
    .html(errors.zip);
} else {
    $("#zip").removeClass('is-invalid')
    .siblings('p')
    .removeClass('invalid-feedback')
    .html('');
}


if(errors.country)
{

    $("#country").addClass('is-invalid')
    .siblings('p')
    .addClass('invalid-feedback')
    .html(errors.country);
} else {
    $("#country").removeClass('is-invalid')
    .siblings('p')
    .removeClass('invalid-feedback')
    .html('');
}

}



                        // Handle errors if needed
                    } else {
                        // Redirect to a success page or perform other actions
                        window.location.href = "{{ url('/thanks/') }}/" + response.orderId;
                    }
                }
            });
        }
    });
</script>




                    </div>

            </div>
        </form>



            <div class="col-lg-5">
                <div class="border p-40 cart-totals ml-30 mb-50">
                    @php $total = 0 @endphp
                    @foreach((array) session('cart') as $id => $details)
                    @php $total += $details['sale_price'] * $details['quantity'] @endphp
                    @endforeach



                    <div class="d-flex align-items-end justify-content-between mb-30">
                    </div>

                        <div class="field_form shipping_calculator">
                            <h4 class="mb-10">Calculate Shipping</h4>
                            <p class="mb-30"><span class="font-lg text-muted">Select a </span><strong class="text-brand">City</strong></p>

                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <div class="custom_select">
                                        <select name="country" id="country" class="form-control select-active w-100">
                                            <option value="">Select a cityy</option>
                                            @foreach ($firas as $c)
                                            <option {{ (!empty($customerAddress) && $customerAddress->country_id == $c->id) ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                        <p></p>

                                    </div>
                                </div>
                            </div>

                        </div>

                    <table class="table no-border">

                        <tbody>
                            @php $total = 0 @endphp
                            @if(session('cart'))
                            @foreach(session('cart') as $id => $details)
                            @php $total += $details['sale_price'] * $details['quantity'] @endphp

                            <tr>
                                <td class="image product-thumbnail"><img src="{{ asset('storage/images/' . $details['image']) }}" alt="{{ $details['name'] }}" alt="#"></td>
                                <td>
                                    <h6 class="w-160 mb-5"><a href="shop-product-full.html" class="text-heading">{{ $details['name'] }}</a></h6></span>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width:90%">
                                            </div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="text-muted pl-20 pr-20">x {{ $details['quantity'] }}</h6>
                                </td>
                                <td>
                                    <h4 class="text-brand">€{{ $details['sale_price'] * $details['quantity'] }}</h4>
                                </td>
                            </tr>

                            @endforeach
                            @endif

                        </tbody>
                    </table>
                    <table>
                        <tbody>
                            <tr>
                                <td class="price" data-title="Price">
                                    <h6 class="text-body">Subtotal</h6>
                                </td>
                                <td class="price" data-title="Price">
                                    <h5 class="text-brand">€{{$total }}</h5>
                                </td>
                            </tr>
                            <tr>
                                <td class="price" data-title="Price">
                                    <h6 class="text-body">Discount</h6>
                                </td>
                                <td  id="discount_value" class="price" data-title="Price">
                                    <h5 class="text-brand"></h5>
                                </td>
                            </tr>
                            <tr>
                                <td class="price" data-title="Price">
                                    <h6 class="text-body">Shipping fee</h6>
                                </td>
                                <td id="shippingAmount" class="price" data-title="Price">
                                    <h5 class="text-brand"></h5>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="price" data-title="Price">
                                    <h6 class="text-body">Total amount</h6>
                                </th>
                                <th id="grandTotal" class="price green-bg" data-title="Price">
                                    <h5 class="text-brand">€{{$total }}</h5>
                                </th>
                            </tr>
                        </tfoot>
                    </table>



                </div>

            </div>
        </div>
    </form>

    </div>
</main>



<script>
// Function to update the order summary table
function updateOrderSummary(subtotal, discount, shippingCharge, grandTotal) {
    // Update Subtotal
    $("#subtotal h5.text-brand").text('€' + subtotal);

    // Update Discount
    $("#discount_value h5.text-brand").text('€' + discount);

    // Update Shipping fee
    $("#shippingAmount h5.text-brand").text('€' + shippingCharge);

    // Update Total amount
    $("#grandTotal h5.text-brand").text('€' + grandTotal);
}

// Function to fetch and update order details
function updateOrderDetails() {
    var selectedCountryId = $("#country").val();

    $.ajax({
        url: '{{ route("getOrder") }}',
        method: 'POST',
        data: { country_id: selectedCountryId },
        dataType: 'json',
        success: function (data) {
            if (data.status) {
                // Call the function to update the order summary table with the received data
                updateOrderSummary(data.subtotal, data.discount, data.shippingCharge, data.grandTotal);
            }
        }
    });
}

$(document).ready(function () {

    // Initialize the order summary table with the correct initial values
    updateOrderSummary('{{ $total }}', '€0', '€0', '{{ $total }}');
    // Initialize order details when the page loads
    updateOrderDetails();

    $("#country").change(function () {

        // Update order details when the country is changed
        updateOrderDetails();
    });
});

$("#apply-discount").click(function () {
    $.ajax({
        url: '{{ route("applyDiscount") }}',
        type: 'post',
        data: { code: $("#discount_code").val() },
        dataType: 'json',
        success: function (response) {
            if (response.status == true) {
                discount = response.discount; // Update the discount variable
                // Update the UI to reflect the discount
                $("#discount_value h5.text-brand").text('€' + discount);
                // Call the function to update the coupon code display
                // Reload the page
                window.location.href = "{{ url('/checkout') }}";
            } else {
                // Show an error message if the discount is invalid
                // Display response.message in the specified div and show it
                $(".in__title strong").text(response.message);
                $(".in").show();
            }
        }
    });
});

$("#remove-discount").click(function () {
    $.ajax({
        url: '{{ route("removeDiscount") }}',
        type: 'post',
        data: { country_id: $("#country").val() },
        dataType: 'json',
        success: function (data) {

                window.location.href="{{ url('/checkout') }}" ;

        }
    });
});



$(document).ready(function () {
    $("#country").change(function () {
        var selectedCountryId = $(this).val();

        $.ajax({
            url: '{{ route("getOrder") }}', // Changed to route("getOrder")
            method: 'POST',
            data: { country_id: selectedCountryId },
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    // Update the shipping fee amount
                    $("#shippingAmount h5.text-brand").text('€' + data.shippingCharge);
                    // Update the grand total amount
                    $("#grandTotal h5.text-brand").text('€' + data.grandTotal);
                }
            }
        });
    });
});
















</script>

@endsection





















