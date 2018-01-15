@extends('layouts.app')
@section('title', trans('accountgroups.page-title'))
@section('css')

@endsection

@section('content')

     @pageTitle('trans'=>'accountgroups','title'=>'accountgroups','description'=>'description',
               'breadcrumb'=>[trans('accounts.general-ledger'),trans('accounts.setup'),trans('accountgroups.index.list')],
               'buttons'=> slug() == 'admin' ? [
                  ['text'=> trans('accountgroups.index.create_btn'),'url'=> route('accountgroups.create')],
              ] : []
           )
    <div class="container-fluid container-fullw bg-white">

       <form style="margin-bottom: 10px;" name="search_form" class="pull-right" method="GET" action="{{route('accountgroups.index')}}">
           <input id="search_grid" placeholder="Search In Grid"  type="text" name="string">
       </form>

       <form style="margin-bottom: 10px;" name="paginate_form" method="GET" action="{{route('accountgroups.index')}}">
           <label>Show</label>
           <select name="paginate" id="paginate">
               <option {{($paginate == 10 ? 'selected' : '')}} value="10">10</option>
               <option {{($paginate == 25 ? 'selected' : '')}} value="25">25</option>
               <option {{($paginate == 50 ? 'selected' : '')}} value="50">50</option>
               <option {{($paginate == 100 ? 'selected' : '')}} value="100">100</option>
           </select>
           <label>Entries</label>
       </form>

       <table class="table table-bordered" id="accountgroups-table">
           <thead>
           <tr>
                <th> <a href="{{route('accountgroups.index')}}?field=name&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('accountgroups.name') }}</a></th>
	<th> <a href="{{route('accountgroups.index')}}?field=description&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('accountgroups.description') }}</a></th>
	
                <th>{{ trans('accountgroups.index.action') }}</th>

           </tr>
           </thead>
           <tbody>
           @foreach($accountgroups as $item)
               <tr>
                   <td>{{ $item->name }}</td><td>{{ $item->description }}</td>
                   <td>
{{--                       <a href="{{ route('accountgroups.show', $item->id ) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="View"><i class="fa fa-eye"></i></a>--}}
                       <a href="{{ route('accountgroups.edit', $item->id) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="javascript:void(0)" class="btn btn-transparent btn-xs delete-accountgroups" data-id="{{ $item->id }}" data-toggle="tooltip" data-placement="left" title="Delete"><i class="fa fa-trash"></i></a>
                   </td>
               </tr>
           @endforeach
           </tbody>
       </table>
       {{ $accountgroups->appends(Request::except('page'))->links() }}

    </div>

@endsection

@section('page-plugins')

@endsection


@section('page-scripts')

    <script>
            var table_selector = '#accountgroups-table';

            $('.table').on('click', '.delete-accountgroups', function(e){
                    tr = $(this).closest('tr');

                    var itemId = $(this).attr('data-id');

                    swal({
                        showLoaderOnConfirm: true,
                        title: "{{ trans('accountgroups.index.delete_box_title') }}",
                        text: "{{ trans('accountgroups.index.delete_conformation') }}",
                        icon: "warning",
                        dangerMode: true,
                        buttons: {
                            cancel: true,
                            confirm: true,
                        },
                    }).then(willDelete => {
                        if(willDelete){
                            $.ajax({
                            url:  '{{ str_replace('-1','',route('accountgroups.destroy',-1))  }}'+itemId,
                            headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
                            success: function(response) {
                                if(response.success == 'true'){

                                    swal("{{trans('accountgroups.index.delete_validation')}}", "{{trans('accountgroups.index.delete_msg')}}", "success");
                                }else{

                                    swal("Unable to delete", "{{trans('accountgroups.index.delete_msg')}}", "error");

                                }
                            },

                            type: 'DELETE'
                        })
                        }
                    });

                    e.preventDefault();
                });

        </script>

@endsection