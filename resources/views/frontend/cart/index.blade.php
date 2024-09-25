@extends('layouts.frontend.app')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('cart.update') }}" method="post">
                        @csrf
                        <div class="shop__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['carts'] as $carts)
                                        <tr>
                                            <td class="cart__product__item">
                                                <img src="{{ asset($carts->Product->thumbnails_path) }}" alt="" width="90">
                                                <div class="cart__product__item__title">
                                                    <h6>{{ $carts->Product->name }}</h6>
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__price">{{ $carts->Product->price_rupiah }}</td>
                                            <input type="hidden" name="cart_id[]" value="{{ $carts->id }}">
                                            <td class="cart__quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="{{ $carts->qty }}" name="cart_qty[]">
                                                </div>
                                            </td>
                                            <td class="cart__total">{{ rupiah($carts->total_price_per_product) }}</td>
                                            <td class="cart__close"><a href="{{ route('cart.delete', $carts->id) }}"><span class="icon_close"></span></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="{{ route('product.index') }}">Tambah Produk Baru</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn">
                        <button type="submit"><span class="icon_loading"></span> Update Keranjang</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6"></div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Total Keranjang</h6>
                        <ul>
                            <li>Total <span>{{ rupiah($data['carts']->sum('total_price_per_product')) }}</span></li>
                        </ul>
                        <a href="{{ route('checkout.index') }}" class="success-btn" id="checkout-button">Lanjutkan ke pembayaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <!-- JavaScript untuk menangani tombol checkout -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkoutButton = document.getElementById('checkout-button');
            const cartItems = @json($data['carts']); // Mengambil data keranjang dari server-side
            
            checkoutButton.addEventListener('click', function (event) {
                if (cartItems.length === 0) { // Mengecek apakah keranjang kosong
                    event.preventDefault(); // Mencegah navigasi ke halaman checkout
                    alert("Oops! Kamu belum memiliki barang untuk dicheckout, lakukan pembelian terlebih dahulu :)");
                }
            });
        });
    </script>
