@extends('site.layouts.main');

@section('title',"trang danh muc");

@section('content')
<section class="category-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="category-desc">
                    <div class="category-page-name">Danh mục {{$category->name}}</div>
                    <div class="total-products-in-category-page">{{$productQttInCategory}} sản phẩm</div>
                </div>
            </div>

            <div class="col-lg-4 form-for-sort">
                <form action="{{ htmlspecialchars($_SERVER["REQUEST_URI"]) }}" method="get" class="form-auto-submit" id="form-auto-sm">
                    <div class="form-group">
                        <label for="products-sort">Sắp xếp theo:</label>
                        <select name="sort" class="form-control margin_left_6" id="product_sort">
                            <option>Phù hợp nhất</option>
                            <option value="price_asc" {{ $sort == "price_asc" ? "selected" : "" }}>Giá: Từ thấp đến cao</option>
                            <option value="price_desc" {{ $sort == "price_desc" ? "selected" : "" }}>Giá: Từ cao đến thấp</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @if($discountProducts)
                @foreach($discountProducts as $discountProduct)
                    @if($discountProduct->product_status == 1)
                    <div class="col-lg-3">
                        <a class="home-product-item" href="{{ url("/product/$discountProduct->id") }}">

                        <?php
                            $discountProduct->product_image = str_replace("public/","",$discountProduct->product_image);
                        ?>

                            <div class="home-product-item__img" style="background-image: url({{ asset("storage/$discountProduct->product_image") }}); background-size: contain; background-repeat: no-repeat;"></div>
                            <h4 class="home-product-item__name">{{$discountProduct->product_name}}</h4>
                            <div class="home-product-item__price">
                                <span class="home-product-item__price-old money">{{$discountProduct->product_price}}</span>
                                <span class="home-product-item__price-current money">{{$discountProduct->product_price - $discountProduct->product_price *$discountProduct->product_sale/100}}</span>
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
                            @if($discountProduct->product_sale > 0)
                            <div class="home-product-item__sale-off">
                                <div class="home-product-item__sale-off-percent">{{$discountProduct->product_sale}}%</div>
                                <div class="home-product-item__sale-off-label">GIẢM</div>
                            </div>
                            @endif
                        </a>
                    </div>
                    @endif
                @endforeach
            @endif
            
        </div>
    </div>
</section>

@endsection

@section('appendJS')
    <script>
        // auto submit form
        document.getElementById("product_sort").onchange = function() {
            document.getElementById("form-auto-sm").submit();
        };
    </script>
@endsection