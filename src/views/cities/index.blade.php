@extends('layouts.app')
@section('title', trans('cities.page-title'))
@section('css')

@endsection

@section('content')

     @pageTitle('trans'=>'cities','title'=>'cities','description'=>'Manage cities',
               'breadcrumb'=>[trans('cities.bc.administration'),trans('cities.index.list')],
               'buttons'=> slug() == 'admin' ? [
                  ['text'=> trans('cities.index.create_btn'),'url'=> route('cities.create')],
              ] : []
           )
    <div class="container-fluid container-fullw bg-white">

       <form style="margin-bottom: 10px;" name="search_form" class="pull-right" method="GET" action="{{route('cities.index')}}">
           <input id="search_grid" placeholder="Search In Grid"  type="text" name="string">
       </form>

       <form style="margin-bottom: 10px;" name="paginate_form" method="GET" action="{{route('cities.index')}}">
           <label>Show</label>
           <select name="paginate" id="paginate">
               <option {{($paginate == 10 ? 'selected' : '')}} value="10">10</option>
               <option {{($paginate == 25 ? 'selected' : '')}} value="25">25</option>
               <option {{($paginate == 50 ? 'selected' : '')}} value="50">50</option>
               <option {{($paginate == 100 ? 'selected' : '')}} value="100">100</option>
           </select>
           <label>Entries</label>
       </form>

       <table class="table table-bordered" id="cities-table">
           <thead>
           <tr>
                <th> <a href="{{route('cities.index')}}?field=name&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('countries.country') }}</a></th>
                <th> <a href="{{route('cities.index')}}?field=name&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('cities.city') }}</a></th>
	
                <th>{{ trans('cities.index.action') }}</th>

           </tr>
           </thead>
           <tbody>
           @foreach($cities as $city)
               <tr>
                   <td>{{ $city->country->name }}</td>
                   <td>{{ $city->name }}</td>
                   <td>
                       <a href="{{ route('cities.show', $city->id ) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="View"><i class="fa fa-eye"></i></a>
                       <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="javascript:void(0)" class="btn btn-transparent btn-xs delete-cities" data-id="{{ $city->id }}" data-toggle="tooltip" data-placement="left" title="Delete"><i class="fa fa-trash"></i></a>
                   </td>
               </tr>
           @endforeach
           </tbody>
       </table>
       {{ $cities->appends(Request::except('page'))->links() }}

    </div>

@endsection

@section('page-plugins')

@endsection


@section('page-scripts')

    <script>
            var table_selector = '#cities-table';

            $('.table').on('click', '.delete-cities', function(e){
                    tr = $(this).closest('tr');

                    var itemId = $(this).attr('data-id');

                    swal({
                        showLoaderOnConfirm: true,
                        title: "{{ trans('cities.index.delete_box_title') }}",
                        text: "{{ trans('cities.index.delete_conformation') }}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#007AFF",
                        confirmButtonText: "{{ trans('cities.index.confirm-button-text') }}",
                        cancelButtonText: "{{ trans('cities.index.cancel-button-text') }}",
                        closeOnConfirm: false
                    }).then(function() {
                        $.ajax({
                            url:  '{{ str_replace('-1','',route('cities.destroy',-1))  }}'+itemId,
                            headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
                            error: function() {
                                swal("Cancelled", "{{trans('cities.index.delete_unable')}}", "error");
                                toastr.error('{{trans('cities.index.delete_unable')}}', '{{trans('cities.index.error')}}');
                            },
                            success: function(response) {
                                if(response.success == 'true'){
                                    tr.remove();
                                    swal("{{trans('cities.index.delete_validation')}}", "{{trans('cities.index.delete_msg')}}", "success");
                                }else{
                                    toastr.error('{{trans('cities.index.delete_unable')}}', '{{trans('cities.index.error')}}');
                                }
                            },

                            type: 'DELETE'
                        });
                    });

                    e.preventDefault();
                });

        </script>

@endsection