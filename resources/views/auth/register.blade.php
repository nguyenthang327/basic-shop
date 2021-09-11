@extends("site.layouts.main")

@section('title', "Đăng kí")

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
            <form action="{{ route('register') }}" method="POST" class="form" id="register-form">

                @csrf
                <h3 class="heading">Đăng ký</h3>
                
                <div class="spacer"></div>
            
                <div class="form-group">
                    <label for="name" class="form-label">Tên đầy đủ</label>
                    <input id="name" name="name" rules="required" type="text" placeholder="VD: Nguyễn Đức Thắng" class="form-control"  value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="form-message">{{ $message}}</span>
                    @enderror
                </div>
            
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" rules="required|email" type="text" placeholder="VD: email@domain.com" class="form-control" value="{{ old('email')}}">
                    @error('email')
                    <span class="form-message">{{ $message}}</span>
                    @enderror
                </div>
            
                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input id="password" name="password" rules="required|min:6" type="password" placeholder="Nhập mật khẩu" class="form-control" required autocomplete="new-password">
                    @error('password')
                    <span class="form-message">{{ $message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
                    <input id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" type="password" class="form-control" required autocomplete="new-password">
                    <span class="form-message"></span>
                </div>

            
                <button class="form-submit">Đăng ký</button>
            </form>
        </div>
    </div>
</section>

@endsection