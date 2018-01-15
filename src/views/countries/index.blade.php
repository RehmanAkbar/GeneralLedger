@extends('layouts.app')
@section('title', trans('countries.page-title'))
@section('css')

@endsection

@section('content')

     @pageTitle('trans'=>'countries','title'=>'countries','description'=>'Manage countries',
               'breadcrumb'=>[trans('countries.administration'),trans('countries.index.list')],
               'buttons'=> slug() == 'admin' ? [
                  ['text'=> trans('countries.index.create_btn'),'url'=> route('countries.create')],
              ] : []
           )
    <div class="container-fluid container-fullw bg-white">

       <form style="margin-bottom: 10px;" name="search_form" class="pull-right" method="GET" action="{{route('countries.index')}}">
           <input id="search_grid" placeholder="Search In Grid"  type="text" name="string">
       </form>

       <form style="margin-bottom: 10px;" name="paginate_form" method="GET" action="{{route('countries.index')}}">
           <label>Show</label>
           <select name="paginate" id="paginate">
               <option {{($paginate == 10 ? 'selected' : '')}} value="10">10</option>
               <option {{($paginate == 25 ? 'selected' : '')}} value="25">25</option>
               <option {{($paginate == 50 ? 'selected' : '')}} value="50">50</option>
               <option {{($paginate == 100 ? 'selected' : '')}} value="100">100</option>
           </select>
           <label>Entries</label>
       </form>

       <table class="table table-bordered" id="countries-table">
           <thead>
           <tr>
                <th> <a href="{{route('countries.index')}}?field=name&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('countries.name') }}</a></th>
	<th> <a href="{{route('countries.index')}}?field=currency&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('countries.currency') }}</a></th>
	<th> <a href="{{route('countries.index')}}?field=rate&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('countries.rate') }}</a></th>
	
                <th>{{ trans('countries.index.action') }}</th>

           </tr>
           </thead>
           <tbody>
           @foreach($countries as $item)
               <tr>
                   <td>{{ $item->name }}</td><td>{{ $item->currency }}</td><td>{{ $item->rate }}</td>
                   <td>
                       <a href="{{ route('countries.show', $item->id ) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="View"><i class="fa fa-eye"></i></a>
                       <a href="{{ route('countries.edit', $item->id) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="javascript:void(0)" class="btn btn-transparent btn-xs delete-countries" data-id="{{ $item->id }}" data-toggle="tooltip" data-placement="left" title="Delete"><i class="fa fa-trash"></i></a>
                   </td>
               </tr>
           @endforeach
           </tbody>
       </table>
       {{ $countries->appends(Request::except('page'))->links() }}

    </div>

@endsection

@section('page-plugins')

@endsection


@section('page-scripts')

    <script>
            var table_selector = '#countries-table';

            $('.table').on('click', '.delete-countries', function(e){
                    tr = $(this).closest('tr');

                    var itemId = $(this).attr('data-id');

                    swal({
                        showLoaderOnConfirm: true,
                        title: "{{ trans('countries.index.delete_box_title') }}",
                        text: "{{ trans('countries.index.delete_conformation') }}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#007AFF",
                        confirmButtonText: "{{ trans('countries.index.confirm-button-text') }}",
                        cancelButtonText: "{{ trans('countries.index.cancel-button-text') }}",
                        closeOnConfirm: false
                    }).then(function() {
                        $.ajax({
                            url:  '{{ str_replace('-1','',route('countries.destroy',-1))  }}'+itemId,
                            headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
                            error: function() {
                                swal("Cancelled", "{{trans('countries.index.delete_unable')}}", "error");
                                toastr.error('{{trans('countries.index.delete_unable')}}', '{{trans('countries.index.error')}}');
                            },
                            success: function(response) {
                                if(response.success == 'true'){
                                    tr.remove();
                                    swal("{{trans('countries.index.delete_validation')}}", "{{trans('countries.index.delete_msg')}}", "success");
                                }else{
                                    toastr.error('{{trans('countries.index.delete_unable')}}', '{{trans('countries.index.error')}}');
                                }
                            },

                            type: 'DELETE'
                        });
                    });

                    e.preventDefault();
                });

        </script>

@endsection