<div class="site-navbar-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
            </div>
            <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('frontend/images/logo.png')}}" alt="" style="width: 100%;">
                </a>
            </div>
            <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                <div class="site-top-icons">
                    <ul>
                        <li>
                            
                            <a href="
                                @if(Auth::check())
                                    @hasanyrole('seller|buyer')
                                        {{ route('user-dashboard') }}
                                    @endhasanyrole
                                    @hasrole('admin')
                                        {{ route('admin-dashboard')}}
                                    @endhasrole
                                @else
                                    {{ route('login') }}
                                @endif    
                                ">
                                <span class="dripicons-user mr-3">
                                    @if(!Auth::check())
                                        Login
                                    @else
                                        {{ Auth::user()->username }}
                                    @endif

                                </span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('cart.index') }}" class="site-cart">
                                <span class=" dripicons-cart"></span>
                                @empty($total_cart)
                                @endempty
                                <span class="count">{{ $total_cart }}</span>
                            </a> 
                        </li>
                        <li class="d-inline-block d-md-none ml-md-0">
                            <a href="#" class="site-menu-toggle js-menu-toggle">
                                <span class="icon-menu"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>