@extends('site.layouts.main');

@section('title',"Tìm kiếm");

@section('content')
<section class="category-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="all-products">
                    <div class="category-page-name" style="font-size: 2,2rem; padding:12px;">Kết quả tìm kiếm cho: {{$keyword}}</div>
                </div>
            </div>
        </div>

        <div class="row">
            @if($products)
                @foreach($products as $product)
                    <div class="col-lg-3">
                        <a class="home-product-item" href="{{ url("/product/$product->id") }}">

                        <?php
                            $product->product_image = str_replace("public/","",$product->product_image);
                        ?>

                            <div class="home-product-item__img" style="background-image: url({{ asset("storage/$product->product_image") }}); background-size: contain; background-repeat: no-repeat;"></div>
                            <h4 class="home-product-item__name">{{$product->product_name}}</h4>
                            <div class="home-product-item__price">
                                <span class="home-product-item__price-old money">{{$product->product_price}}</span>
                                <span class="home-product-item__price-current money">{{$product->product_price - $product->product_price *$product->product_sale/100}}</span>
                            </div>
                            <div class="home-product-item__action">
                                <span class="home-product-item__like home-product-item__liked">
                                    <i class="home-product-item__like-icon-empty far fa-heart"></i>
                                    <i class="home-product-item__like-icon-fill fas fa-heart"></i>
                                </span>
                                <div class="home-product-item__rating">
                                    <i class="home-product-item__star-gold fa fa-star"></i>
                                    <i class="home-product-item__star-gold fa fa-star"></i>
                                    <i class="home-product-item__star-gold fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="home-product-item__sold">Đã bán 251</div>
                            </div>
                            <div class="home-product-item__origin">
                                <span class="home-product-item__brand">Whoo</span>
                                <span class="home-product-item__origin-name">Nhật Bản</span>
                            </div>
                            <div class="home-product-item__favourite">
                                <i class="fa fa-check"></i>
                                <span> Yêu thích</span>
                            </div>
                            <div class="home-product-item__sale-off">
                                <div class="home-product-item__sale-off-percent">{{$product->product_sale}}%</div>
                                <div class="home-product-item__sale-off-label">GIẢM</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
            
        </div>

    </div>
</section>

@endsection
