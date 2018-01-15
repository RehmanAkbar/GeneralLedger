<div class="container-fluid container-fullw bg-white">
    <h3>General Ledger</h3>
    {{--<div class="pull-right">
        <a class="download btn margin-bottom-5 pull-right btn-wide btn-o btn-primary" download="download">
            <i class="fa fa-download" aria-hidden="true"></i>
        </a>
    </div>--}}
    <div class="pull-left">
        <h5 style="margin-top: 0;">{{ auth()->user()->company->name }}</h5>
        <h6>{{ auth()->user()->office->name }}</h6>
    </div>
    <div class="clear30"></div>
    <div class="genernal_ledger">
        <div class="col-md-4">
            <p class="pull-left">Account From:</p> <span>{{$criteria['account_from']}}</span>
            <div class="clearfix"></div>
            <p class="pull-left">Account To:</p> <span>{{$criteria['account_to']}}</span>
        </div>
        <div class="col-md-4">
            <p class="pull-left">Date From:</p> <span>{{$criteria['date_from']}}</span>
            <div class="clearfix"></div>
            <p class="pull-left">Date To:</p> <span>{{$criteria['date_to']}}</span>
        </div>
    </div>
    <div class="clearfix"></div>
    <table class="table table-bordered">
        <tr>
            <td>Date</td>
            <td>Voucher</td>
            <td>Narration</td>
            <td>Debit</td>
            <td>Credit</td>
            <td>Balance</td>
        </tr>
        @foreach($accountsDetails as $account)
            <tr>
                <td colspan="5">{{ $account->code }} - {{ $account->description }}</td>
                <td style="text-align:right;">{{number_format($account['balance'] = $account->openingBalance(request('from_date')))  }}</td>
            </tr>
            @foreach($account['voucherDetails']->sortBy('voucher.voucher_date') as $transaction)
                <tr>
                    <td>{{ $transaction['voucher']->voucher_date->format('d-m-Y') }}</td>
                    <td>{{ $transaction['voucher']->voucher_code }}</td>
                    <td>{{ $transaction->narration }}</td>
                    <td style="text-align:right;">{{number_format( $transaction->debit )}}</td>
                    <td style="text-align:right;">{{ number_format($transaction->credit) }}</td>
                    <td style="text-align:right;">{{ number_format($account['balance']=$account['balance']+($transaction->debit - $transaction->credit)) }}</td>

                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align:right;">Total:</td>
                <td style="text-align:right;">{{ number_format($account['voucherDetails']->sum('debit')) }}</td>
                <td style="text-align:right;">{{ number_format($account['voucherDetails']->sum('credit')) }}</td>
                <td></td>
            </tr>
        @endforeach
        {{--<tr>
            <td colspan="3" style="text-align:right;">Grand Total:</td>
            <td style="text-align:right;">{{ number_format($accountsDetails->sum('%.debit')) }}</td>
            <td style="text-align:right;">{{ number_format($accountsDetails->sum('%.credit')) }}</td>
            <td></td>
        </tr>--}}
    </table>
</div>
