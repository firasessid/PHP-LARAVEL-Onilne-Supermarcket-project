@section('content')
@extends('layouts.main')
@section('main-container')

<main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Shop <span></span> Fillter
                </div>
            </div>
        </div>
        <div class="container mb-30 mt-50">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                <div class="mb-50">
    <h1 class="heading-2 mb-10">Your Wishlist</h1>
    <h6 class="text-body">There are <span class="text-brand" id="wishlist-count-page">0</span> products in this list</h6>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function updateWishlistCount() {
            $.ajax({
                url: "/wishlist/count",
                method: "GET",
                success: function (response) {
                    $("#wishlist-count-page").text(response.count);
                }
            });
        }

        updateWishlistCount(); // Charger la valeur au chargement de la page
    });
</script>

                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist">
                            <thead>
                                <tr class="main-heading">
                                    <th class="custome-checkbox start pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11" value="" />
                                    </th>
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col"  >Stock Status</th>
                                    <th scope="col" style="padding-left: 30px;">Action</th>
                                    <th scope="col"  style="padding-right: 40px;">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            
                            @foreach($wishlist as $p)
                                <tr class="pt-30">
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="" />
                                    </td>




                                    <td  data-th="Product" class="shopping-cart-img">
                                                    <a href="shop-product-right.html"><img alt="Nest" src="{{ asset('storage/images/' . $p->image) }}" alt="{{ $p->name }}" /></a>
                                                </div>

                                    <td  data-th="Product" class="product-des product-name">
                                        <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html"> {{ $p->name }}</a></h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width:90%">
                                                </div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </td>



                                    
                                  
                                    <td class="price" data-title="Price">
                                        <h3 class="text-brand">${{$p->sale_price}}</h3>
                                    </td>
                                    <td class="text detail-info" data-title="Stock">
    @if($p->quantity > 0)
        <span class="stock-status in-stock mb-0" >In Stock</span>
    @else
        <span class="stock-status out-stock mb-0" style="color: red;">Out of Stock</span>
    @endif
</td>

                                    <td class="text-right" data-title="Cart">
                                        <button class="btn btn-sm">Add to cart</button>
                                    </td>
                                    <td class="action" data-title="Remove">
                                    
                                        <a href="#" class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
@endforeach
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
  

    @endsection