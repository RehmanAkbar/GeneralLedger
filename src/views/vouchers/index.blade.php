@extends('layouts.app')
@section('title', trans('vouchers.page-title'))
@section('css')

@endsection

@section('content')

     @pageTitle('trans'=>'vouchers','title'=>'vouchers','description'=>'Manage vouchers',
               'breadcrumb'=>[trans('accounts.general-ledger'),trans('vouchers.transactions'),trans('vouchers.index.list')],
               'buttons'=> slug() == 'admin' ? [
                  ['text'=> trans('vouchers.index.create_btn'),'url'=> route('vouchers.create')],
              ] : []
           )
    <div class="container-fluid container-fullw bg-white">

       <form style="margin-bottom: 10px;" name="search_form" class="pull-right" method="GET" action="{{route('vouchers.index')}}">
           <input id="search_grid" placeholder="Search In Grid"  type="text" name="string">
       </form>

        @form('name' => 'voucherType', 'method' => 'GET', 'route'=> 'vouchers.index')
            @select('name'=>'voucher_type_id', 'id' => 'voucher_type', 'trans'=>'vouchers','list'=>$voucherTypes,'options'=>['required' => 'required', 'class' =>'js-example-basic-multiple js-states form-control', 'field-size' => '4', 'label-size'=>'3'])
        @endform


           <table class="table table-bordered" id="vouchers-table">
               <thead>
                   <tr>
                        {{--<th> <a href="{{route('vouchers.index')}}?field=voucher_type_id&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('vouchers.company') }}</a></th>--}}
                        <th> <a href="{{route('vouchers.index')}}?field=voucher_type_id&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('vouchers.voucher_type_id') }}</a></th>
                        <th> <a href="{{route('vouchers.index')}}?field=voucher_code&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('vouchers.voucher_code') }}</a></th>
                        <th> <a href="{{route('vouchers.index')}}?field=voucher_date&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('vouchers.voucher_date') }}</a></th>

                        <th>{{ trans('vouchers.index.action') }}</th>

                   </tr>
               </thead>
               <tbody>
                   @foreach($vouchers as $voucher)
                       <tr>
                           {{--<td><a href="{{route('companies.show',['id' => $voucher->company->id])}}">{{ $voucher->company->name }}</a></td>--}}
                           <td>{{ $voucher->type->type }}</td>
                           <td>{{ $voucher->voucher_code }}</td>
                           <td>{{ $voucher->voucher_date }}</td>
                           <td>
                               <a href="{{route('print_voucher' ,['voucher_id' =>  $voucher->id])}}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="View"><i class="fa fa-eye"></i></a>
                               <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil"></i></a>
                               {{--<a href="{{route('print_voucher' ,['voucher_id' =>  $voucher->id])}}" class="btn btn-transparent btn-xs " data-toggle="tooltip" data-placement="left" title="Details"><i class="fa fa-share"></i></a>--}}
                               <a href="javascript:void(0)" class="btn btn-transparent btn-xs delete-vouchers" data-id="{{ $voucher->id }}" data-toggle="tooltip" data-placement="left" title="Delete"><i class="fa fa-trash"></i></a>
                           </td>
                       </tr>
                   @endforeach
               </tbody>
           </table>
           {{ $vouchers->appends(Request::except('page'))->links() }}

        <form style="margin-bottom: 10px;" class="pull-right" name="paginate_form" method="GET" action="{{route('vouchers.index')}}">
            <label>Show</label>
            <select name="paginate" id="paginate">
                <option {{($paginate == 10 ? 'selected' : '')}} value="10">10</option>
                <option {{($paginate == 25 ? 'selected' : '')}} value="25">25</option>
                <option {{($paginate == 50 ? 'selected' : '')}} value="50">50</option>
                <option {{($paginate == 100 ? 'selected' : '')}} value="100">100</option>
            </select>
            <label>Entries</label>
        </form>
    </div>

@endsection

@section('page-plugins')

@endsection


@section('page-scripts')

    <script>

            $('.table').on('click', '.delete-vouchers', function(e){
                    tr = $(this).closest('tr');

                    var itemId = $(this).attr('data-id');

                    swal({
                        showLoaderOnConfirm: true,
                        title: "{{ trans('vouchers.index.delete_box_title') }}",
                        text: "{{ trans('vouchers.index.delete_conformation') }}",
                        icon: "warning",
                        dangerMode: true,
                        buttons: {
                            cancel: true,
                            confirm: true,
                        },
                    }).then(willDelete => {
                        if(willDelete){
                            $.ajax({
                                url:  '{{ str_replace('-1','',route('vouchers.destroy',-1))  }}'+itemId,
                                headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
                                error: function() {
                                    swal("Cancelled", "{{trans('vouchers.index.delete_unable')}}", "error");
                                },
                                success: function(response) {
                                    if(response.success == 'true'){
                                        tr.remove();
                                        swal("{{trans('vouchers.index.delete_validation')}}", "{{trans('vouchers.index.delete_msg')}}", "success");
                                    }else{

                                        swal("{{trans('vouchers.index.delete_unable')}}", "", "error");

                                    }
                                },

                                type: 'DELETE'
                            });
                        }

                    });

                    e.preventDefault();
                });

            $("#voucher_type").on('change', function (e) {

                var voucherType = $("#voucher_type option:selected").val();

                $("form[name=voucherType]").submit();
            });

    </script>

@endsection