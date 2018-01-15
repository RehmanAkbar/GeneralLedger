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

@select('name'=>'from_account_code','trans'=>'vouchers','list'=>$accounts->sortBy('code')->pluck('code','code'),'options'=>['required' => 'required', 'class' =>'js-example-basic-multiple js-states form-control','label-size' => ' ', 'field-size' => ' '])
@select('name'=>'to_account_code','trans'=>'vouchers','list'=>$accounts->sortBy('code')->pluck('code','code'),'options'=>['required' => 'required', 'class' =>'js-example-basic-multiple js-states form-control','label-size' => ' ', 'field-size' => ' '])
