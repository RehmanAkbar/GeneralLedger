@extends('layouts.app')
@section('title', trans('pages.'.explode('.',request()->route()->getName())[0].'.title'))

@section('css')
    <style>

        .hidden{
            display: none;
        }

    </style>
@endsection

@section('content')
    <div class="wrap-content container" id="container">
        <div class="container-fluid container-fullw bg-white">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['route' => 'vouchers.store', "files" => 'true' ,'class' => 'form-horizontal ', 'id'=>'vouchers-form']) !!}
                        <div class="text-right">
                            <div>
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!} 
                                &nbsp;&nbsp;<a href="{{ route('vouchers.index') }}" class="btn btn-default pull-right">Cancel</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                            {{--<button style="margin-top: 20px;" id="last_voucher" type="button" class="btn btn-sm btn-wide btn-blue">--}}
                                {{--Last Voucher--}}
                            {{--</button>--}}

                            <div class="col-md-6">
                                @select('name'=>'voucher_type_id','id'=>'voucher_type_id','trans'=>'vouchers','list'=>$voucherTypes,'options'=>['required' => 'required', 'class' =>'js-example-basic-multiple js-states form-control' ,'label-size'=>'4','field-size'=>'8'])
                                @text('name'=>'voucher_code','trans'=>'vouchers','options'=>['disabled' => 'disabled','class'=>'form-control','label-size'=>'4','field-size'=>'8'])

                                @textarea('name'=>'remarks','trans'=>'vouchers','options'=>['class'=>'form-control','label-size'=>'4','field-size'=>'8','rows'=>'2'])

                            </div>
                                <div class="col-md-6">
                                    <div class=" form-group">
                                        <label class="control-label col-sm-4">Voucher Date</label>
                                        <div class="col-sm-8">
                                            <div class='input-group date' id='date'>
                                                <input type='text' name="voucher_date" class="form-control" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="col-md-offset-5 btn btn-primary btn-o " data-toggle="modal" data-target="#filesModel">
                                        Manage Attachments
                                    </button>
                                </div>
                                <div class="clear30"></div>
                                       
                            </div>
                            <div class="clearfix"></div>
                            <div class="table-responsive">
                                <table id="vouchers" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Account Code</th>
                                            <th>Cheque No. & Date</th>
                                            <th colspan="2">Narration</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="entry_details">
                                            <td colspan="2" >
                                                <select id="account_id" class="account_id form-control">
                                                    <option disabled selected> </option>
                                                        @foreach($accounts as $account)
                                                            <option value="{{$account->id}}">{{$account->description}}</option>
                                                        @endforeach
                                                </select>
                                            </td>
                                            <td style="width: 150px"><input type="text" class="form-control cheque_no"></td>
                                            <td colspan="2" style="width: 35%"><input type="text" class="form-control narration"></td>
                                            <td style="width: 120px"><input id="debitInput" type="number" value="0" class="form-control debit" ></td>
                                            <td style="width: 120px"><input id="creditInput" type="number" value="0" class="form-control credit"></td>
                                            
                                            <td class="text-nowrap">
                                                <div class="">
                                                    <a class="btn btn-success btn-sm" id="add" href="javascript:;">
                                                        Add
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                        <tr>
                                            <th>AC Code</th>
                                            <th>Account Name</th>
                                            <th style="width: 40px">Cheque</th>
                                            <th colspan="2">Narration</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                           
                                            <th>Action</th>
                                        </tr>
                                </table>
                            </div>
                             
                                <div class="row">
                                <div class="col-sm-6"></div>
                                    <div class="col-sm-6">
                                        <div class="col-md-2">
                                            <p ><b>Total:</b></p>
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <p id="totalDebit">0</p>
                                        </div>
                                        <div class="col-md-2">
                                            <p ><b>Total:</b> </p>
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <p id="totalCredit">0</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <input type="hidden" name="_method" value="POST" id="method">
                         {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="filesModel" tabindex="-1" role="dialog" aria-labelledby="filesModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="filesModel">Manage Attachments</h4>
                </div>
                <div class="modal-body">

                    <div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th width="400">Name</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody id="files">

                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" id="fileName" name="file_name" class="form-control" value="" placeholder="Enter File Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Chose File</label>
                                <div class="col-sm-9">
                                    <input id="file" type="file" name="chose" value="">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="bottom_btns text-right">
                            <button id="addFiles" type="button" class="btn btn-success">Add</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('page-plugins')



@endsection

@section('page-scripts')

  @include('vouchers._scripts')

@endsection