<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">

    <label class="control-label col-sm-{{ isset($options['label-size']) ? $options['label-size'] : '4' }}">{{ trans($trans.'.'.$name) }}</label>@if(isset($options) && array_key_exists('required', $options))<span class="symbol required"></span>@endif
    <div class="col-sm-{{ isset($options['label-size']) ? $options['field-size'] : '8' }}">
    @if(isset($icon))
        <span class="input-icon">
        {!! Form::textarea($name,
            isset($value) ? $value : old($name),
            array_merge(
                ['id'=>isset($id) ? $id : 'fc-'.$name ,'placeholder'=>trans($trans.'.'.$name),'class'=>'form-control', 'rows' => 5],
                isset($options) ? $options : []
            )
        ) !!}
            <i class="fa fa-{{ $icon }}"></i>
    </span>
    @else
        {!! Form::textarea($name,
            isset($value) ? $value : old($name),
            array_merge(
                ['id'=>isset($id) ? $id : 'fc-'.$name ,'placeholder'=>trans($trans.'.'.$name),'class'=>'form-control', 'rows' => 5],
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


{{--<div class="{{ isset($column) ? $column : 'col-sm-6'}}">--}}
    {{--<div class="form-group">--}}
        {{--<label class="control-label">{{ $label }}</label>--}}
        {{--<div class="append-icon">--}}
            {{--{!! Form::textarea($name, isset($value) ? $value : old($name),array_merge(['id'=>isset($id) ? $id : 'fc-'.$name ,'class'=>'form-control '.$name],$options)) !!}--}}
            {{--<i class="{{ isset($icon) ? $icon : '' }}"></i>--}}
            {{--<span class="form-error"></span>--}}
        {{--</div>--}}

    {{--</div>--}}
{{--</div>--}}