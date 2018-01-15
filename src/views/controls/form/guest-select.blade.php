{!! Form::select($name,
            $list,
            isset($selected) ? $selected : old($name),
            array_merge(
                [
                'id'=>isset($id) ? $id : 'fc-'.$name ,
                'placeholder'=>trans($trans.'.'.$name),
                'class'=>'form-control form-control-solid placeholder-no-fix form-group '.($errors->has($name) ? 'has-error' : ''),
                'style' => 'height: 38px;'
                ],
                isset($options) ? $options : []
            )
        ) !!}
@if ($errors->has($name))
    <span id="{{$name}}-error" class="help-block">{{ $errors->first($name) }}</span>
@endif