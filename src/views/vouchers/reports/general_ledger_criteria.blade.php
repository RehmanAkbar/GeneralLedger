@extends('layouts.app')
@section('title', trans('vouchers.page-title'))
@section('css')

@endsection

@section('content')
    @pageTitle('trans'=>'vouchers','title'=>'General Ledger','description'=>'Voucher Printing',
    'breadcrumb'=>[trans('accounts.general-ledger'),trans('vouchers.reports'),trans('vouchers.general_ledger')],
    'buttons'=> []
    )

    <div class="container-fluid container-fullw bg-white">
        <div class="row">
            <div class="col-md-4 col-md-offset-3">
                <h3>General Ledger</h3>
                {!! Form::open(['action' => 'VouchersController@generalLedgerPreview', 'method' => 'GET', 'id'=>'vouchers-form']) !!}

                @include('vouchers.partials._criteria_fields')

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

            function matchStart(params, data) {

                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }
                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                    return null;
                }

                //starts with search
                if (data.text.startsWith(params.term)) {
                    var modifiedData = $.extend({}, data, true);
                    //  modifiedData.text += ' (matched)';

                    return modifiedData;
                }

                return null;
            }

            $("#fc-from_account_code").select2({ matcher: matchStart});
            $("#fc-to_account_code").select2({ matcher: matchStart});

        });

    </script>
@endsection