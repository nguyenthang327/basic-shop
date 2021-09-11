@extends('site.layouts.main')

@section('title', 'Trang thanh toán')

@section('content')
    
    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">

            <div class="checkout__form">
                <h4>Thông tin</h4>

                @if (session('status'))
                    <div class="alert alert-success" style="font-size:1.6rem">
                        {{ session('status') }}
                    </div>
                @endif

            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

@endsection
