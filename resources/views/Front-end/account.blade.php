
@section('content')

@extends('layouts.main')
@section('main-container')






<style>.gradient-custom-2 {
    /* fallback for old browsers */
    background: #a1c4fd;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1));

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1))
    }

    #progressbar-1 {
    color: #455A64;
    }

    #progressbar-1 li {
    list-style-type: none;
    font-size: 13px;
    width: 33.33%;
    float: left;
    position: relative;
    }

    #progressbar-1 #step1:before {
    content: "1";
    color: #fff;
    width: 29px;
    margin-left: 22px;
    padding-left: 11px;
    }

    #progressbar-1 #step2:before {
    content: "2";
    color: #fff;
    width: 29px;
    }

    #progressbar-1 #step3:before {
    content: "3";
    color: #fff;
    width: 29px;
    margin-right: 22px;
    text-align: center;
    }

    #progressbar-1 li:before {
    line-height: 29px;
    display: block;
    font-size: 12px;
    background: #455A64;
    border-radius: 50%;
    margin: auto;
    }

    #progressbar-1 li:after {
    content: '';
    width: 121%;
    height: 2px;
    background: #455A64;
    position: absolute;
    left: 0%;
    right: 0%;
    top: 15px;
    z-index: -1;
    }

    #progressbar-1 li:nth-child(2):after {
    left: 50%
    }

    #progressbar-1 li:nth-child(1):after {
    left: 25%;
    width: 121%
    }

    #progressbar-1 li:nth-child(3):after {
    left: 25%;
    width: 50%;
    }

    #progressbar-1 li.active:before,
    #progressbar-1 li.active:after {
    background: #1266f1;
    }

    .card-stepper {
    z-index: 0
    }</style>

</script>
<main class="main pages">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Pages <span></span> My Account
            </div>
        </div>
    </div>
    <div class="page-content pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column" role="tablist">
                                   
                                <li class="nav-item">
    <a class="nav-link active" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="true">
        <i class="fi-rs-shopping-bag mr-10"></i>Orders
    </a>
</li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi-rs-shopping-cart-check mr-10"></i>Transactions</a>
                                    </li>
                                  
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="fi-rs-user mr-10"></i>Account details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="page-login.html"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content account dashboard-content pl-50">
                            <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
    <div class="mb-50">
        <h1 class="heading-2 mb-10">Your Orders</h1>
        <h6 class="text-body">There are <span class="text-brand">5</span> orders in this list</h6>
    </div>
                                    <div class="table-responsive shopping-summery">
                                        <table class="table table-wishlist">
                                        <thead>
    <tr class="main-heading">
        <th class="custome-checkbox start pl-30">
            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11" value="" />
        </th>
        <th scope="col">Orders</th>
        <th scope="col">Total</th>
        <th scope="col">Status</th>

        @if ($orders->contains('status', 'pending'))
            <th scope="col">Purchased date</th>
        @elseif ($orders->contains('status', 'shipped'))
            <th scope="col">Shipped date</th>
        @else
            <th scope="col">Delivered date</th>
        @endif

        <th scope="col" class="end">Details</th>
    </tr>
</thead>

                                            <tbody>
                                                @foreach ($orders as $p )

                                                <tr class="pt-30">
                                                    <td class="custome-checkbox pl-30">
                                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="" />
                                                    </td>

                                                    <td >
                                                       <h6> <a class="product-name mb-10" href="shop-product-right.html">#{{ $p->id }}</a></h6>

                                                    </td>
                                                    <td >
                                                        <h6><a class="product-name mb-10" href="shop-product-right.html">€{{ $p->grand_total }}</a></h6>

                                                    </td>

                                                   @if($p->status=='pending')
                                                    <td class="price" data-title="Stock">
                                                         <span class="stock-status out-stock mb-0">Pending</span>
                                                    </td>
                                                    @elseif($p->status=='shipped')
                                                    <td class="price" data-title="Stock">
                                                        <span class="stock-status in-stock mb-0">Shipped</span>
                                                    </td>
                                                    @else
                                                    <td class="price" data-title="Stock">
                                                        <span class="stock-status stock mb-0">Delivred</span>
                                                    </td>
                                                   @endif

                                                
                                                   @if($p->status=='pending')
                                                   <td class="price" data-title="Stock">
                                                        <span class="stock-status out-stock mb-0">{{ $p->created_at }}</span>
                                                    </td>
                                                   @elseif($p->status=='shipped')
                                                   <td class="price" data-title="Stock">
                                                        <span class="stock-status out-stock mb-0">{{ $p->shipped_date }}</span>
                                                    </td>
                                                     @else
                                                     <td class="price" data-title="Stock">
                                                        <span class="stock-status out-stock mb-0">{{ $p->shipped_date }}</span>
                                                    </td>
                                                   @endif

                                                
                                                
                                                     <td class="text-right" data-title="Cart">
                                                        <a href="{{ route('accountdet', [$p->id]) }}" class="btn btn-xs">Details</a>
                                                    </td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                    



                                <div class="mb-50">
                                        <h1 class="heading-2 mb-10">Transations</h1>
                                        <h6 class="text-body">There are <span class="text-brand">5</span> transactions in this list</h6>
                                    </div>
                                    <div class="table-responsive shopping-summery">
                                        <table class="table table-wishlist">
                                            <thead>
                                                <tr class="main-heading">
                                                    <th class="custome-checkbox start pl-30">
                                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11" value="" />
                                                    </th>
                                                    <th scope="col">Transaction ID</th>
                                                    <th scope="col">Paid amount	</th>
                                                    <th scope="col">Method</th>
                                                    <th scope="col">Transaction date</th>
                                                    <th scope="col" class="end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $p )
                                                @if($p->payment_method=='card'||$p->payment_method=='paypal')

                                                <tr class="pt-30">
                                                    <td class="custome-checkbox pl-30">
                                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="" />
                                                    </td>

                                                    <td >
                                                       <h6> <a  href="shop-product-right.html">#{{ $p->id }}</a></h6>

                                                    </td>
                                                    <td >
                                                        <h6><a  href="shop-product-right.html">€{{ $p->grand_total }}</a></h6>

                                                    </td>

                                                    @if($p->payment_method=='card')


                                                    <td>
    <div class="icontext" style="display: flex; align-items: flex-start;">
        <img class="icon border" src="assets/imgs/card-brands/2.png" alt="Payment" style="width: 60px; height: auto; margin-right: 10px;" />
        <span class="text text-muted" style="margin-top: 8px;">Master card</span>
    </div>
</td>


@elseif($p->payment_method=='paypal')

 <td>
    <div class="icontext" style="display: flex; align-items: flex-start;">
        <img class="icon border" src="assets/imgs/card-brands/3.png" alt="Payment" style="width: 60px; height: auto; margin-right: 10px;" />
        <span class="text text-muted" style="margin-top: 8px;">Paypal</span>
    </div>
</td>
@endif




                                                   <td class="price" data-title="Stock">
                                                        <span class="stock-status in-stock mb-0">{{ $p->created_at }}</span>
                                                    </td>
                                                    <td class="text-right" data-title="Cart">





                                        <form method="POST" action="{{ route('delete', $p->id) }}">
                                           
                                        @csrf
                                               <input name="_method" type="hidden" value="DELETE">
    
                                               <a href="#"   class="btn btn-sm font-sm btn-light rounded show_confirm "> <i class="material-icons md-delete_forever show_confirm"></i> Delete </a>

                                               </form>

                                               </td>





                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                             
                                <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Account Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <p>Do you want to make some changes ? <a href="page-login.html"></a></p>
                                            <form method="post" name="enq">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Full name <span class="required">*</span></label>
                                                        <input required="" class="form-control" name="name" type="text" />
                                                    </div>
                                                  
                                                 
                                                    <div class="form-group col-md-6">
                                                        <label>Email Address <span class="required">*</span></label>
                                                        <input required="" class="form-control" name="email" type="email" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Pone Number <span class="required">*</span></label>
                                                        <input required="" class="form-control" name="email" type="email" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Adresse <span class="required">*</span></label>
                                                        <input required="" class="form-control" name="password" type="text" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>New Password <span class="required">*</span></label>
                                                        <input required="" class="form-control" name="npassword" type="password" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Confirm Password <span class="required">*</span></label>
                                                        <input required="" class="form-control" name="cpassword" type="password" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
