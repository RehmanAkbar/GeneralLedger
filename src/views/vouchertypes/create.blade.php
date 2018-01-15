
@extends('layouts.app')
@section('title', trans('pages.'.explode('.',request()->route()->getName())[0].'.title'))


@section('content')
    <div class="wrap-content container" id="container">
      
        <!-- start: FORM VALIDATION EXAMPLE 1 -->
        <div class="container-fluid container-fullw bg-white">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['route' => 'vouchertypes.store', 'class' => 'form-horizontal', 'id'=>'vouchertypes-form']) !!}
                    <div class="row">

                        <div class="col-md-12">
                            <div class="col-md-6 col-md-offset-2">
                                @include('vouchertypes._fields')
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-2">
                            {!! Form::submit('Create', ['class' => 'btn btn-primary btn-wide pull-right']) !!}
                            <a href="{{ route('vouchertypes.index') }}" class="btn btn-default btn-wide">Cancel</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!-- end: FORM VALIDATION EXAMPLE 1 -->
    </div>
@endsection

@section('page-scripts')
    <script>

    </script>
@endsection