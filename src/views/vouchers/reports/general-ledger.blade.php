@extends('layouts.app')
@section('title', trans('vouchers.page-title'))
@section('css')
    <style type="text/css">
        .genernal_ledger .pull-left {
            width: 150px;
        }

        .padding-left {
            padding-left: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid container-fullw bg-white">
        <div class="pull-right">
            <a class="download btn margin-bottom-5 pull-right btn-wide btn-o btn-primary" download="download">
                <i class="fa fa-download" aria-hidden="true"></i>
            </a>
        </div>
        {!! Form::open(['route' => 'voucher.glDownload','method' => 'GET', 'id'=>'downloads']) !!}
            <input type="hidden" name="date_from" value="{{request()->date_from}}">
            <input type="hidden" name="date_to" value="{{request()->date_to}}">
            <input type="hidden" name="from_account_code" value="{{request()->from_account_code}}">
            <input type="hidden" name="to_account_code" value="{{request()->to_account_code}}">
        {!! Form::close() !!}

        @include('vouchers.partials._gl')

    </div>


@endsection


@section('page-scripts')

    <script>

        $(document).on('click' ,'.download' , function (e) {

            e.stopPropagation();

            $('#downloads').submit();

        });

    </script>
@endsection