@select('name'=>'voucher_type_id','trans'=>'vouchers','list'=>$voucherTypes,'options'=>['required' => 'required', 'class' =>'js-example-basic-multiple js-states form-control'])

@text('name'=>'voucher_code','trans'=>'vouchers','options'=>['required' => 'required'])

@textarea('name'=>'remarks','trans'=>'vouchers','options'=>[])
