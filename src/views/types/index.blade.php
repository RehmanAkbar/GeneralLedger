@extends('layouts.app')
@section('title', trans('types.page-title'))
@section('css')

@endsection

@section('content')

     @pageTitle('trans'=>'types','title'=>'types','description'=>'Manage types',
               'breadcrumb'=>[trans('accounts.general-ledger'),trans('accounts.setup'),trans('types.index.list')],
               'buttons'=> slug() == 'admin' ? [
                  ['text'=> trans('types.index.create_btn'),'url'=> route('types.create')],
              ] : []
           )
    <div class="container-fluid container-fullw bg-white">

       <form style="margin-bottom: 10px;" name="search_form" class="pull-right" method="GET" action="{{route('types.index')}}">
           <input id="search_grid" placeholder="Search In Grid"  type="text" name="string">
       </form>

       <form style="margin-bottom: 10px;" name="paginate_form" method="GET" action="{{route('types.index')}}">
           <label>Show</label>
           <select name="paginate" id="paginate">
               <option {{($paginate == 10 ? 'selected' : '')}} value="10">10</option>
               <option {{($paginate == 25 ? 'selected' : '')}} value="25">25</option>
               <option {{($paginate == 50 ? 'selected' : '')}} value="50">50</option>
               <option {{($paginate == 100 ? 'selected' : '')}} value="100">100</option>
           </select>
           <label>Entries</label>
       </form>

       <table class="table table-bordered" id="types-table">
           <thead>
           <tr>
                <th> <a href="{{route('types.index')}}?field=name&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('types.name') }}</a></th>
	<th> <a href="{{route('types.index')}}?field=description&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('types.description') }}</a></th>
	
                <th>{{ trans('types.index.action') }}</th>

           </tr>
           </thead>
           <tbody>
           @foreach($types as $item)
               <tr>
                   <td>{{ $item->name }}</td><td>{{ $item->description }}</td>
                   <td>
                       {{--<a href="{{ route('types.show', $item->id ) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="View"><i class="fa fa-eye"></i></a>--}}
                       <a href="{{ route('types.edit', $item->id) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="javascript:void(0)" class="btn btn-transparent btn-xs delete-types" data-id="{{ $item->id }}" data-toggle="tooltip" data-placement="left" title="Delete"><i class="fa fa-trash"></i></a>
                   </td>
               </tr>
           @endforeach
           </tbody>
       </table>
       {{ $types->appends(Request::except('page'))->links() }}

    </div>

@endsection

@section('page-plugins')

@endsection


@section('page-scripts')

    <script>
            var table_selector = '#types-table';

            $('.table').on('click', '.delete-types', function(e){
                    tr = $(this).closest('tr');

                    var itemId = $(this).attr('data-id');

                    swal({
                        showLoaderOnConfirm: true,
                        title: "{{ trans('types.index.delete_box_title') }}",
                        text: "{{ trans('types.index.delete_conformation') }}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#007AFF",
                        confirmButtonText: "{{ trans('types.index.confirm-button-text') }}",
                        cancelButtonText: "{{ trans('types.index.cancel-button-text') }}",
                        closeOnConfirm: false
                    }).then(function() {
                        $.ajax({
                            url:  '{{ str_replace('-1','',route('types.destroy',-1))  }}'+itemId,
                            headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
                            error: function() {
                                swal("Cancelled", "{{trans('types.index.delete_unable')}}", "error");
                                toastr.error('{{trans('types.index.delete_unable')}}', '{{trans('types.index.error')}}');
                            },
                            success: function(response) {
                                if(response.success == 'true'){
                                    tr.remove();
                                    swal("{{trans('types.index.delete_validation')}}", "{{trans('types.index.delete_msg')}}", "success");
                                }else{
                                    toastr.error('{{trans('types.index.delete_unable')}}', '{{trans('types.index.error')}}');
                                }
                            },

                            type: 'DELETE'
                        });
                    });

                    e.preventDefault();
                });

        </script>

@endsection