@extends('layouts.app')
@section('title', trans('offices.page-title'))
@section('css')

@endsection

@section('content')

     @pageTitle('trans'=>'offices','title'=>'offices','description'=>'Manage offices ',
               'breadcrumb'=>[trans('offices.administration'),trans('offices.index.list')],
               'buttons'=> slug() == 'admin' ? [
                  ['text'=> trans('offices.index.create_btn'),'url'=> route('offices.create')],
              ] : []
           )
    <div class="container-fluid container-fullw bg-white">

       <form style="margin-bottom: 10px;" name="search_form" class="pull-right" method="GET" action="{{route('offices.index')}}">
           <input id="search_grid" placeholder="Search In Grid"  type="text" name="string">
       </form>

       <form style="margin-bottom: 10px;" name="paginate_form" method="GET" action="{{route('offices.index')}}">
           <label>Show</label>
           <select name="paginate" id="paginate">
               <option {{($paginate == 10 ? 'selected' : '')}} value="10">10</option>
               <option {{($paginate == 25 ? 'selected' : '')}} value="25">25</option>
               <option {{($paginate == 50 ? 'selected' : '')}} value="50">50</option>
               <option {{($paginate == 100 ? 'selected' : '')}} value="100">100</option>
           </select>
           <label>Entries</label>
       </form>

       <table class="table table-bordered" id="offices-table">
           <thead>
           <tr>
                <th> <a href="{{route('offices.index')}}?field=branch_code&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('offices.branch_code') }}</a></th>
	<th> <a href="{{route('offices.index')}}?field=name&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('offices.name') }}</a></th>
	<th> <a href="{{route('offices.index')}}?field=abbreviation&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('offices.abbreviation') }}</a></th>
	
                <th>{{ trans('offices.index.action') }}</th>

           </tr>
           </thead>
           <tbody>
           @foreach($offices as $item)
               <tr>
                   <td>{{ $item->branch_code }}</td><td>{{ $item->name }}</td><td>{{ $item->abbreviation }}</td>
                   <td>
                       <a href="{{ route('offices.show', $item->id ) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="View"><i class="fa fa-eye"></i></a>
                       <a href="{{ route('offices.edit', $item->id) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="javascript:void(0)" class="btn btn-transparent btn-xs delete-offices" data-id="{{ $item->id }}" data-toggle="tooltip" data-placement="left" title="Delete"><i class="fa fa-trash"></i></a>
                   </td>
               </tr>
           @endforeach
           </tbody>
       </table>
       {{ $offices->appends(Request::except('page'))->links() }}

    </div>

@endsection

@section('page-plugins')

@endsection


@section('page-scripts')

    <script>
            var table_selector = '#offices-table';

            $('.table').on('click', '.delete-offices', function(e){
                    tr = $(this).closest('tr');

                    var itemId = $(this).attr('data-id');

                    swal({
                        showLoaderOnConfirm: true,
                        title: "{{ trans('offices.index.delete_box_title') }}",
                        text: "{{ trans('offices.index.delete_conformation') }}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#007AFF",
                        confirmButtonText: "{{ trans('offices.index.confirm-button-text') }}",
                        cancelButtonText: "{{ trans('offices.index.cancel-button-text') }}",
                        closeOnConfirm: false
                    }).then(function() {
                        $.ajax({
                            url:  '{{ str_replace('-1','',route('offices.destroy',-1))  }}'+itemId,
                            headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
                            error: function() {
                                swal("Cancelled", "{{trans('offices.index.delete_unable')}}", "error");
                                toastr.error('{{trans('offices.index.delete_unable')}}', '{{trans('offices.index.error')}}');
                            },
                            success: function(response) {
                                if(response.success == 'true'){
                                    tr.remove();
                                    swal("{{trans('offices.index.delete_validation')}}", "{{trans('offices.index.delete_msg')}}", "success");
                                }else{
                                    toastr.error('{{trans('offices.index.delete_unable')}}', '{{trans('offices.index.error')}}');
                                }
                            },

                            type: 'DELETE'
                        });
                    });

                    e.preventDefault();
                });

        </script>

@endsection