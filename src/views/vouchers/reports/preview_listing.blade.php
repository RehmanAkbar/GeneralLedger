@extends('layouts.app')
@section('title', trans('vouchers.page-title'))
@section('css')
    @include('vouchers.partials._listing_styles')
    <style>
        @media print{
            .hide_print{
                display: none;
            }
            #app > footer{
                display: none;
            }
            .container-fullw{
                padding-top: 0;
            }
            .text-center{
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid container-fullw bg-white">
        <div class="text-right">
            <a style="margin-left:5px" onclick="window.print();" class="hide_print btn margin-bottom-5 pull-right btn-wide btn-o btn-primary" href="javascript:void(0)">
                <i class="ti-printer" aria-hidden="true"></i>
            </a>

            <a class="hide_print btn margin-bottom-5 pull-right btn-wide btn-o btn-primary" href="#">
                <i class="fa fa-download" aria-hidden="true"></i>
            </a>
        </div>

        @foreach($vouchers as $voucher)
            <h2>{{($voucher['company']->name)}}</h2>

            <h5>{{$voucher['office']->address}}</h5>
            <h4>Transaction Listing</h4>

            <div class="col-md-2">
                <p>Date From:</p>
            </div>
            <div class="col-md-2">
                <p>{{request()->from_date}}</p>
            </div>
            <div class="col-md-2">
                <p>Date To:</p>
            </div>
            <div class="col-md-2">
                <p>{{request()->to_date}}</p>
            </div>
            @include('vouchers.partials._listing')

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