@section('content')

@extends('layouts.main')
@section('main-container')
<main class="main page-404">
    <div class="page-content pt-50">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">

                    <section class="text-center mb-50">
                        <h2 class="title style-3 mb-40">Your order created successfully !!</h2><h5> Click <a href="{{ route('accountdetails') }}"> <span>  here  </span></a>to check your order details . <a href="page-contact.html"></h5>

                        <p class="font-lg text-grey-700 mb-30">
                        </p>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="{{ asset('assets/imgs/theme/icons/icon-1.svg') }}" alt="" />
                                    <h4>Best Prices & Offers</h4>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form</p>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="{{ asset('assets/imgs/theme/icons/icon-2.svg') }}" alt="" />
                                    <h4>Wide Assortment</h4>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form</p>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="{{ asset('assets/imgs/theme/icons/icon-3.svg') }}" alt="" />
                                    <h4>Fast Delivery</h4>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form</p>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="{{ asset('assets/imgs/theme/icons/icon-4.svg') }}" alt="" />
                                    <h4>Easy Returns</h4>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form</p>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="{{ asset('assets/imgs/theme/icons/icon-5.svg') }}" alt="" />
                                    <h4>100% Satisfaction</h4>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form</p>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-24">
                                <div class="featured-card">
                                    <img src="{{ asset('assets/imgs/theme/icons/icon-6.svg') }}" alt="" />
                                    <h4>Great Daily Deal</h4>
                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form</p>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>

    </div>
</main>@endsection
