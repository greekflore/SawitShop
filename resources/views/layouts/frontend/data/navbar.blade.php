 <!-- Offcanvas Menu Begin -->
 <div class="offcanvas-menu-overlay"></div>
 <div class="offcanvas-menu-wrapper">
     <div class="offcanvas__close" style="color: white;">+</div>
     <ul class="offcanvas__widget">
         <li><span class="icon_search search-switch" style="color: white;"></span></li>
         <li><a href="#"><span class="icon_bag_alt" style="color: white;"></span>
                 <div class="tip" style="color: white;">2</div>
             </a></li>
     </ul>
     <div class="offcanvas__logo">
         <a href="{{ url('/') }}"><img src="{{ asset('ashion') }}/img/logo.png" alt=""></a>
     </div>
     <div id="mobile-menu-wrap"></div>
 </div>
 <!-- Offcanvas Menu End -->

 <!-- Header Section Begin -->
 <header class="header bg-success">
     <div class="container-fluid">
         <div class="row">
             <div class="col-xl-3 col-lg-2">
                 <div class="">
                     <h1 class="title-logo" style="color: white;">{{ $app_name }}</h1>
                 </div>
             </div>
             <div class="col-xl-6 col-lg-7 text-center">
                 <nav class="header__menu">
                     <ul style="color: white;">
                         <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}" style="color: white;">Home</a></li>
                         <li class="{{ request()->is('product*') ? 'active' : '' }}"><a href="{{ route('product.index') }}" style="color: white;">Belanja</a></li>
                         <li class="{{ request()->is('category*') ? 'active' : '' }}"><a href="{{ route('category.index') }}" style="color: white;">Kategori</a></li>
                         <li class="{{ request()->is('about') ? 'active' : '' }}">
                             <a href="{{ route('about') }}" style="color: white;">Tentang Kami</a>
                         </li>
                         <li class="{{ request()->is('faq') ? 'active' : '' }}">
                             <a href="{{ route('faq') }}" style="color: white;">FAQ</a>
                         </li>
                         @auth
                         <li class="{{ request()->is('category*') ? 'active' : '' }}"><a href="#" style="color: white;"><i class="fa fa-angle-down"></i> {{ auth()->user()->name }}</a>
                             <ul class="dropdown">
                                 <li><a href="{{ route('transaction.index') }}" style="color: white;">Riwayat Belanja</a></li>
                                 <form method="POST" action="{{ route('logout') }}">
                                     @csrf
                                     <li>
                                         <a href="{{ route('logout')  }}" style="color: white;" onclick="event.preventDefault();
                                        this.closest('form').submit();"> Logout
                                         </a>
                                     </li>
                                 </form>
                             </ul>
                         </li>
                         @else
                         <li><a href="{{ route('login') }}" style="color: white;">Login</a></li>
                         @endauth
                     </ul>
                 </nav>
             </div>
             <div class="col-lg-3">
                 <div class="header__right">
                     <ul class="header__right__widget">
                         <li><span class="icon_search search-switch" style="color: white;"></span></li>
                         <li><a href="{{ route('cart.index') }}"><span class="icon_bag_alt" style="color: white;"></span>
                                 <div class="tip" style="color: white;">
                                     {{ $totalCart ?? 0 }}
                                 </div>
                             </a></li>
                     </ul>
                 </div>
             </div>
         </div>
         <div class="canvas__open">
             <i class="fa fa-bars" style="color: white;"></i>
         </div>
     </div>
 </header>
 <!-- Header Section End -->
