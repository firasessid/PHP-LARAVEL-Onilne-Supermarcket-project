





@section('content')

@extends('layouts.main')
@section('main-container')
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Cart
            </div>
        </div>
    </div>
    <div class="container mb-80 mt-50">
        <div class="row">
            <div class="col-lg-8 mb-40">
                <h1 class="heading-2 mb-10">Your Cart</h1>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body">There are <span class="text-brand"></span> products in your cart</h6>
                </div>
<br><br>
                <div class="card">
                    <div class="title">
                        @php $total = 0 @endphp
                            @if(session('cart'))
                            @foreach(session('cart') as $id => $details)
                            @php $total += $details['sale_price'] * $details['quantity'] @endphp
                            @endforeach
                            @endif
                        <span>
                            <svg width="20" fill="currentColor" height="20" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1362 1185q0 153-99.5 263.5t-258.5 136.5v175q0 14-9 23t-23 9h-135q-13 0-22.5-9.5t-9.5-22.5v-175q-66-9-127.5-31t-101.5-44.5-74-48-46.5-37.5-17.5-18q-17-21-2-41l103-135q7-10 23-12 15-2 24 9l2 2q113 99 243 125 37 8 74 8 81 0 142.5-43t61.5-122q0-28-15-53t-33.5-42-58.5-37.5-66-32-80-32.5q-39-16-61.5-25t-61.5-26.5-62.5-31-56.5-35.5-53.5-42.5-43.5-49-35.5-58-21-66.5-8.5-78q0-138 98-242t255-134v-180q0-13 9.5-22.5t22.5-9.5h135q14 0 23 9t9 23v176q57 6 110.5 23t87 33.5 63.5 37.5 39 29 15 14q17 18 5 38l-81 146q-8 15-23 16-14 3-27-7-3-3-14.5-12t-39-26.5-58.5-32-74.5-26-85.5-11.5q-95 0-155 43t-60 111q0 26 8.5 48t29.5 41.5 39.5 33 56 31 60.5 27 70 27.5q53 20 81 31.5t76 35 75.5 42.5 62 50 53 63.5 31.5 76.5 13 94z">
                                </path>
                            </svg>
                        </span>
                        <p class="title-text">
                            Total amount
                        </p>

                    </div>
                    <div class="data">
                        <p>
                           €{{$total}}
                        </p>


                        <div class="range">
                            <div class="fill">
                            </div>
                        </div>
                        <br>
                        <a href="{{ route('checkout') }}" class="btn mb-20 w-100">Proceed To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>
                         <br>

                    </div>

                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-8">

                <div class="table-responsive shopping-summery">
                    <table id="cart" class="table table-wishlist">
                        <thead>
                            <tr class="main-heading">
                                <th class="custome-checkbox start pl-30">

                                </th>
                                <th scope="col" colspan="2" style="padding-left: 30px;">Product</th>
                                <th scope="col"> Price</th>
                                <th scope="col" style="padding-left: 80px;">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Remove</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0 @endphp
                            @if(session('cart'))
                            @foreach(session('cart') as $id => $details)
                            @php $total += $details['sale_price'] * $details['quantity'] @endphp
                            <tr data-id="{{ $id }}" class="pt-30">

                                <td class="custome-checkbox pl-30">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                </td>

                                <td data-th="Product" class="shopping-cart-img">
                                    <a href="shop-product-right.html"><img alt="Nest" src="{{ asset('storage/images/' . $details['image']) }}" alt="{{ $details['name'] }}" /></a>
                                </td>

                                <td data-th="Product" class="product-des product-name">
                                    <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">{{ $details['name'] }}</a></h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width:90%">
                                            </div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                </td>
                                <td data-th="Price" class="price" data-title="Price" data-item-price="€{{ $details['sale_price'] }}">
                                    <h4 class="text-body">€{{ $details['sale_price'] }} </h4>
                                </td>
                                <!-- In your HTML file -->
                                <td data-th="Quantity" class="text-center detail-info" data-title="Stock">
                                    <div class="detail-extralink mr-15">
                                        <div>

                                            <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity cart_update small-input" min="1" />
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Subtotal" class="text-center">€{{ $details['sale_price'] * $details['quantity'] }}</td>
                                <td class="action text-center" data-th="">
                                    <a href="#" class="cart_remove">
                                        <i class="fi-rs-trash delete-icon"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif

                        </tbody>

                    </table>
                </div>

            </div>







            @php $total = 0 @endphp
            @foreach((array) session('cart') as $id => $details)
            @php $total += $details['sale_price'] * $details['quantity'] @endphp
            @endforeach




        </div>

    </div>

    </div>
    </div>
    </div>
    </div>
</main>









    <style>
.card {
  padding: 1rem;
  background-color: #fff;
  max-width: 320px;
  border-radius: 20px;
}

.title {
  display: flex;
  align-items: center;
}

.title span {
  position: relative;
  padding: 0.5rem;
  background-color: #10B981;
  width: 1.5rem;
  height: 1.5rem;
  border-radius: 9999px;
}

.title span svg {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: #ffffff;
  height: 1rem;
}

.title-text {
  margin-left: 0.5rem;
  color: #374151;
  font-size: 18px;
}

.percent {
  margin-left: 0.5rem;
  color: #02972f;
  font-weight: 600;
  display: flex;
}

.data {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
}

.data p {
  margin-top: 1rem;
  margin-bottom: 1rem;
  color: #1F2937;
  font-size: 2.25rem;
  line-height: 2.5rem;
  font-weight: 700;
  text-align: left;
}

.data .range {
  position: relative;
  background-color: #E5E7EB;
  width: 100%;
  height: 0.5rem;
  border-radius: 0.25rem;
}

.data .range .fill {
  position: absolute;
  top: 0;
  left: 0;
  background-color: #10B981;
  width: 76%;
  height: 100%;
  border-radius: 0.25rem;
}
.small-input {
    font-size: 16px;
    width: 70px;
    height: 60px;
    /* You can add more styles as needed */
}
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>










    <script type="text/javascript">











$(".cart_update").change(function (e) {
    e.preventDefault();

    var ele = $(this);

    $.ajax({
        url: '{{ route('update_cart') }}',
        method: "patch",
        data: {
            _token: '{{ csrf_token() }}',
            id: ele.parents("tr").attr("data-id"),
            quantity: ele.parents("tr").find(".quantity").val()
        },
        success: function (response) {
           window.location.reload();
        }
    });
});

 $(".cart_remove").click(function (e) {
    e.preventDefault();
    var ele = $(this);
    if(confirm("Do you really want to remove?")) {
        $.ajax({
            url: '{{ route('remove_from_cart') }}',
            method: "DELETE",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id")
            },
            success: function (response) {
                window.location.reload();
            }
        });
    }
});

    </script>
    @endsection

