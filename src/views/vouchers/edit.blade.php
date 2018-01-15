@extends('layouts.app')
@section('title', trans('pages.'.explode('.',request()->route()->getName())[0].'.title'))

@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="wrap-content container" id="container">
        <div class="container-fluid container-fullw bg-white">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn margin-bottom-5 pull-right btn-wide btn-o btn-primary" href="{{route('print_voucher' ,['voucher_id' =>  $voucher->id])}}" target="_blank" class="btn btn-transparent btn-xs " data-toggle="tooltip" data-placement="left" title="Details">
                    Preview <i class="fa fa-share"></i>
                    </a>
                    <div class="clear10"></div>
                    {!! Form::model($voucher, [ 'method' => 'POST','route' => ['updateVoucher', $voucher->id],'class' => 'form-horizontal', 'id'=>'vouchers-update-form' ]) !!}
                    <div class="text-right">
                            <div>
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                 &nbsp;&nbsp;<a href="{{ route('vouchers.index') }}" class="btn btn-default pull-right">Cancel</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>

                        <div class="col-md-6">
                            @select('name'=>'voucher_type_id','id'=>'voucher_type_id','trans'=>'vouchers','list'=>$voucherTypes,'options'=>['required' => 'required', 'class' =>'js-example-basic-multiple js-states form-control' ,'label-size'=>'4','field-size'=>'8'])
                            @text('name'=>'voucher_code','trans'=>'vouchers','options'=>['disabled' => 'disabled','class'=>'form-control','label-size'=>'4','field-size'=>'8'])
                            @textarea('name'=>'remarks','trans'=>'vouchers','options'=>['class'=>'form-control','label-size'=>'4','field-size'=>'8','rows'=>'2'])


                        </div>
                        <div class="col-md-6">
                            
                            <div class=" form-group">
                                <label class="control-label col-sm-4">Voucher Date</label>
                                <div class="col-sm-8">
                                    <div class='input-group date'>
                                        <input type='text' id="edit_date" value="{{Carbon\Carbon::parse($voucher->voucher_date)->format('m/d/Y')}}" name="voucher_date" class="form-control" />
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
                                <div class="table-responsive">
                                <table id="vouchers" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Account Code</th>
                                            <th>Cheque No. & Date</th>
                                            <th>Narration</th>
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
                                                    {{--  @foreach($accounts as $account)
                                                        <option value="{{$account->id}}">{{$account->description}} </option>
                                                    @endforeach  --}}
                                                </select>
                                            </td>
                                            <td style="width: 150px"><input type="text" class="form-control cheque_no"></td>
                                            <td ><input type="text" class="form-control narration"></td>
                                            <td style="width: 120px"><input id="debitInput" type="number" value="0" class="form-control debit" ></td>
                                            <td style="width: 120px"><input id="creditInput" type="number" value="0" class="form-control credit"></td>
                                            <td class="text-nowrap">
                                                <div class="">
                                                    <a class="btn btn-success btn-sm" id="add" href="javascript:;">
                                                        Add
                                                    </a>
                                                </div>
                                            </td>
                                            <input type="hidden" name="id" id="details_id">
                                            <input type="hidden" id="voucher_id"  value="{{$voucher->id}}">
                                        </tr>
                                        <tr>
                                            <th>AC Code</th>
                                            <th>Account Name</th>
                                            <th style="width: 40px">Cheque</th>
                                            <th>Narration</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Action</th>
                                        </tr>
                                        @if(isset($voucher['details']) and !empty($voucher['details']) )
                                            @foreach($voucher['details'] as $detail)
                                                <tr class="details" data-id="{{$detail->id}}">
                                                    <td class="account_id" > {{$detail->account_id}} </td>
                                                    <td class="account_name" > {{$detail['account']->description}} </td>
                                                    <td class="cheque_no" > {{$detail->cheque_no}} </td>
                                                    <td class="narration"> {{$detail->narration}} </td>
                                                    <td class="debit"> {{$detail->debit}} </td>
                                                    <td class="credit"> {{$detail->credit}} </td>
                                                    <td data-id="{{$detail->id}}" class="delete">
                                                        <a class="btn btn-danger btn-sm" href="javascript:;">
                                                            Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                       
                                    </thead>
                                </table>
                            </div>
                                   
                                <div class="col-sm-6"></div>
                                    <div class="col-sm-6">
                                        <div class="col-md-2">
                                            <p id="totalDebit" data-debit="{{$voucher['details']->sum('debit')}}" ><b>Total:</b> </p>
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <p>{{$voucher['details']->sum('debit')}}</p>
                                        </div>
                                        <div class="col-md-2">
                                            <p id="totalCredit" data-credit="{{$voucher['details']->sum('credit')}}" ><b>Total:</b> </p>
                                            
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <p>{{$voucher['details']->sum('credit')}}</p>
                                        </div>
                                    </div>

                                </div>

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
                                @if(isset($voucher->files))
                                    @foreach($voucher->files as $file)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <a href="{{getCloudPath($file)}}">{{$file->original_name}}</a>
                                            </td>
                                            <td class="text-right">
                                                <button data-id="{{$file->id}}" data-path="{{getCloudPath($file)}}" class="deleteFile btn btn-danger" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
                            <button id="updateFile" type="button" class="btn btn-success">Add</button>
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

@section('page-scripts')

    @include('vouchers._scripts')

    <script>
        $(document).on('click', '#updateFile', function () {

            addFiles();
            var formData = new FormData();
            var count = 1;
            $('tr.files').each(function(i, tr) {
                var $this = $(this);
                var fileSelect = document.getElementById(count+++'file-select');


                var files = fileSelect.files;
                // Loop through each of the selected files.
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];

                    formData.append('files[]', file, file.name);
                }

                formData.append('fileName[]', $this.find('.fileName').text());
            });

            var url = "{{ str_replace('-1','',route('voucherFile.create',-1))  }}" + "{{$voucher->id}}";
            var callBack = function () {

//                swal("Deleted!", "Voucher file has been Uploaded!", "success");

            };

            ajx(url, "POST", formData, callBack());

        });

        $(document).on('click', '.deleteFile', function (e) {
            var $this = $(this);
            var id   = $this.data('id');

            console.log($this.data('path'));
            swal({
                title: "Are you sure?",
                text: "Are you sure that you want to delete this. ?",
                buttons: {
                    cancel: true,
                    confirm: true,
                },
                icon: "warning",
                dangerMode: true,
            })
                .then(willDelete => {
                    if (willDelete) {

                        var url = "{{ str_replace('-1','',route('voucherFile.destroy',-1))  }}"+id;
                        var data = {path: $this.data('path')};
                        var callBack = function () {

                            swal("Deleted!", "Voucher file has been deleted!", "success");

                        };

                        ajx(url, "POST", data, callBack());

                    }
                });
        });
    </script>

@endsection