@extends("site.layouts.main");

@section('title', "Trang chủ")


@section('content')

<!-- START CAROUSEL-->
<div class="carousel" style="top:106px;">
    <div id="demo" class="carousel slide" data-ride="carousel" >

        <!-- Indicators -->
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
            <li data-target="#demo" data-slide-to="3"></li>
        </ul>
        
        <!-- The slideshow -->
        <div class="carousel-inner">

            <div class="carousel-item active" style="background-color: rgb(141, 1, 0); width: 100%; height: 344px;">
                <img src="https://icms-image.slatic.net/images/ims-web/373fe94e-28fe-4d18-91e2-6cc75ea45565.jpg_1200x1200.jpg" width="1100" height="500" class="grid-padding_80 padding-left_280">
            </div>

            <div class="carousel-item" style="background:rgb(255, 151, 0) ; width: 100%; height: 344px;">
                <img src="https://icms-image.slatic.net/images/ims-web/e998dc33-7979-41a5-a342-2f311a6e6502.jpg" width="1100" height="500" class="grid-padding_80 padding-left_280">
            </div>

            <div class="carousel-item" style="background:rgb(252, 236, 3) ; width: 100%; height: 344px;">
                <img src="https://icms-image.slatic.net/images/ims-web/1c9e5a8c-910d-4f20-b821-5580f115a4b9.jpg" width="1100" height="500" class="grid-padding_80 padding-left_280">
            </div>

            <div class="carousel-item" style="background-color: rgb(222, 230, 242); width: 100%; height: 344px;">
                <img src="https://icms-image.slatic.net/images/ims-web/ba04501a-4d9f-4b3a-9ff6-609d431d817d.jpg" width="1100" height="500" class="grid-padding_80 padding-left_280">
            </div>


        </div>
        
        <!-- Left and right controls -->
        <!-- <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>

        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a> -->
    </div>

    <div class="category">
        
        <ul class="category-list">
            @if($categories)
                @foreach($categories as $category)
                    <li class="category-item" onmouseout="mOut(this)" onmouseover="mOver(this)">
                        <a href="{{url("/category/$category->id")}}" class="category-item-link">{{$category->name}}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
<!-- END CAROUSEL -->

<div class="app-container grid-margin_80" style="margin-top: 130px;">
    <!-- CARD CHANNEL -->
    <div class="card-channels ">

        <div class="card-channel">
            <a href="#" class="card-channel--link">
                <div class="card-image-channel">
                    <img class="image-channel" src="//laz-img-cdn.alicdn.com/images/ims-web/TB1UiNthUT1gK0jSZFhXXaAtVXa.png" alt="Vouchers">
                </div>
                
                <span>Mã giảm giá</span>
            </a>
        </div>

        <div class="card-channel">
            <a href="#" class="card-channel--link">
                <div class="card-image-channel">
                    <img class="image-channel" src="//laz-img-cdn.alicdn.com/images/ims-web/TB1UiNthUT1gK0jSZFhXXaAtVXa.png" alt="Vouchers">
                </div>
                <span>Mã giảm giá</span>
            </a>
        </div>

        <div class="card-channel">
            <a href="#" class="card-channel--link">
                <div class="card-image-channel">
                    <img class="image-channel" src="//laz-img-cdn.alicdn.com/images/ims-web/TB1UiNthUT1gK0jSZFhXXaAtVXa.png" alt="Vouchers">
                </div>
                <span>Mã giảm giá</span>
            </a>
        </div>

        <div class="card-channel">
            <a href="#" class="card-channel--link">
                <div class="card-image-channel">
                    <img class="image-channel" src="//laz-img-cdn.alicdn.com/images/ims-web/TB1UiNthUT1gK0jSZFhXXaAtVXa.png" alt="Vouchers">
                </div>
                <span>Mã giảm giá</span>
            </a>
        </div>        
        
    </div>
    <!--END CARD CHANNEL -->

    <!-- FLASH SALE -->
    <section class="flash-sales" id="products-sale">
        <div class="row_1">
            <h2 class="flash-sale__heading">
                FLASH SALE
            </h2>

            <div class="flash-sale--count-down">
                <span class="flash-sale__span">Kết thúc trong</span>
                <!-- <span id="days" class="count-down"></span>  -->
                <span id="hours" class="count-down"></span> :
                <span id="minutes" class="count-down"></span> :
                <span id="seconds" class="count-down"></span>
            </div>

        </div>

        <div class="row_2">
            <div class="product-flash-sales" style="overflow: hidden;">
                <ul class="flash-sale-list">

                    @if($productsSaleUp)
                        @foreach($productsSaleUp as $productSale)
                            @if($productSale->product_status == 1)
                            <li class="flash-sale-list--item slide-item">
                                <a href="{{ url("/product/$productSale->id") }}" class="flash-sale-list--item-link">

                                    <?php
                                         $productSale->product_image = str_replace("public/", "",  $productSale->product_image);

                                    ?>
                                   
                                    <div class="flash-sale-item-card__image">
                                        <div class="flash-sale-item-card__image--modify" style="background-image: url({{ asset("storage/$productSale->product_image")}}); background-size: contain; background-repeat: no-repeat;" >
                                        </div>
                                    </div>
                                    
                                    <div class="flash-sale-item-card__lower-wrapper">
                                        <h4 class="flash-sale-item-name">{{ $productSale->product_name}}</h4>
                                        <div class="flash-sale__price">
                                            <span class="price-old money">{{$productSale->product_price}}</span>                      
                                            <span class="price-current money">{{$productSale->product_price - $productSale->product_price*$productSale->product_sale/100}}</span>

                                        </div>
                                    </div>

                                    <div class="flash-sale-item__sale-off">
                                        <div class="flash-sale-item__sale-off-percent">{{ $productSale->product_sale}}%</div>
                                        <div class="flash-sale-item__sale-off-label">GIẢM</div>
                                    </div>
                                </a>
                            </li>
                            @endif
                        @endforeach
                    @endif
                    
                    <a class="prev" onclick="plusSlides(-1)"><i class="fl-icon fas fa-chevron-left"></i></a>
                    <a class="next" onclick="plusSlides(1)"><i class="fl-icon fas fa-chevron-right"></i></a>
                </ul>
            </div>
        </div>
    </section>
    <!-- END FLASH SALE -->

    <!-- SEARCH POPULAR -->
    <section class="search-popular margin-top_10" id="products-popular">
        <div class="row_1">
            <h2 class="search-popular__heading h2_heading">
                Tìm kiếm phổ biến
            </h2>
        </div>
        <div class="row_2 product-popular">
            <div class="product-popular-first">
                <a href="#" class="product-popular-first-link">

                    <div class="product-image-contain">
                        <div class="product-popular-img" style="background-image: url(https://vn-test-11.slatic.net/p/a2216465da372cc11ad66b04d006b05d.jpg_150x150Q100.jpg_.webp);background-repeat: no-repeat;background-size: contain; border-radius: 4px; width: 144px; height: 144px; margin: 0 auto;"></div>
                    </div>
                    

                    <h4 class="product-popular-item__name">Nước hoa nam</h4>
                    <div class="product-popular-item__quatity">
                        1340 sản phẩm
                    </div>
                </a>

                
            </div>

            <div class="product-popular-next">
                <div class="wrap-item">
                    <a href="#" class="product-popular-next-link" style="background-color: #f2eee9">

                        <div class="product-image-contain-next">
                            <div class="product-popular-img" style="background-image: url(https://vn-test-11.slatic.net/p/9a7a464ee3b959e4eca8539bb6f519ff.jpg_80x80Q100.jpg_.webp);background-repeat: no-repeat;background-size: contain; border-radius: 4px; width: 80px; height: 80px;"></div>
                        </div>
                        

                        <div class="product-desc">
                            <h4 class="product-popular-item__name">Điện thoại iphone</h4>
                            <div class="product-popular-item__quatity">
                                100 sản phẩm
                            </div>
                        </div>
                    </a>
                </div>

            
                <div class="wrap-item">
                    <a href="#" class="product-popular-next-link" style="background-color: #ecf5f8">

                        <div class="product-image-contain-next">
                            <div class="product-popular-img" style="background-image: url(https://my-live-02.slatic.net/p/29b85e3dda5ab059cbfbf2f11707db89.jpg);background-repeat: no-repeat;background-size: contain; border-radius: 4px; width: 80px; height: 80px;"></div>
                        </div>
                        

                        <div class="product-desc">
                            <h4 class="product-popular-item__name">May choi game</h4>
                            <div class="product-popular-item__quatity">
                                100 sản phẩm
                            </div>
                        </div>
                    </a>
                </div>

                <div class="wrap-item">
                    <a href="#" class="product-popular-next-link" style="background-color: #f2eed8">

                        <div class="product-image-contain-next">
                            <div class="product-popular-img" style="background-image: url(https://vn-test-11.slatic.net/original/14335b4a88e931bd690dda388e5900b6.jpg_80x80Q100.jpg_.webp);background-repeat: no-repeat;background-size: contain; border-radius: 4px; width: 80px; height: 80px;"></div>
                        </div>
                        

                        <div class="product-desc">
                            <h4 class="product-popular-item__name">Quan ao nam</h4>
                            <div class="product-popular-item__quatity">
                                100 sản phẩm
                            </div>
                        </div>
                    </a>
                </div>

                <div class="wrap-item">
                    <a href="#" class="product-popular-next-link" style="background-color: #f2eee9">

                        <div class="product-image-contain-next">
                            <div class="product-popular-img" style="background-image: url(https://vn-test-11.slatic.net/p/9a7a464ee3b959e4eca8539bb6f519ff.jpg_80x80Q100.jpg_.webp);background-repeat: no-repeat;background-size: contain; border-radius: 4px; width: 80px; height: 80px;"></div>
                        </div>
                        

                        <div class="product-desc">
                            <h4 class="product-popular-item__name">Điện thoại iphone</h4>
                            <div class="product-popular-item__quatity">
                                100 sản phẩm
                            </div>
                        </div>
                    </a>
                </div>

            
                <div class="wrap-item">
                    <a href="#" class="product-popular-next-link" style="background-color: #ecf5f8">

                        <div class="product-image-contain-next">
                            <div class="product-popular-img" style="background-image: url(https://my-live-02.slatic.net/p/29b85e3dda5ab059cbfbf2f11707db89.jpg);background-repeat: no-repeat;background-size: contain; border-radius: 4px; width: 80px; height: 80px;"></div>
                        </div>
                        

                        <div class="product-desc">
                            <h4 class="product-popular-item__name">May choi game</h4>
                            <div class="product-popular-item__quatity">
                                100 sản phẩm
                            </div>
                        </div>
                    </a>
                </div>

                <div class="wrap-item">
                    <a href="#" class="product-popular-next-link" style="background-color: #f2eee9">

                        <div class="product-image-contain-next">
                            <div class="product-popular-img" style="background-image: url(https://vn-test-11.slatic.net/original/14335b4a88e931bd690dda388e5900b6.jpg_80x80Q100.jpg_.webp);background-repeat: no-repeat;background-size: contain; border-radius: 4px; width: 80px; height: 80px;"></div>
                        </div>
                        

                        <div class="product-desc">
                            <h4 class="product-popular-item__name">Quan ao nam</h4>
                            <div class="product-popular-item__quatity">
                                100 sản phẩm
                            </div>
                        </div>
                    </a>
                </div>
                
            </div>

        </div>
    </section>
    <!-- END SEARCH POPULAR -->

    <!-- All Product -->
    <section class="home-product margin-top_10" id="products-all">
        <div class="row_1">
            <h2 class="search-popular__heading h2_heading">
                Tất cả sản phẩm
            </h2>
        </div>

        <div class="row_2" style="background-color:transparent;">
            <div class="grid__row">
                <!-- <?php
                    // for($i=1;$i<=24;++$i){
                    
                ?> -->

                @if($products)
                    @foreach($products as $product)
                        @if($product->product_status == 1)
                        <div class="grid__column-2-4">
                            <a class="home-product-item" href="{{ url("product/$product->id")}}">

                                <?php
                                    $product->product_image = str_replace("public/", "",  $product->product_image);
                                ?>

                                <div class="home-product-item__img" style="background-image: url({{ asset("storage/$product->product_image")}});"></div>
                                <h4 class="home-product-item__name">{{ $product->product_name}}</h4>
                                <div class="home-product-item__price">
                                    <span class="home-product-item__price-old money">{{ $product->product_price}}</span>
                                    <span class="home-product-item__price-current money">{{ $product->product_price - $product->product_price*$product->product_sale/100}}</span>
                                    
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
                                @if($product->product_sale > 0)
                                    <div class="home-product-item__sale-off">
                                        <div class="home-product-item__sale-off-percent">{{ $product->product_sale}}%</div>
                                        <div class="home-product-item__sale-off-label">GIẢM</div>
                                    </div>
                                @endif
                            </a>
                        </div>
                        @endif
                    @endforeach
                @endif
                
                <!-- <?php
                    //}
                ?> -->
                
            </div>
        </div>
        
        <div class="see-more-product" >
            <a href="{{ url("/all-products") }}" class="btn btn-see-more">Xem thêm</a>
        </div>
    </section>

    
    <div class="scroll-navbox">
        <ul class="list-scroll">
            <li class="item-scroll"><a href="#top" class="item-scroll-link"><i class="icon-scroll fas fa-chevron-up"></i></a></li>
            <li class="item-scroll" title="flash sale"><a href="#products-sale" class="item-scroll-link"><i class="icon-scroll fas fa-fire"></i></a></li>
            <li class="item-scroll" title="Tìm kiếm phổ biến"><a href="#products-popular" class="item-scroll-link"><i class="icon-scroll far fa-clock"></i></a></li>
            <li class="item-scroll" title="Tất cả sản phẩm"><a href="#products-all" class="item-scroll-link"><i class="icon-scroll fas fa-th"></i></a></li>
        </ul>
    </div>
    <!-- END ALL PRODUCT -->

    
    
</div>

@endsection

