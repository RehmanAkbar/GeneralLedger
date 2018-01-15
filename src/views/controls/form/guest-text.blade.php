{!! Form::text($name,
            isset($value) ? $value : old($name),
            array_merge(
                [
                'id'=>isset($id) ? $id : 'fc-'.$name ,
                'placeholder'=>trans($trans.'.'.$name),
                'class'=>'form-control form-control-solid placeholder-no-fix form-group '.(isset($class) ? $class : '').' '.($errors->has($name) ? 'has-error' : ''),

                ],
                isset($options) ? $options : []
            )
        ) !!}
@if ($errors->has($name))
    <span id="{{$name}}-error" class="help-block">{{ $errors->first($name) }}</span>
@endif