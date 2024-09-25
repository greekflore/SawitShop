@extends('layouts.backend.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @component('components.backend.card.card-table')
                @slot('header')
                    <h4 class="card-title">{{ __('menu.voucher') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.voucher.create') }}" class="btn btn-primary">{{ __('button.add') }}
                            {{ __('menu.voucher') }}</a>
                    </div>
                @endslot
                @slot('thead')
                    <tr>
                        <th>{{ __('field.voucher_code') }}</th>
                        <th>{{ __('field.discount_amount') }}</th>
                        <th>{{ __('field.expiry_date') }}</th>
                        <th>{{ __('field.created_at') }}</th>
                        <th>{{ __('field.action') }}</th>
                    </tr>
                @endslot
                @slot('tbody')
                    @foreach ($data['vouchers'] as $voucher)
                        <tr>
                            <td>{{ $voucher->code }}</td>
                            <td>{{ $voucher->discount }}</td> <!-- Change to the correct field name -->
                            <td>{{ $voucher->expiration_date }}</td> <!-- Change to the correct field name -->
                            <td>{{ tanggal($voucher->created_at) }}</td>
                            <td>
                                <x-button.dropdown-button :title="__('field.action')">
                                    <a class="dropdown-item has-icon" href="{{ route('master.voucher.edit', $voucher->id) }}"><i class="far fa-edit"></i>
                                        {{ __('button.edit') }}</a>
                                    <a class="dropdown-item has-icon" href="{{ route('master.voucher.show', $voucher->id) }}"><i class="far fa-eye"></i>
                                        {{ __('button.detail') }}</a>
                                    <a class="dropdown-item has-icon btn-delete" href="{{ route('master.voucher.delete', $voucher->id) }}"><i class="fa fa-trash"></i>
                                        {{ __('button.delete') }}</a>
                                </x-button.dropdown-button>
                            </td>
                        </tr>
                    @endforeach
                @endslot
            @endcomponent
        </div>
    </div>
@endsection
