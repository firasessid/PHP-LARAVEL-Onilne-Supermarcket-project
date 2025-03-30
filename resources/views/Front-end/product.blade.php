


                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 product-container " data-original-order="{{ $loop->index }}" data-brand="{{ $p->brand_id }}">

                            <div class="product-cart-wrap mb-30 product-featured" >
                                <div class="product-img-action-wrap" >
                                    <div class="product-img product-img-zoom">
                                        <a href="shop-product-right.html">
                                            <img class="default-img" src="{{ asset('storage/images/' . $p->image) }}" alt="" />
                                            <img class="hover-img" src="{{ asset('storage/images/' . $p->image) }}" alt="" />
                                        </a>
                                    </div>

                                    <div class="product-action-1">


                                        <a aria-label="Add To Wishlist" class="action-btn" href="{{ route('add.wishlist', $p->id) }}"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal_{{ $p->id }}"><i class="fi-rs-eye"></i></a>
                                    </div>
                                    @if ($p->quantity == 0)
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">Out of stock </span>
                                    </div>
                                    @endif

                                    @if ($p->quantity >10)
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="new">In stock</span>
                                    </div>
                                    @endif
                                    @if ($p->quantity >= 1 && $p->quantity <= 10)
                                       <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="best">Limited</span>
                                       </div>

                                    @endif



                                </div>

                                <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="shop-grid-right.html">{{$p->description}}</a>
                                </div>
                                <h2><a href="{{ route('products_view', ['id' => $p->id]) }}">{{ $p->name }}</a></h2>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div>
                                    <span class="font-small text-muted">{{$p->quantity}}<a href="vendor-details-1.html">Items left </a></span>
                                </div>
                                <div class="product-card-bottom">
                                    <div class="product-price">
                                        <span>{{$p->regular_price}}$</span>
                                        <span class="old-price">{{$p->sale_price}}$</span>
                                    </div>
                                    <div class="add-cart">
                                        <a class="add" href="{{ route('add_to_cart', $p->id) }}"><i class="fi-rs-shopping-cart mr-5"></i>Add</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>


