@extends('layouts.pdf')

@section('css')
    @include('vouchers.partials._pdf_styles')
@endsection

@section('content')
    <div class="container-fluid container-fullw bg-white" xmlns="http://www.w3.org/1999/html">

        @include('vouchers.partials._gl')
    </div>

@endsection