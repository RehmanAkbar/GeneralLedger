@extends('layouts.pdf')

@section('css')
    @include('vouchers.partials._pdf_styles')
    @include('vouchers.partials._trial_balance_style')
@endsection

@section('content')
    <div class="container-fluid container-fullw bg-white" xmlns="http://www.w3.org/1999/html">
        <h3>Trial Balance</h3>

        @include('vouchers.partials._trial_balance')
    </div>

@endsection