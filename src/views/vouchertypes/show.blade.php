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
                                            <div class="row">        <div class="col-xs-3">            <label><b>{{ trans('vouchertypes.type') }}:</b></label>        </div>       <div class="col-xs-9">            {{ $vouchertype->type }}        </div>    </div>    <div class="row">        <div class="col-xs-3">            <label><b>{{ trans('vouchertypes.description') }}:</b></label>        </div>       <div class="col-xs-9">            {{ $vouchertype->description }}        </div>    </div>    <div class="row">        <div class="col-xs-3">            <label><b>{{ trans('vouchertypes.prepared_by') }}:</b></label>        </div>       <div class="col-xs-9">            {{ $vouchertype->prepared_by }}        </div>    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('vouchertypes.index') }}" class="btn btn-default btn-wide pull-right">Cancel</a>
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

