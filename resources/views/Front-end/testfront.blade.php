
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
