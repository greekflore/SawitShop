@extends('layouts.frontend.app')
@section('content')
<!-- Banner Slider Section Begin -->
<section class="banner-slider">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <!-- Add multiple items for the slider -->
            <div class="carousel-item active">
                <div class="slider__item set-bg"
                    data-setbg="{{ asset('me') }}/img/sawitshop1.jpg">
                </div>
            </div>
            <div class="carousel-item">
                <div class="slider__item set-bg"
                    data-setbg="{{ asset('me') }}/img/sawitshop2.jpg">
                </div>
            </div>
            <div class="carousel-item">
                <div class="slider__item set-bg"
                    data-setbg="{{ asset('me') }}/img/sawitshop3.jpg">
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>
<!-- Banner Slider Section End -->

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12"> <!-- Full width for categories -->
                <div class="row">
                    @foreach ($data['new_categories'] as $category)
                    <div  class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item  category-img" 
                            data-setbg="{{ asset('storage/' . $category->thumbnails) }}">
                            <div class="categories__text">
                                <h4>{{ $category->name }}</h4>
                                <p>{{ $category->Products()->count() }} item</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>Produk Tersedia</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">All</li>
                    @foreach ($data['new_categories'] as $new_categories)
                    <li data-filter=".{{ $new_categories->slug }}">{{ $new_categories->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row property__gallery">
            @foreach ($data['new_categories'] as $new_categories2)
            @foreach ($new_categories2->Products()->limit(4)->get() as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $new_categories2->slug }}">
                @component('components.frontend.product-card')
                @slot('image', asset('storage/' . $product->thumbnails))
                @slot('route', route('product.show', ['categoriSlug' => $new_categories2->slug, 'productSlug' => $product->slug]))
                @slot('name', $product->name)
                @slot('price', $product->price)
                @endcomponent
            </div>
            @endforeach
            @endforeach
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection