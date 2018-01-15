@extends('layouts.app')
@section('title', trans('vouchers.page-title'))
@section('css')

@endsection

@section('content')
    @pageTitle('trans'=>'vouchers','title'=>'Transaction Listing','description'=>'Voucher Printing',
    'breadcrumb'=>[trans('accounts.general-ledger'),trans('vouchers.reports'),trans('vouchers.listing')],
    'buttons'=> []
    )

    <div class="container-fluid container-fullw bg-white">
        <div class="row">
            <div class="col-md-4 col-md-offset-3">
                <h3>Transaction Listing</h3>
                {!! Form::open(['route' => 'voucher.preview_listing','method' => 'GET' ,'class' => '', 'id'=>'vouchers-form']) !!}

                @select('name'=>'voucher_type_id','trans'=>'vouchers','list'=>$voucherTypes,'options'=>['label-size'=>'', 'field-size'=>' ','required' => 'required', 'class' =>'js-example-basic-multiple js-states form-control'])
                <div class=" form-group">
                    <label class="control-label">Date From</label>
                    <div class='input-group date'>
                        <input type='text' id="from-date"  name="from_date" class="form-control" />
                        <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                    </div>
                </div>
                <div class=" form-group">
                    <label class="control-label">Date To</label>
                    <div class='input-group date'>
                        <input type='text' id="to-date"  name="to_date" class="form-control" />
                        <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-2">
                        {!! Form::submit('Preview', ['class' => 'btn btn-primary btn-wide pull-right']) !!}
                    </div>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>

@endsection


@section('page-scripts')

    <script>
        $(function(){


            $("#from-date").datepicker({
                autoClose: true,
                todayHighlight: true,

            });
            $("#from-date").datepicker('setDate', new Date());
            $("#to-date").datepicker({
                todayHighlight: true,

            });
            $("#to-date").datepicker('setDate', new Date());
        })


    </script>
@endsection