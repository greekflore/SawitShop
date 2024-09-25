@extends('layouts.frontend.app')
@section('content')

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{ route('transaction.index') }}"> Transaction</a>
                        <span>{{ $data['order']->invoice_number }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice" style="border-top: 2px solid #28a745;">
                        <div class="invoice-print">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="invoice-title">
                                        <h2>Invoice</h2>
                                        <div class="invoice-number">Order {{ $data['order']->invoice_number }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address>
                                                <strong>{{ __('text.billed_to') }}:</strong><br>
                                                {{ $data['order']->Customer->name }}<br>
                                                {{ $data['order']->Customer->email }}<br>
                                            </address>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <address>
                                                <strong>{{ __('text.shipped_to') }}:</strong><br>
                                                {{ $data['order']->recipient_name }}<br>
                                                {{ $data['order']->address_detail }}<br>
                                                {{ $data['order']->destination }}
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address>
                                                <strong>{{ __('text.order_status') }}:</strong>
                                                <div class="mt-2">
                                                    {!! $data['order']->status_name !!}
                                                </div>
                                            </address>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <address>
                                                <strong>{{ __('text.order_date') }}:</strong><br>
                                                {{ $data['order']->created_at }}<br><br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="section-title font-weight-bold">{{ __('text.order_summary') }}</div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-md">
                                            <tbody>
                                                <tr>
                                                    <th data-width="40" style="width: 40px;">#</th>
                                                    <th>{{ __('field.product_name') }}</th>
                                                    <th class="text-center">{{ __('field.price') }}</th>
                                                    <th class="text-center">{{ __('text.quantity') }}</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                                @foreach ($data['order']->orderDetail()->get() as $detail)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><a
                                                                href="{{ route('product.show', ['categoriSlug' => $detail->Product->category->slug, 'productSlug' => $detail->Product->slug]) }}">{{ $detail->product->name }}</a>
                                                        </td>
                                                        <td class="text-center">{{ rupiah($detail->product->price) }}
                                                        </td>
                                                        <td class="text-center">{{ $detail->qty }}</td>
                                                        <td class="text-right">
                                                            {{ rupiah($detail->total_price_per_product) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-8">
                                            <address>
                                                <strong>{{ __('text.shipping_method') }}:</strong>
                                                <div class="mt-2">
                                                    <p class="section-lead text-uppercase">{{ $data['order']->courier }}
                                                        {{ $data['order']->shipping_method }}</p>
                                                </div>
                                            </address>
                                            @if ($data['order']->receipt_number != null)
                                                <address>
                                                    <strong>{{ __('text.receipt_number') }}:</strong>
                                                    <div class="mt-2">
                                                        <p class="section-lead text-uppercase">
                                                            {{ $data['order']->receipt_number }}</p>
                                                    </div>
                                                </address>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 text-right">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Subtotal</div>
                                                <div class="invoice-detail-value">{{ rupiah($data['order']->subtotal) }}
                                                </div>
                                            </div>
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">{{ __('text.shipping_cost') }}</div>
                                                <div class="invoice-detail-value">
                                                    {{ rupiah($data['order']->shipping_cost) }}</div>
                                            </div>
                                            <hr class="mt-2 mb-2">
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Total</div>
                                                <div class="invoice-detail-value invoice-detail-value-lg">
                                                    {{ rupiah($data['order']->total_pay) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-md-right">
                            <div class="float-lg-left mb-lg-0 mb-3">
                                @if ($data['order']->status == 0)
                                    <button class="btn btn-success btn-icon icon-left" id="pay-button"><i
                                            class="fa fa-credit-card"></i>
                                        Process Payment</button>
                                    <a href="{{ route('transaction.canceled', $data['order']->invoice_number) }}" class="btn btn-danger btn-icon icon-left"><i class="fa fa-times"></i>
                                        Cancel Order</a>
                                @elseif ($data['order']->status == 2)
                                    <a href="{{ route('transaction.received', $data['order']->invoice_number) }}"
                                        class="btn btn-success text-white btn-icon icon-left"><i
                                            class="fa fa-credit-card"></i>
                                        Order Received</a>
                                @endif
                            </div>
                            <button class="btn btn-warning btn-icon icon-left"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h4 class="card-title">Order Track</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="activities">
                                        @foreach ($data['order']->OrderTrack()->get() as $orderTrack)
                                            <div class="activity">
                                                <div class="activity-icon bg-success text-white shadow-success">
                                                    <i class="{{ $orderTrack->icon }}"></i>
                                                </div>
                                                <div class="activity-detail bg-success text-white">
                                                    <div class="mb-2">
                                                        <span class="text-job text-white">{{ $orderTrack->created_at->diffForHumans() }}</span>
                                                        <span class="bullet"></span>
                                                    </div>
                                                    <p>{{ __($orderTrack->description) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($data['order']->status == '3') 
    <section>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h4 class="card-title">Write a Review</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($data['order']->orderDetail as $detail) <!-- Pastikan relasi ini benar -->
                            <form action="{{ route('reviews.store', $detail->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="rating">Rating</label>
                                    <select  name="rating" class="form-control fas fa-star text-warning" required>
    <option class="fas fa-star text-warning" value="5">★★★★★ - Sangat Baik</option>
    <option class="fas fa-star text-warning" value="4">★★★★☆ - Baik</option>
    <option class="fas fa-star text-warning" value="3">★★★☆☆ - Cukup</option>
    <option class="fas fa-star text-warning" value="2">★★☆☆☆ - Kurang</option>
    <option class="fas fa-star text-warning" value="1">★☆☆☆☆ - Sangat Kurang</option>
</select>

                                </div>
                                <div class="form-group">
                                    <label for="review_text">Your Review</label>
                                    <textarea name="comment" class="form-control" rows="4"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Submit Review</button>
                            </form>
                            <!-- Display reviews for each product -->
                            @if($detail->reviews->count() > 0)
                                @foreach ($detail->reviews as $review)
                                    <div class="card mt-3">
                                    <div class="card-body d-flex align-items-center">
        <!-- Gambar Profile User -->
        <img alt="image" src="{{ asset('stisla') }}/img/avatar/avatar-2.png" class="rounded-circle mr-3" style="width: 50px; height: 50px; object-fit: cover; margin-top:-40px;">

        <!-- Nama User dan Rating/Review -->
        <div>
                                        <div class="card-body">
                                        <!-- <h5 class="card-title">Ulasan Ke: {{ $review->rating }}</h5> -->

                                        <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                        <p class="mb-1">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $review->rating)
                        <i class="fas fa-star text-warning"></i> <!-- Bintang penuh -->
                    @else
                        <i class="far fa-star text-warning"></i> <!-- Bintang kosong -->
                    @endif
                @endfor
            </p>
                                            <p class="card-text mb-1">{{ $review->comment }}</p>
                                            <p class="text-muted mb-0">Reviewed on {{ $review->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No reviews yet.</p>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
@endsection


@push('js')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $data['order']->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    console.log(result)
                },
                onPending: function(result) {
                    console.log(result)
                },
                onError: function(result) {
                    console.log(result)
                }
            });
        });
    </script>
@endpush
