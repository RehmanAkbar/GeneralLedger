@extends('layouts.app')
@section('title', trans('accounts.page-title'))
@section('css')

@endsection

@section('content')


<div class="container-fluid container-fullw bg-white">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="opening_balance">
                    <thead>
                        <tr>
                            <h2 class="text-center">Opening Balance</h2>
                        </tr>
                        <tr>
                            <td style="border-right: none">
                                <form name="search_account" action="{{route('getAccount')}}" action="GET">
                                    <input class="form-control" placeholder="search account" type="text" id="searchAccount" name="account" >
                                </form>
                            </td>
                            <td style="border-right: none" colspan="2"></td>
                            <td>
                                <button id="save-balance" type="button" class="btn btn-wide btn-success pull-right">Save</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right" >Total:</td>
                            <td >
                                <div class="col-sm-8">
                                    <input  type="text" data-debit="{{$accounts->sum('open_debit')}}" value="{{$accounts->sum('open_debit')}}" class="form-control" id="totalDebit">
                                </div>
                            </td>
                            <td >
                                <div class="col-sm-8">
                                    <input type="text" data-credit="{{$accounts->sum('open_credit')}}" value="{{$accounts->sum('open_credit')}}" class="form-control" id="totalCredit">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Account Code</th>
                            <th>Account Description</th>
                            <th>Open Debit</th>
                            <th>Open Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                            <tr class="account" data-account_id="{{$account->id}}" >
                                <td>{{$account->code}}</td>
                                <td>{{$account->description}}</td>
                                <td>
                                    <div class="col-sm-8">
                                        <input type="text" data-type="debit" value="{{$account->open_debit}}" class="debit form-control">
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-8">
                                        <input type="text" data-type="credit" value="{{$account->open_credit}}" class="credit form-control">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection


@section('page-scripts')

    <script type="text/javascript" >

        var totalCredit = 0;
        var totalDebit  = 0;

        totalDebit  = ($("#totalDebit").data('debit')) ? parseInt($("#totalDebit").data('debit'), 10) : 0;
        totalCredit = ($("#totalCredit").data('credit')) ? parseInt($("#totalCredit").data('credit') , 10) : 0;

        $("#save-balance").on('click' , function(){

            var accounts = [];
            $('.account').each(function(i, el) {

                var param = {};

                param.id          = $(this).data('account_id');
                param.open_debit  = $(this).find('.debit').val();
                param.open_credit = $(this).find('.credit').val();

                accounts[i] = param;
            });

            if(totalDebit != totalCredit){

                swal({
                    text: "Please Balance Debit or Credit!",
                });

                return false;

            }


            $.ajax({
                url: "{{route('save_opening_balance')}}",
                type: 'POST',
                data: {accounts:accounts},
                error: function (response) {
                    swal({
                        icon: "error",
                    });
                },
                success: function(response) {

                    swal({
                        icon: "success",
                    });

                },
            });

        });

        $(function(){

            function updateTotalDebitCreditBalance()
            {
                totalDebit = 0;
                totalCredit = 0;

                $("#totalDebit").val("");
                $("#totalCredit").val("");

                $("#opening_balance tr.account").each(function (ix, tr) {

                    var value = $(this).find('.debit').val();
                    totalDebit  += parseValue($(this).find('.debit').val());
                    totalCredit += parseValue($(this).find('.credit').val());

                });

                {{--  var difference = (totalCredit - totalDebit);
                var amount     = Math.abs(difference);
                (difference > 0) ? $("#debitInput").val(amount) : $("#creditInput").val(amount);    --}}

                $("#totalDebit").val(totalDebit);
                $("#totalCredit").val(totalCredit);

            }

            

            function parseValue(value)
            {
                if(value)
                {
                    return parseInt(value,10);                
                }
                return 0;
            }

            $('.debit, .credit').on('focusout' , function(event){
            
                var $this  = $( this );
                var type   = $this.data('type');
                var amount = $this.val();
                
                if(amount > 0){
                    if ( type == 'debit' ) {
                        
                        $this.closest('td').next().find('.credit').val(0);

                    }else if(type ==  'credit'){
                    
                        $this.closest('td').prev().find('.debit').val(0);

                    }

                    updateTotalDebitCreditBalance();
                }
            })

            $('#searchAccount').keypress(function(e){
                if(e.which == 13){

                    $('form[name=search_account]').submit();
                }
            });
        })

    </script>

@endsection