<div class="pull-left">
    <h5 style="margin-top: 0;">{{ auth()->user()->company->name }}</h5>
    <h6>{{ auth()->user()->office->name }}</h6>
</div>
<div class="clear30"></div>
<div class="genernal_ledger">
    <div class="col-md-2">
        <p>Account From:</p>
    </div>
    <div class="col-md-2">
        <p>{{$criteria['account_from']}}</p>
    </div>
    <div class="col-md-2">
        <p>Account To:</p>
    </div>
    <div class="col-md-2">
         <p>{{$criteria['account_to']}}</p>
    </div>
    <div class="clear"></div>
    <div class="col-md-2">
        <p>Date From:</p>
    </div>
    <div class="col-md-2">
        <p>{{$criteria['date_from']}}</p>
    </div>
    <div class="col-md-2">
        <p>Date To:</p>
    </div>
    <div class="col-md-2">
        <p>{{$criteria['date_to']}}</p>
    </div>
</div>
<div class="clear10"></div>
<table class="table trial_blance">
    <thead>
    <tr>
        <th rowspan="2">Account No</th>
        <th rowspan="2">Account Name</th>
        <th rowspan="2" class="text-right">Opening Balance</th>
        <th colspan="2" class="text-center">For The Period</th>
        <th rowspan="2" class="text-right   ">Balance</th>
    </tr>
    <tr>
        <th class="text-right">Debit</th>
        <th class="text-right">Credit</th>
    </tr>
    </thead>

    <tbody>
    @foreach($accountsDetails as $account)
        <tr>

            <td>{{$account->code}}</td>
            <td>{{$account->description}}</td>
            <td class="text-right">{{$openingBalance = $account->openingBalance(request('from_date'))}}</td>
            <td class="text-right">{{$account['voucherDetails']->sum('debit')}}</td>
            <td class="text-right">{{$account['voucherDetails']->sum('credit')}}</td>
            <td class="text-right">{{$openingBalance + ($account['voucherDetails']->sum('debit') - $account['voucherDetails']->sum('credit'))}}</td>
        </tr>
    @endforeach
    </tbody>
</table>