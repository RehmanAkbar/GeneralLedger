@extends('layouts.app')
@section('title', trans('vouchers.page-title'))
@section('css')
    @include('vouchers.partials._listing_styles')
    @include('vouchers.partials._media_styles')
@endsection

@section('content')
    <div class="container-fluid container-fullw bg-white">
        <div class="row">
            <div class="col-md-4">
                {{ $vouchers->appends(Request::except('page'))->links('vendor.pagination.simple-default' ,['paginate' => $paginate]) }}
            </div>
            <div class="pull-right">
                <a class="download btn margin-bottom-5 pull-right btn-wide btn-o btn-primary" download="download">
                    <i class="fa fa-download" aria-hidden="true"></i>
                </a>
            </div>

        </div>
        {!! Form::open(['route' => 'download.vouchers','method' => 'GET' ,'class' => 'form-horizontal', 'id'=>'downloads']) !!}
            <input type="hidden" name="from_date" value="{{request()->from_date}}">
            <input type="hidden" name="to_date" value="{{request()->to_date}}">
            <input type="hidden" name="voucher_type_id" value="{{request()->voucher_type_id}}">
        {!! Form::close() !!}

        @foreach($vouchers as $voucher)
            @include('vouchers.partials._voucher')
        @endforeach
    </div>


@endsection


@section('page-scripts')

    <script>


        $(document).on('click' ,'.download' , function (e) {

            e.stopPropagation();

            $('#downloads').submit();

        });

        $(function(){
            $("#paginate").on('change' , function(){

                $('form[name=paginate_form]').submit();

            });
        })
    </script>
@endsection