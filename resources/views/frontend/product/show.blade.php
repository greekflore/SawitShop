@extends('layouts.frontend.app')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="">{{ $data['product']->Category ? $data['product']->Category->name : 'Uncategorized' }}</a>
                        <span>{{ $data['product']->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                <img data-hash="product-1" class="product__big__img" src="{{ asset($data['product']->thumbnails_path) }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        <h3>{{ $data['product']->name }} 
                            <span>Kategori: {{ $data['product']->Category ? $data['product']->Category->name : 'Uncategorized' }}</span>
                        </h3>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <span>( 138 reviews )</span>
                        </div>
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <div class="product__details__price">{{ $data['product']->price }}</div>
                            <div class="product__details__button">
                                <div class="quantity">
                                    <span>Jumlah:</span>
                                    <div class="pro-qty">
                                        <input type="number" name="cart_qty" value="1" min="1" max="{{ $data['product']->stok }}" required>
                                    </div>
                                    <input type="hidden" name="cart_product_id" value="{{ $data['product']->id }}">
                                </div>
                                <button type="submit" class="cart-btn" 
                                    @if($data['product']->stok <= 0) 
                                        disabled 
                                    @endif>
                                    <span class="icon_bag_alt"></span> Tambah Ke Keranjang
                                </button>
                                @if($data['product']->stok <= 0)
                                    <p class="text-danger">Stok habis!</p>
                                @endif
                            </div>
                        </form>
                        <div class="product__details__widget">
                            <ul>
                                <li>
                                    <span>Satuan : </span>
                                    <p>{{ $data['product']->satuan }} </p>
                                </li>
                                <li>
                                    <span>Berat : </span>
                                    <p>{{ $data['product']->weight }} (GR/ML)</p>
                                </li>
                                <li>
                                    <span>Stok : </span>
                                    <p>{{ $data['product']->stok }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
 
                <!-- Akhir dari bagian ulasan -->

                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Deskripsi Produk</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <h6>Deskripsi Produk</h6>
                                {!! $data['product']->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="related__title">
                        <h5>Produk Lainnya</h5>
                    </div>
                </div>
                @foreach ($data['product_related'] as $product_related)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    @component('components.frontend.product-card')
                        @slot('image', asset('storage/' . $product_related->thumbnails))
                        @slot('route', route('product.show', ['categoriSlug' => $product_related->Category->slug, 'productSlug' =>
                        $product_related->slug]))
                        @slot('name', $product_related->name)
                        @slot('price', $product_related->price)
                    @endcomponent
                </div>
                @endforeach
            </div>
                           <!-- Pindahkan bagian ulasan ke sini, di luar tab -->
                           <div class="col-lg-12 mt-5">
                    
                    <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Ulasan Pelanggan</a>
                                </li>
                            </ul>                    @if($data['product']->reviews->count() > 0)
                            @foreach ($data['product']->reviews as $review)
                                <div class="review-item d-flex align-items-center mb-4">
                                    <!-- Gambar Profil Statis -->
                                    <img alt="image" src="{{ asset('stisla') }}/img/avatar/avatar-2.png" class="rounded-circle mr-3" style="width: 50px; height: 50px; object-fit: cover; margin-top:-30px;">
                                    
                                    <div>
                                    <div style="color:black; font-weight:800;" class="review-author">
    {{ $review->user ? $review->user->name : 'Anonymous' }}
</div>

                                        <div class="review-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <i class="fa fa-star text-warning"></i>
                                                @else
                                                    <i class="fa fa-star-o text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <div style="color:black; font-weight:600;"class="review-text">
                                            {{ $review->comment }}
                                        </div>
                                        <div class="review-text">
                                        {{ $review->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No reviews yet.</p>
                        @endif
                    </div>
        </div>
    </section>
    <!-- Product Details Section End -->
@endsection
