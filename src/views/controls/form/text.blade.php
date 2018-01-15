<div class=" form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if(!isset($noLabel))
    <label class="control-label col-sm-{{ isset($options['label-size']) ? $options['label-size'] : '4' }}">{{ isset($label) ? $label : trans($trans.'.'.$name) }} @endif @if(isset($options) && array_key_exists('required', $options))<span class="symbol required"></span>@endif</label>
    <div class="col-sm-{{ isset($options['label-size']) ? $options['field-size'] : '8' }}">
        @if(isset($icon))
        <span class="input-icon">
            {!! Form::text($name,
                isset($value) ? $value : old($name),
                array_merge(
                    ['id'=>isset($id) ? $id : 'fc-'.$name ,'placeholder'=>trans($trans.'.'.$name),'class'=>'form-control '.(isset($class) ? $class : '')],
                    isset($options) ? $options : []
                )
            ) !!}
            <i class="fa fa-{{ $icon }}"></i>
        </span>
        @else
            {!! Form::text($name,
                isset($value) ? $value : old($name),
                array_merge(
                    ['id'=>isset($id) ? $id : 'fc-'.$name ,'placeholder'=>trans($trans.'.'.$name),'class'=>'form-control '.(isset($class) ? $class : '')],
                    isset($options) ? $options : []
                )
            ) !!}
        @endif
    </div>
    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
