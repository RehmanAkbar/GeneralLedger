<div class="row {{ isset($column) ? $column : 'col-sm-12'}}">
    <label for="{{ $name }}" class="control-label">{{ $label }}</label>
    <div class="clip-radio radio-primary">
        @foreach($list as $radio)
            {!! Form::radio($name, isset($radio['value']) ? $radio['value'] : old($name),isset($radio['checked']) ? $radio['checked'] : false,array_merge(['id'=>$name.'_'.$loop->index],$options)) !!}
            <label for="{{ $name.'_'.$loop->index }}" >
                {{ $radio['text'] }}
            </label>
        @endforeach
    </div>
</div>

{{--<div class="{{ isset($column) ? $column : 'col-sm-6'}}">--}}
    {{--<div class="form-group">--}}
        {{--<label for="{{ $name }}" class="control-label">{{ $label }}</label>--}}
        {{--<div class="input-group">--}}
            {{--<div class="icheck-{{ isset($display) ? $display : 'list' }}">--}}
                {{--@foreach($list as $radio)--}}
                    {{--<label>{!! Form::radio($name, isset($radio['value']) ? $radio['value'] : old($name),isset($radio['checked']) ? $radio['checked'] : false,array_merge(['data-radio'=>'iradio_square-blue'],$options)) !!} {{ $radio['text'] }}</label>--}}
                {{--@endforeach--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
