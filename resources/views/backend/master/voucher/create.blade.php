@extends('layouts.backend.app')
@section('content')
    <div class="row">
        <div class="col-12">
            @component('components.backend.card.card-form')
                @slot('isfile', true)
                @slot('action', route('master.voucher.store')) <!-- Adjust the route to the correct one for vouchers -->
                @slot('method', 'POST')
                @slot('content')

                    <x-forms.input name="code" id="code" :label="__('field.voucher_code')" :isRequired="true" />
                    
                    <x-forms.input type="number" name="discount" id="discount" :label="__('field.discount_amount')" :isRequired="true" />
                    
                    <x-forms.input type="date" name="expiration_date" id="expiration_date" :label="__('field.expiry_date')" :isRequired="true" />

                    <div class="text-right">
                        <a href="{{ route('master.voucher.index') }}" class="btn btn-secondary">{{ __('button.cancel') }}</a>
                        <button type="submit" class="btn btn-success">{{ __('button.save') }}</button>
                    </div>

                @endslot
            @endcomponent
        </div>
    </div>
@endsection
