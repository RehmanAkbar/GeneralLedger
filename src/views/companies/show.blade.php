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
                                        <div class="row">
                                              <div class="col-xs-3">
                                                <label><b>{{ trans('companies.code') }}:</b></label>
                                              </div>
                                            <div class="col-xs-9">
                                                {{ $company->code }}
                                            </div>
                                        </div>
                                            <div class="row">
                                                  <div class="col-xs-3">
                                                      <label><b>{{ trans('companies.name') }}:</b></label>
                                                  </div>
                                                <div class="col-xs-9">
                                                    {{ $company->name }}
                                                </div>
                                            </div>
                                              <div class="row">
                                                   <div class="col-xs-3">
                                                      <label><b>{{ trans('companies.abbreviation') }}:</b></label>
                                                   </div>
                                                    <div class="col-xs-9">
                                                        {{ $company->abbreviation }}
                                                    </div>
                                              </div>
                                                @foreach($company->offices as $office)
                                                    <div class="row">
                                                        <div class="col-xs-3">
                                                            <label><b>{{ trans('companies.office') }}:</b></label>
                                                        </div>
                                                        <div class="col-xs-9">
                                                            {{ $office->name }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="col-md-6 col-md-offset-2">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="user-image">
                                                                <div class="fileinput-new thumbnail"><img src="{{asset('company/images')}}/{{$company->image}}" alt="">
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                                <div class="user-image-buttons">
                                                                    <a href="#" class="btn fileinput-exists btn-red btn-sm" data-dismiss="fileinput">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('companies.index') }}" class="btn btn-default btn-wide pull-right">Cancel</a>
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

