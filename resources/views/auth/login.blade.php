@extends("site.layouts.main")

@section('title', "Đăng nhập")

@section('content')

<section class="register container">
    <div class="row row-edit">
        <div class="col-lg-6 left">
            <image src="{{asset('fe-assets')}}/image/main-logo-edited.png" class="image-form-logo" >

            </image>

            <div class="desc-form-logo">
                VTH_Z
            </div>

            <div class="slogan">
                Nền tảng bán hàng tốt nhất hiện nay
            </div>
        </div>

        <div class="col-lg-6 right">
            <form action="{{ route('login')}}" method="POST" class="form" id="login-form">

                @csrf
                <h3 class="heading">Đăng nhập</h3>
                
                <div class="spacer"></div>
            
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" rules="required|email" type="text" placeholder="VD: email@domain.com" class="form-control" value="{{ old('email')}}">
                    @error('email')
                    <span class="form-message">{{ $message}}</span>
                    @enderror
                </div>
            
                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input id="password" name="password" rules="required|min:6" type="password" placeholder="Nhập mật khẩu" class="form-control">
                    @error('password')
                    <span class="form-message">{{ $message}}</span>
                    @enderror
                </div>
            
                <button class="form-submit">Đăng nhập</button>
                <div style="padding:12px 0;font-size:1.6rem">
                    <span>Hoặc đăng nhập bằng</span>
                </div>

                <a href="{{ route("login.facebook") }}" class="btn btn-primary" style="color:#fff;"><i class="fab fa-facebook-square" style="padding:0 6px; font-size:2.0rem"></i> Đăng nhập Facebook</a>
            </form>
        </div>
    </div>
</section>

@endsection