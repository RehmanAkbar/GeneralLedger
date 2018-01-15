@extends('layouts.app')
@section('title', trans('vouchertypes.page-title'))
@section('css')

@endsection

@section('content')

     @pageTitle('trans'=>'vouchertypes','title'=>'vouchertypes','description'=>'Manage voucher types',
               'breadcrumb'=>[trans('accounts.general-ledger'),trans('accounts.setup'),trans('vouchertypes.index.list')],
               'buttons'=> slug() == 'admin' ? [
                  ['text'=> trans('vouchertypes.index.create_btn'),'url'=> route('vouchertypes.create')],
              ] : []
           )
    <div class="container-fluid container-fullw bg-white">

       <form style="margin-bottom: 10px;" name="search_form" class="pull-right" method="GET" action="{{route('vouchertypes.index')}}">
           <input id="search_grid" placeholder="Search In Grid"  type="text" name="string">
       </form>

       <form style="margin-bottom: 10px;" name="paginate_form" method="GET" action="{{route('vouchertypes.index')}}">
           <label>Show</label>
           <select name="paginate" id="paginate">
               <option {{($paginate == 10 ? 'selected' : '')}} value="10">10</option>
               <option {{($paginate == 25 ? 'selected' : '')}} value="25">25</option>
               <option {{($paginate == 50 ? 'selected' : '')}} value="50">50</option>
               <option {{($paginate == 100 ? 'selected' : '')}} value="100">100</option>
           </select>
           <label>Entries</label>
       </form>

       <table class="table table-bordered" id="vouchertypes-table">
           <thead>
           <tr>
                <th> <a href="{{route('vouchertypes.index')}}?field=type&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('vouchertypes.type') }}</a></th>
	<th> <a href="{{route('vouchertypes.index')}}?field=description&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('vouchertypes.description') }}</a></th>
	<th> <a href="{{route('vouchertypes.index')}}?field=prepared_by&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('vouchertypes.prepared_by') }}</a></th>
	
                <th>{{ trans('vouchertypes.index.action') }}</th>

           </tr>
           </thead>
           <tbody>
           @foreach($vouchertypes as $item)
               <tr>
                   <td>{{ $item->type }}</td><td>{{ $item->description }}</td><td>{{ $item->prepared_by }}</td>
                   <td>
                       <a href="{{ route('vouchertypes.show', $item->id ) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="View"><i class="fa fa-eye"></i></a>
                       <a href="{{ route('vouchertypes.edit', $item->id) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="javascript:void(0)" class="btn btn-transparent btn-xs delete-vouchertypes" data-id="{{ $item->id }}" data-toggle="tooltip" data-placement="left" title="Delete"><i class="fa fa-trash"></i></a>
                   </td>
               </tr>
           @endforeach
           </tbody>
       </table>
       {{ $vouchertypes->appends(Request::except('page'))->links() }}

    </div>

@endsection

@section('page-plugins')

@endsection


@section('page-scripts')

    <script>
            var table_selector = '#vouchertypes-table';

            $('.table').on('click', '.delete-vouchertypes', function(e){
                    tr = $(this).closest('tr');

                    var itemId = $(this).attr('data-id');

                    swal({
                        showLoaderOnConfirm: true,
                        title: "{{ trans('vouchertypes.index.delete_box_title') }}",
                        text: "{{ trans('vouchertypes.index.delete_conformation') }}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#007AFF",
                        confirmButtonText: "{{ trans('vouchertypes.index.confirm-button-text') }}",
                        cancelButtonText: "{{ trans('vouchertypes.index.cancel-button-text') }}",
                        closeOnConfirm: false
                    }).then(function() {
                        $.ajax({
                            url:  '{{ str_replace('-1','',route('vouchertypes.destroy',-1))  }}'+itemId,
                            headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
                            error: function() {
                                swal("Cancelled", "{{trans('vouchertypes.index.delete_unable')}}", "error");
                                toastr.error('{{trans('vouchertypes.index.delete_unable')}}', '{{trans('vouchertypes.index.error')}}');
                            },
                            success: function(response) {
                                if(response.success == 'true'){
                                    tr.remove();
                                    swal("{{trans('vouchertypes.index.delete_validation')}}", "{{trans('vouchertypes.index.delete_msg')}}", "success");
                                }else{
                                    toastr.error('{{trans('vouchertypes.index.delete_unable')}}', '{{trans('vouchertypes.index.error')}}');
                                }
                            },

                            type: 'DELETE'
                        });
                    });

                    e.preventDefault();
                });

        </script>

@endsection