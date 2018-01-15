@extends('layouts.app')
@section('title', trans('accounts.page-title'))
@section('css')

@endsection

@section('content')

     @pageTitle('trans'=>'accounts','title'=>trans('accounts.page-title'),'description'=>trans('accounts.description'),
               'breadcrumb'=>[trans('accounts.general-ledger'),trans('accounts.setup'),trans('accounts.page-title')],
               'buttons'=> slug() == 'admin' ? [
                  ['text'=> trans('accounts.index.create_btn'),'url'=> route('accounts.create')],
              ] : []
           )
    <div class="container-fluid container-fullw bg-white">

       <form style="margin-bottom: 10px;" name="search_form" class="pull-right" method="GET" action="{{route('accounts.index')}}">
           <input id="search_grid" placeholder="Search In Grid"  type="text" name="string">
       </form>

       <form style="margin-bottom: 10px;" name="paginate_form" method="GET" action="{{route('accounts.index')}}">
           <label>Show</label>
           <select name="paginate" id="paginate">
               <option {{($paginate == 10 ? 'selected' : '')}} value="10">10</option>
               <option {{($paginate == 25 ? 'selected' : '')}} value="25">25</option>
               <option {{($paginate == 50 ? 'selected' : '')}} value="50">50</option>
               <option {{($paginate == 100 ? 'selected' : '')}} value="100">100</option>
           </select>
           <label>Entries</label>
       </form>

       <table class="table table-bordered" id="accounts-table">
           <thead>
               <tr>
                    <th> <a href="{{route('accounts.index')}}?field=code&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('accounts.code') }}</a></th>
                    <th> <a href="{{route('accounts.index')}}?field=Description&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('accounts.name') }}</a></th>
                    <th> <a href="{{route('accounts.index')}}?field=type&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('accounts.company') }}</a></th>

                    <th>{{ trans('accounts.index.action') }}</th>
               </tr>
           </thead>
           <tbody>
           @foreach($accounts as $account)
               <tr>
                   <td>{{ $account->code }}</td>
                   <td>{{ $account->description }}</td>
                   <td>{{ $account->company->name }}</td>
                   <td>
                       <a href="{{ route('accounts.show', $account->id ) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="View"><i class="fa fa-eye"></i></a>
                       <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="javascript:void(0)" class="btn btn-transparent btn-xs delete-accounts" data-id="{{ $account->id }}" data-toggle="tooltip" data-placement="left" title="Delete"><i class="fa fa-trash"></i></a>
                   </td>
               </tr>
           @endforeach
           </tbody>
       </table>
       {{ $accounts->appends(Request::except('page'))->links() }}

    </div>

@endsection

@section('page-plugins')

@endsection


@section('page-scripts')

    <script>

        var table_selector = '#accounts-table';

        $('.table').on('click', '.delete-accounts', function(e){
            tr = $(this).closest('tr');

            var itemId = $(this).attr('data-id');

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
                        $.ajax({
                            url:  '{{ str_replace('-1','',route('accounts.destroy',-1))  }}'+itemId,
                            headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
                            error: function() {
                                swal("Cancelled", "{{trans('accounts.index.delete_unable')}}", "error");
                                toastr.error('{{trans('accounts.index.delete_unable')}}', '{{trans('accounts.index.error')}}');
                            },
                            success: function(response) {
                                if(response.success == 'true'){
                                    tr.remove();
                                    swal("{{trans('accounts.index.delete_validation')}}", "{{trans('accounts.index.delete_msg')}}", "success");
                                }else{
                                    toastr.error('{{trans('accounts.index.delete_unable')}}', '{{trans('accounts.index.error')}}');
                                }
                            },

                            type: 'DELETE'
                        });
                    }
                });
                

                e.preventDefault();
        });

    </script>

@endsection