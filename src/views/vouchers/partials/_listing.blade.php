<div class="listing">
<div class="clearfix"></div>
<ul class="trans_lisiting">
    <li>Code</li>
    <li>Account Title</li>
    <li>Narration</li>
    <li class="text-right">Debit</li>
    <li class="text-right">Credit</li>
</ul>
<div class="voucher_area">
    <h6 class="margin-top-10 margin-bottom-20"> <STRONG> <u>{{$voucher['type']->description}}</u></STRONG></h6>
    <span><strong>Voucher No.</strong></span>
    <span class="padding-left-30">
     {{$voucher->voucher_code}}
     </span>
     <span class="padding-left-50"><strong>Date</strong></span>
        <span class="padding-left-30">
     {{$voucher->voucher_date}}
     </span>
     <hr>
</div>
     @foreach($voucher['details'] as $detail)
        <ul class="trans_lisiting listing_details">
          <li> {{$detail['account']->code }}</li>
           <li>{{$detail['account']->description }}</li>
           <li>{{$detail->narration}}</li>
           <li class="text-right">{{number_format($detail->debit, 2, '.', ',')}}</li>
           <li class="text-right">{{number_format($detail->credit, 2, '.', ',')}}</li>
        </ul>
    @endforeach
   <div class="sub_total_hr">
      <div class="clearfix"></div>
      <hr>
    </div>
   <ul class="trans_lisiting listing_details sub_total">
      <li> </li>
      <li> </li>
      <li> </li>
      <li class="text-right"><strong>Sub Total:</strong></li>
      <li class="text-right" style="margin-right: 40px !important;">{{number_format($voucher['details']->sum('debit'), 2, '.', ',')}}</li>
      <li class="text-right">{{number_format($voucher['details']->sum('credit'), 2, '.', ',')}}</li>
   </ul>

</div>