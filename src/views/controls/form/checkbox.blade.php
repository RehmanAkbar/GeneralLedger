<div class="clip-check check-primary  {{ isset($size) ? $size : '' }}   {{ $errors->has($name) ? ' has-error' : '' }}" style="{{ isset($style) ? $style : '' }}">
    {!! Form::checkbox($name,isset($value) ? $value : 1,isset($checked) ? $checked: null,array_merge(['id'=>isset($id) ? $id : 'fc-'.$name], isset($options) ? $options : [])) !!}
    <label for="fc-{{ $name }}" title="{{ isset($title) ? $title : '' }}">
        {{ isset($label) ? $label : (isset($trans) ? trans($trans.'.'.$name) : '') }}
    </label>
</div>

