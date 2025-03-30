@section('content')
@extends('layouts.back-main')
@section('main-container')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Order :#{{ $order->id }}</h2>
            <p></p>
        </div>
    </div>
    <form action="{{ route('updateOrder', ['orderId' => $order->id]) }}" method="post" name="changeOrderForm" id="changeOrderForm">
        @csrf
    <div class="card">
      
    <header class="card-header">
    <div class="row align-items-center">
        <div class="row align-items-center">
            @if(Auth::user()->hasRole('client'))
                <!-- For clients, show an empty card or message -->
                <div class="col-md-12 col-12">
                <span><b>{{ $order->created_at }} PM</b> </span> <br />
                </div>
            @else
                <!-- For admins, show the order details form -->
                <div class="col-md-2 col-6">
                    <span><b>{{ $order->created_at }} PM</b> </span> <br />
                </div>

                <div class="col-md-2 col-6">
                    <div class="custom_select">
                        <select name="status" id="status" class="form-select d-inline-block mb-lg-0 mr-5 mw-200">
                            <option value="pending" {{ ($order->status == 'pending') ? 'selected' : '' }}>Pending</option>
                            <option value="shipped" {{ ($order->status == 'shipped') ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ ($order->status == 'delivered') ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-6">
                    <input name="shipped_date" type="datetime-local" class="form-control" value="{{ $order->shipped_date }}">
                </div>

                <div class="col-md-2 col-6">
                    <div class="custom_select">
                        <select name="payment_status" id="payment_status" class="form-select d-inline-block mb-lg-0 mr-5 mw-200">
                            <option value="paid" {{ ($order->payment_status == 'paid') ? 'selected' : '' }}>Paid</option>
                            <option value="not paid" {{ ($order->payment_status == 'not paid') ? 'selected' : '' }}>Not paid</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            @endif
        </div>
    </div>
</header>

    <!-- card-header end// -->
        <div class="card-body">
            <div class="row mb-50 mt-20 order-info-wrap">
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-person"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Customer</h6>
                            <p class="mb-1">
                                {{ $order->userName }}<br />
                                {{ $order->userEmail }} <br />
                                +216 {{ $order->phone }}
                            </p>
                        </div>
                    </article>
                </div>
                <!-- col// -->
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-local_shipping"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Order info</h6>
                            <p class="mb-1">
                                Shipping: Fargo express <br />
                                Pay method: card <br />
                                Status: new
                            </p>
                        </div>
                    </article>
                </div>
                <!-- col// -->
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-place"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Deliver to</h6>
                            <p class="mb-1">
                                Adresse : {{ $order->adresse }} , <br />{{ $order->adresse2 }}<br />
                                ZIP : {{ $order->zip }}
                            </p>
                        </div>
                    </article>
                </div>
                <!-- col// -->
            </div>
            <!-- row // -->

            <div class="row">
                <div class="col-lg-7">

                    <div class="table-responsive">
                        <table class="table">

                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($orderItem as $item)

                                <tr>

                                    @php
                                    $p=getImage($item->product_id);
                                    @endphp
                                    <td>
                                        <a class="itemside" href="#">
                                            <div class="left">
                                                <img src="{{ asset('storage/images/' . $p->image) }}" alt="{{ $p->name }}" width="60" height="60" class="image product-thumbnail" alt="Item" />
                                            </div>
                                            <div class="info">{{$item->name}}</div>
                                        </a>
                                    </td>
                                    <td>{{$item->price}} €</td>
                                    <td>{{$item->qty}}</td>
                                    <td class="text-end">{{$item->total}} €</td>
                                </tr>

                                @endforeach

                            </tbody>

                        </table>


                    </div>

                    <!-- table-responsive// -->
                </div>
                <!-- col// -->
                <div class="col-lg-1"></div>
                <div class="col-lg-4">
                        <h6 class="mb-15">Payment info : </h6>

                        <p>
                            <div class="table-responsive">
                                <table class="table">

                                <tbody>

                                    <tr>
                                        <td>
                                            <h6 class="text-body">Status</h6>
                                        </td>
                                        <td>

                                            @if($order->status=='pending')
                                            <span class="badge badge-pill badge-soft-danger">Pending</span>

                                            @elseif($order->status=='shipped')
                                            <span class="badge badge-pill badge-soft-warning">Shipped</span>

                                            @else
                                            <span class="badge badge-pill badge-soft-success">Delivred</span>
                                           @endif

                                        </td>

                                    </tr>

                                    <tr>
                                        <td>
                                            <h6 class="text-body">Payment status</h6>
                                        </td>

                                        <td>

                                            @if($order->payment_status=='paid')
                                            <span class="badge badge-pill badge-soft-success">Paid</span>
                                            @else
                                            <span class="badge badge-pill badge-soft-danger">Not paid</span>

                                            @endif

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <h6 class="text-body">Subtotal </h6>
                                        </td>
                                        <td>
                                            <h5 class="text-brand">{{$order->subtotal }} €</h5>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <h6 class="text-body">Discount </h6>
                                        </td>
                                        <td>
                                            <h5 class="text-brand">{{$order->discount }} €</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6 class="text-body">Shipping fee</h6>
                                        </td>
                                        <td>
                                            <h5 class="text-brand">{{$order->shipping }} €</h5>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="price" data-title="Price">
                                            <h6 class="text-body">Total amount</h6>
                                        </th>
                                        <th id="grandTotal" class="price green-bg" data-title="Price">
                                            <h5 class="text-brand">{{$order->grand_total }} €</h5>
                                        </th>
                                    </tr>

                                </tfoot>
                            </table>


                        </p>
                    </div>


                </div>
                <!-- col// -->
            </div>
        </div>
        <!-- card-body end// -->
    </div>
  </form>
</section>
<!-- content-main end// -->

@endsection

