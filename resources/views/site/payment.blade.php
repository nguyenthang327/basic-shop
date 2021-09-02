@extends('site.layouts.main')

@section('title', 'Trang thanh toán')

@section('content')


<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">

        <div class="checkout__form">
            <h4>Thông tin đơn hàng</h4>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" style="font-size: 1.4rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form name="order" method="post" action="{{ url("/payment/checkout") }}">

                @csrf

                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <p>Họ tên<span>*</span></p>
                                    <input type="text" name="customer_name" placeholder="VD: Nguyễn Văn A">
                                </div>
                            </div>
                        </div>

                        <div class="checkout__input">
                            <p>Địa chỉ<span>*</span></p>
                            <input type="text" name="customer_address" placeholder="số nhà, xóm/ngõ, xã/phường, quận/huyện, tỉnh/thành phố" class="checkout__input__add">
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>SDT<span>*</span></p>
                                    <input type="text" name="customer_phone" placeholder="số điện thoại">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="text" name="customer_email" placeholder="Email">
                                </div>
                            </div>
                        </div>

                        <div class="checkout__input">
                            <p>Ghi chú đơn hàng<span>*</span></p>
                            <input type="text" name="order_note"
                                   placeholder="Notes about your order, e.g. special notes for delivery.">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Đơn hàng của bạn</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul>
                                @php
                                    $total = 0;
                                @endphp
                                @if($products)
                                    @foreach($products as $product)
                                        @php
                                            $total += $cart[$product->id][0]['quantity'] * ($product->product_price - $product->product_price * $product->product_sale /100) 
                                        @endphp
                                        <div class="row checkout_row">
                                            <li class="name_one_line">{{ $product->product_name }} </li>
                                            <span class="price_in money">{{ $cart[$product->id][0]['quantity'] * ($product->product_price - $product->product_price * $product->product_sale /100) }} </span>
                                        </div>
                                        
                                    @endforeach
                                @endif
                            </ul>
                            <div class="checkout__order__subtotal">Tổng tiền <span class="money"> {{ $total }} </span></div>
                            <div class="checkout__order__total">Thanh toán <span class="money"> {{ $total }} </span></div>

                            <button type="submit" class="site-btn">ĐẶT HÀNG</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->

@endsection
