<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">

    <label class="control-label col-sm-{{ isset($options['label-size']) ? $options['label-size'] : '4' }}">{{  trans($trans.'.'.$name) }} @if(isset($options) && array_key_exists('required', $options))<span class="symbol required"></span>@endif</label>
    <div class="col-sm-{{ isset($options['label-size']) ? $options['field-size'] : '8' }}">

        @if(isset($icon))
            <span class="input-icon">
            {!! Form::password($name,array_merge(['id'=>isset($id) ? $id : 'fc-'.$name ,'placeholder'=>trans($trans.'.'.$name),'class'=>'form-control '.$name],$options)) !!}
                    <i class="fa fa-lock"></i>
            </span>
        @else
            {!! Form::password($name,array_merge(['id'=>isset($id) ? $id : 'fc-'.$name ,'placeholder'=>trans($trans.'.'.$name),'class'=>'form-control '.$name],$options)) !!}
        @endif
    </div>
    @if ($errors->has($name))

        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>

    @endif

</div>

