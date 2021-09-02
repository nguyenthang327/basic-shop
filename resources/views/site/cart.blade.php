@extends('site.layouts.main')

@section('title', 'Trang giỏ hàng')

@section('content')

@php
$total = 0;
@endphp
<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                        <tr>
                            <th class="shoping__product">Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @if($products)
                            @foreach($products as $product)

                                @php
                                $product->product_image = str_replace("public/", "", $product->product_image);
                                @endphp
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="{{ asset("storage/$product->product_image") }}" style="width: 150px" alt="">
                                        <h5>{{ $product->product_name }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        <span class="product-detail__price-old home-product-item__price-old money">{{ $product->product_price}}</span>
                                        <span class="product-detail__price-current home-product-item__price-curren money">{{$product->product_price - $product->product_price*$product->product_sale/100}}</span>
                                    </td>
                                    <td class="shoping__cart__quantity"">
                                        <div class="quantity1">
                                            <div class="pro-qty">
                                                <input type="text" name="qttCart[]" class="qttCart" data-id="{{ $product->id }}" value="{{ $cart[$product->id][0]['quantity']>$product->product_quantity?$product->product_quantity:$cart[$product->id][0]['quantity']}}" data-allqtt="{{$product->product_quantity}}">
                                            </div>
                                        </div>
                                        
                                    </td>
                                    <td class="shoping__cart__total">
                                        {{ $cart[$product->id][0]['quantity'] * ($product->product_price - $product->product_price*$product->product_sale/100) }}đ
                                        @php
                                            $total += $cart[$product->id][0]['quantity'] * ($product->product_price - $product->product_price*$product->product_sale/100);
                                        @endphp
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <span class="icon_close removeCart" data-id="{{ $product->id }}"><i class="fas fa-times"></i></span>
                                    </td>
                                </tr>
                                
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="{{ url("/home") }}" class="primary-btn cart-btn">Tiếp tục mua sắm</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <li>Subtotal <span class="money"> {{ $total }}</span></li>
                        <li>Total <span class="money">{{ $total }}</span></li>
                    </ul>
                    <a href="{{ url("/payment") }}" class="primary-btn">Mua ngay</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->
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
                    newVal=totalProduct;
                }
                $button.parent().find('input').val(newVal);
                // quantity = newVal;
            });

        });



        $(document).ready(function () {

            $("body").on("click", ".qtybtn", function (e) {

                var input = $(this).closest(".pro-qty").find("input").eq(0);
                var id = input.data("id");
                id = parseInt(id);

                var qtt = input.val();
                qtt = parseInt(qtt);

                if (id > 0 && qtt > 0) {
                    $.ajax({
                        method: "POST",
                        url: "{{ url('/cart/update') }}",
                        data: { id: id,quantity: qtt,_token: "{{ csrf_token() }}" }
                    }).done(setTimeout( function() {
                        location.reload();
                    },3000));
                } else {
                    alert("có lỗi hệ thống vui lòng liên hệ admin");
                }
            });


            $(".qttCart").on("change", function (e) {


                var id = $(this).data("id");
                id = parseInt(id);

                var quantity = $(this).val();
                quantity = parseInt(quantity);

                var totalProduct = $(this).data("allqtt"); 

                totalProduct = parseInt(totalProduct);

                if(quantity>totalProduct){
                    quantity = totalProduct;
                }

                $(this).parent().find("input").val(quantity);
                
                if (id > 0 && quantity > 0) {
                    $.ajax({
                        method: "POST",
                        url: "{{ url('/cart/update') }}",
                        data: { id: id,quantity: quantity,_token: "{{ csrf_token() }}" }
                    }).done(function() {
                        location.reload();
                    });
                } else {
                    alert("có lỗi hệ thống vui lòng liên hệ admin");
                }
                console.log(id);
            });

            $(".removeCart").on("click", function (e) {
                e.preventDefault();

                var id = $(this).data("id");
                id = parseInt(id);

                if (id > 0) {
                    $.ajax({
                        method: "POST",
                        url: "{{ url('/cart/remove') }}",
                        data: { id: id,_token: "{{ csrf_token() }}" }
                    }).done(function(){
                        location.reload();
                    });
                } else {
                    alert("có lỗi hệ thống vui lòng liên hệ admin");
                }
                
        
            });
        });
    </script>
@endsection