@extends('layouts.backend.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $data['voucher']->code }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('master.voucher.edit', $data['voucher']->id) }}" class="btn btn-success">{{ __('button.edit') }}</a>
                        <a href="{{ route('master.voucher.index') }}" class="btn btn-primary">{{ __('button.back') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <td>{{ __('field.code') }}</td>
                                    <td>: {{ $data['voucher']->code }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('field.discount') }}</td>
                                    <td>: {{ $data['voucher']->discount }}%</td>
                                </tr>
                                <tr>
                                    <td>{{ __('field.expiration_date') }}</td>
                                    <td>: {{ \Carbon\Carbon::parse($data['voucher']->expiration_date)->format('d-m-Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
