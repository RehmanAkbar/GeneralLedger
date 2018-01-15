@extends('layouts.app')
@section('title', trans('pages.'.explode('.',request()->route()->getName())[0].'.title'))

@section('content')
    <div class="wrap-content container" id="container">
        
        <!-- start: FORM VALIDATION EXAMPLE 1 -->
        <div class="container-fluid container-fullw bg-white">
            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="panel panel-white" id="panel1">
                                    <div class="panel-body mainDescription">
                                            <div class="row">        <div class="col-xs-3">            <label><b>{{ trans('offices.branch_code') }}:</b></label>        </div>       <div class="col-xs-9">            {{ $office->branch_code }}        </div>    </div>    <div class="row">        <div class="col-xs-3">            <label><b>{{ trans('offices.name') }}:</b></label>        </div>       <div class="col-xs-9">            {{ $office->name }}        </div>    </div>    <div class="row">        <div class="col-xs-3">            <label><b>{{ trans('offices.abbreviation') }}:</b></label>        </div>       <div class="col-xs-9">            {{ $office->abbreviation }}        </div>    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('offices.index') }}" class="btn btn-default btn-wide pull-right">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

