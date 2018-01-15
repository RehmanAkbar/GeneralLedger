
@extends('layouts.app')
@section('title', trans('pages.'.explode('.',request()->route()->getName())[0].'.title'))

@section('content')

    <div class="container-fluid container-fullw bg-white">
            <div class="row">

                <div class="col-md-12">
                    {!! Form::open(['route' => 'accounts.store', 'class' => 'form-horizontal', 'id'=>'accounts-form']) !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">Account <span class="text-bold">Selection</span></h4>
                                    </div>
                                    <div class="panel-body">
                                        <div id="accounts_tree" class="tree-demo">
                                            @foreach($accounts as $level1)
                                                <ul>
                                                    <li id="{{$level1->id}}"  >
                                                        <a href="{{ route('accounts.edit', $level1->id) }}">{{$level1->description}}({{ $level1->code }})</a>
                                                        @foreach($level1['level2'] as $level2)
                                                            <ul>
                                                                <li id="{{$level2->id}}" >
                                                                    <a href="{{ route('accounts.edit', $level2->id) }}">{{$level2->description}}({{ $level2->code }})</a>
                                                                    @foreach($level2['level3'] as $level3)
                                                                        <ul>
                                                                            <li id="{{$level3->id}}"  data-jstree='{ "type" : "file" }' >
                                                                                <a href="{{ route('accounts.edit', $level3->id) }}" >{{$level3->description}}({{ $level3->code }})</a>
                                                                            </li>
                                                                        </ul>
                                                                    @endforeach
                                                                </li>
                                                            </ul>
                                                        @endforeach
                                                    </li>
                                                </ul> 
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 ">
                                @include('accounts._fields')
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-2">
                            {!! Form::submit('Create', ['class' => 'btn btn-primary btn-wide pull-right']) !!}
                            <a href="{{ route('accounts.index') }}" class="btn btn-default btn-wide">Cancel</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

@endsection

@section('page-scripts')

    @include('accounts.partials._scripts')

@endsection