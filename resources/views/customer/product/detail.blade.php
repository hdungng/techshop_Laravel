@extends('layouts.customer')

@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ url('/') }}">Trang chủ</a></li>
                        <li><a href="{{ route('category', $product->cat_name) }}">{{ $product->cat_name }}</a></li>
                        <li class="active">{{ $product->name }}</li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- Product main img -->
                <div class="col-md-5">
                    <div id="product-main-img">
                        <div class="product-preview">
                            <img src="{{ url($product->thumbnail) }}" alt="">
                        </div>
                    </div>
                </div>


                <!-- Product details -->
                <div class="col-md-5">
                    <div class="product-details">
                        <h2 class="product-name">{{ $product->name }}</h2>
                        <div>
                            <a class="review-link" href="#">10 Review(s) | Add your review</a>
                        </div>
                        <div>
                            <h3 class="product-price">{{ number_format($product->price, 0, ',', '.') }}đ</h3>
                            <span class="product-available">{{ $product->quantity }} sản phẩm</span>
                        </div>
                        <p>{{ $product->description }}</p>

                        <div class="add-to-cart">
                            <div class="qty-label">
                                Số lượng
                                <div class="input-number">
                                    <input type="number" min="0" max="{{ $product->quantity }}" value="1">
                                    <span class="qty-up">+</span>
                                    <span class="qty-down">-</span>
                                </div>
                            </div>
                            <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> thêm vào giỏ hàng</button>
                        </div>

                        <ul class="product-btns">
                            <li><a href="#"><i class="fa fa-heart-o"></i> yêu thích</a></li>
                        </ul>

                        <ul class="product-links">
                            <li>Category:</li>
                            <li><a href="#">{{ $product->cat_name }}</a></li>
                        </ul>
                        <div class="product-links">
                            <h4>Ảnh liên quan</h4>
                            @php
                                $images_list = explode('|', $images->url);
                            @endphp
                            @foreach ($images_list as $image)
                                <div style="display: inline-block;">
                                    <img style="width: 150px; height: 100px;" src="{{ url($image) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Product details -->

        <!-- Product tab -->
        <div class="col-md-12">
            <div id="product-tab">
                <!-- product tab nav -->
                <ul class="tab-nav">
                    <li class="active"><a data-toggle="tab" href="#tab1">Detail</a></li>
                </ul>
                <!-- /product tab nav -->

                <!-- product tab content -->
                <!-- tab1  -->
                <div id="tab1" class="tab-pane fade in">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                {!! $product->detail !!}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /tab1  -->
            </div>
            <!-- /product tab content  -->
        </div>
    </div>
    <!-- /product tab -->

@endsection
