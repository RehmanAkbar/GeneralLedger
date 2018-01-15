<div class=" {{ isset($size) ? $size : 'form-group' }}{{ $errors->has($name) ? ' has-error' : '' }}">

    @if(!isset($noLabel))

    <label  class="control-label col-sm-{{ isset($options['label-size']) ? $options['label-size'] : '4' }}">{{ isset($label) ? $label : trans($trans.'.'.$name) }} @if(isset($options) && array_key_exists('required', $options))

        <span class="symbol required"></span>
    @endif</label>
    @endif
    
<div class="col-sm-{{ isset($options['field-size']) ? $options['field-size'] : '8' }}">

    {!! Form::select($name, $list,isset($selected) ? $selected : old($name),array_merge(['id'=>isset($id) ? $id : 'fc-'.$name ,'class'=>'form-control  '.$name], isset($options) ? $options : [])) !!}
</div>
    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
