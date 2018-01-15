@extends('layouts.app')
@section('title', trans('vouchers.page-title'))
@section('css')

    @include('vouchers.partials._media_styles')

@endsection


@section('content')
    <div class="container-fluid container-fullw bg-white">
        @include('vouchers.partials._voucher')
    </div>
@endsection