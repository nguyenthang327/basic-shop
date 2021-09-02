@extends('site.layouts.main');

@section('title',"san pham");

@section('content')



<section class="product-detail">
    <div class="container">
        <div class="row">

            <div class="col-lg-4">
                <?php
                    $product->product_image = str_replace("public/", "",  $product->product_image);
                ?>
                <div class="image-product" style="background-image: url({{ asset("storage/$product->product_image") }}); background-size: contain; background-repeat: no-repeat; "></div>
                
            </div>

            <div class="col-lg-8">
                <h2 class="product-detail__name">{{ $product->product_name}}</h2>

                <div class="product-detail__price home-product-item__price">
                    <span class="product-detail__price-old home-product-item__price-old money">{{ $product->product_price}}</span>
                    <span class="product-detail__price-current home-product-item__price-current money">{{$product->product_price - $product->product_price*$product->product_sale/100}}</span>
                </div>

                <div class="product-detail__quantity row">
                    <span class="product-detail__quantity-text col-lg-2">Số lượng </span>

                    <div class="product-detail__quantity-change">
                        <div class="pro-qty">
                            <input name="quantity" type="text" value="1" data-allqtt="{{$product->product_quantity}}" class="qttPr">
                        </div>
                    </div>

                    <span class="totalProduct">
                        {{$product->product_quantity}} sản phẩm có sẵn
                    </span>
                    
                </div>

                <div class="row">
                    @if(Auth::user())
                        <a href="#" class="btn btn-add-to-cart active" data-id="{{ $product->id }}" >Thêm vào giỏ hàng</a>
                    @else
                    <a href="{{ url("/login") }}" class="btn btn-add-to-cart" data-id="{{ $product->id }}"  onclick="showSuccessToast()">Thêm vào giỏ hàng</a>
                    @endif
                    
                    <a href="{{ url("/payment") }}" class="btn btn-buy" data-id = " {{ $product->id}}">Mua ngay</a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="product-desc_heading">Mô tả sản phẩm</div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="product-desc_content">{!! $product->product_desc !!}</div>
            </div>
        </div>
    </div>

</section>


<div id="toast">
    <div class="toast__icon">
        <i class="far fa-check-circle"></i>
    </div>
    <div class="toast__body">
        <h3 class="toast__title">success</h3>
        <p class="toast__msg">Thêm vào giỏ hàng thành công</p>
    </div>
</div>


@endsection

@section('appendJS')
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function(){
            /*-------------------
                Quantity change
            --------------------- */
            // var quantity = 1;
            var proQty = $('.pro-qty');
            proQty.prepend('<span class="dec qtybtn">-</span>');
            proQty.append('<span class="inc qtybtn">+</span>');
            proQty.on('click', '.qtybtn', function () {
                var totalProduct = $(this).parent().find('input').data("allqtt"); 
                totalProduct = parseInt(totalProduct);
                var $button = $(this);
                var oldValue = $button.parent().find('input').val();
                if ($button.hasClass('inc')) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    // Don't allow decrementing below zero
                    if (oldValue > 1) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 1;
                    }
                }
                if(newVal>totalProduct){
                    newVal = totalProduct;
                }
                $button.parent().find('input').val(newVal);
                // quantity = newVal;
            });

        });

        $(document).ready(function(){
            $('.btn.btn-add-to-cart.active').on('click', function(e){
                e.preventDefault();

                var id = $(this).data("id");
                id =  parseInt(id);

                var quantity = $("input[name='quantity']").val();

                quantity = parseInt(quantity);

                if(id>0){
                    $.ajax({
                        method: "POST",
                        url: "{{url('/cart/add')}}",
                        data: { 
                            id: id,
                            quantity: quantity,
                             _token:"{{ csrf_token()}}"
                        }
                    }).done(function(){
                        $('#toast').fadeIn();
                        setTimeout(function(){
                            $('#toast').fadeOut(3000);
                        },2500)
                    });
                }else{
                    alert("Hệ thống gặp vấn đề vui lòng liên hệ với admin");
                }

            });
            
        });

        $(document).ready(function(){
            $('.btn.btn-buy').on('click', function(e){

                var id = $(this).data("id");
                id =  parseInt(id);

                var quantity = $("input[name='quantity']").val();

                quantity = parseInt(quantity);

                if(id>0){
                    $.ajax({
                        method: "POST",
                        url: "{{url('/cart/add')}}",
                        data: { 
                            id: id,
                            quantity: quantity,
                             _token:"{{ csrf_token()}}"
                        }
                    });
                }else{
                    alert("Hệ thống gặp vấn đề vui lòng liên hệ với admin");
                }

            });  
            
        });

        $(document).ready(function(){
            $('.qttPr').on('change', function(e){
                var quantity = $(this).val();
                quantity = parseInt(quantity);

                var totalProduct = $(this).data("allqtt"); 
                totalProduct = parseInt(totalProduct);

                if(quantity>totalProduct){
                    quantity=totalProduct;
                }

               $(this).val(quantity);

            });
        });
    </script>

@endsecton
