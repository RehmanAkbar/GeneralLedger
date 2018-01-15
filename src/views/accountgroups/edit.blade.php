@extends('layouts.app')
@section('title', trans('pages.'.explode('.',request()->route()->getName())[0].'.title'))


@section('content')
    <div class="wrap-content container" id="container">
        
        <!-- start: FORM VALIDATION EXAMPLE 1 -->
        <div class="container-fluid container-fullw bg-white">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::model($accountgroup, [ 'method' => 'PATCH','route' => ['accountgroups.update', $accountgroup->id],'class' => 'form-horizontal', 'id'=>'accountgroups-form' ]) !!}
                    <div class="row">

                        <div class="col-md-12">
                            <div class="col-md-6 col-md-offset-2">
                                @include('accountgroups._fields')
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-2">
                            {!! Form::submit('Update', ['class' => 'btn btn-primary btn-wide pull-right']) !!}
                            <a href="{{ route('accountgroups.index') }}" class="btn btn-default btn-wide">Cancel</a>
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