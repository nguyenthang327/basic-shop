
<div class="header" >
            
            <!-- START NAVBAR -->
            <div class="navbar-app grid-padding_80" id="demo-head">
                <ul class="navbar__list">
                    
                    <li class="navbar__list--item navbar__list--item-has-qr">
                        <a href="#" class="navbar__list--item-link">Tải ứng dụng</a>

                        <div class="header__qr">
                            <img src="{{ asset('fe-assets')}}/image/qr-code.png" alt="" class="qr-code">

                            <div class="header__qr-app">
                                <a href="#" class="header__qr-app--link">
                                    <img src="{{ asset('fe-assets')}}/image/ch-play.png" alt="" class="qr-app">
                                </a>
                                <a href="#" class="header__qr-app--link">
                                    <img src="{{ asset('fe-assets')}}/image/app-store.png" alt="" class="qr-app">
                                </a>
                            </div>
                         </div>
                    </li>

                    <li class="navbar__list--item">
                        <a href="#" class="navbar__list--item-link">
                            <i class="navbar-icons fas fa-bell"></i><span>Thông báo</span>
                        </a>
                    </li>

                    <li class="navbar__list--item">
                        <a href="#" class="navbar__list--item-link">
                            <i class="navbar-icons fas fa-question-circle"></i><span>Trợ giúp</span>
                        </a>
                    </li>
                    
                    @guest
                        @if ( Route::has('login'))
                            <li class="navbar__list--item">
                                <a href="{{ url('/login')}}" class="navbar__list--item-link">Đăng nhập</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="navbar__list--item">
                                <a href="{{ url('/register')}}" class="navbar__list--item-link">Đăng ký</a>
                            </li>
                        @endif
                    @else

                        @if (Auth::user()->is_admin == 1)
                            <li class="navbar__list--item">
                                <a href="{{ url('/admin/home')}}" class="navbar__list--item-link">Đến trang admin</a>
                            </li>
                        @endif

                        <li class="navbar__list--item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>

            <!-- END NAVBAR -->

            <!-- START HEADER WITH SEARCH -->
            <div class="header-with-search grid-padding_80" >
                <div class="header__logo">
                    <div class="header__logo-content">
                        <a href="{{ url('/')}}" class="header__logo-link">
                            <img src="{{ asset('fe-assets')}}/image/main-logo-edited.png" alt="" class="header__logo-image" style="width: 30%; height: auto;" >

                            <span class="header__logo-text">VTH_Z</span>
                        </a>
                        
                    </div>
                </div>

                <div class="header__search">
                    <form action="{{ url("/search") }}" method="get" class="form-with-search">
                        <div class="header__search-input-wrap">
                            <input type="text" class="header__search-input" placeholder="Nhập để tìm kiếm" name="keyword">
                                
                                <!-- search-history -->
                            <!-- <div class="header__search-history">
                                <h3 class="header__search-history-heading">Lịch sử tìm kiếm</h3>
                                <ul class="header__search-history-list">
                                    <li class="header__search-history-item">
                                        <a href="#">Thiết bị điện tử</a>
                                    </li>
                                    <li class="header__search-history-item">
                                        <a href="#">Thời trang nam</a>
                                    </li>
                                </ul>
                            </div> -->
                        </div>
                        <button class="header__search-btn">
                            <i class="header__search-btn-icon fa fa-search"></i>
                        </button>
                    </form>
                </div>

                <div class="header__language">
                    <img src="https://dongphucsongphu.com/la-co-viet-nam-vector-1.png" alt="Việt Name" class="header__language-image" style="max-width:40px; height:auto">
                </div>

                <div class="header__cart">
                    <a href="{{ url("/cart") }}" class="">
                         <i class="header__cart-icon fa fa-shopping-cart"></i>
                         @if(Auth::user())
                            <span>{{$totalItem}}</span>
                         @endif
                    </a>

                </div>
            </div>

            <!-- END HEADER WITH SEARCH -->

            <div class="header-with-menu grid-padding_80" id="menu-head">
                <div class="header-category">
                    <span class="header-category-text">Danh mục <i class="icon-arrow-down fas fa-chevron-down"></i></span>
                    <ul class="list-cate">
                        @if($categories)
                            @foreach($categories as $category)
                                <li class="item-cate">
                                    <a href="{{ url("/category/$category->id") }}" class="item-cate-link">{{$category->name}}</a>
                                    <i class="btn-arrow-right fas fa-chevron-right"></i>
                                </li>
                            @endforeach
                        @endif
                        
                        
                    </ul>
                </div>

                <div class="card-channels-with-menu">
                    <ul class="list-card-channel">
                        <li class="item-card-channel">
                            <a href="#" class="item-card-channel-link">
                                    <img class="image-channel" src="//laz-img-cdn.alicdn.com/images/ims-web/TB1UiNthUT1gK0jSZFhXXaAtVXa.png" alt="Vouchers" style="height: 35px;width:35px">
                            
                                
                                <span>Mã giảm giá</span>
                            </a>
                        </li>

                        <li class="item-card-channel">
                            <a href="#" class="item-card-channel-link">
                                    <img class="image-channel" src="//laz-img-cdn.alicdn.com/images/ims-web/TB1UiNthUT1gK0jSZFhXXaAtVXa.png" alt="Vouchers" style="height: 35px;width:35px">
                            
                                
                                <span>Mã giảm giá</span>
                            </a>
                        </li>

                        <li class="item-card-channel">
                            <a href="#" class="item-card-channel-link">
                                    <img class="image-channel" src="//laz-img-cdn.alicdn.com/images/ims-web/TB1UiNthUT1gK0jSZFhXXaAtVXa.png" alt="Vouchers" style="height: 35px;width:35px">
                            
                                
                                <span>Mã giảm giá</span>
                            </a>
                        </li>

                        <li class="item-card-channel">
                            <a href="#" class="item-card-channel-link">
                                    <img class="image-channel" src="//laz-img-cdn.alicdn.com/images/ims-web/TB1UiNthUT1gK0jSZFhXXaAtVXa.png" alt="Vouchers" style="height: 35px;width:35px">
                            
                                
                                <span>Mã giảm giá</span>
                            </a>
                        </li>
                    </ul>
                </div>

               
            </div>

                 
        </div>