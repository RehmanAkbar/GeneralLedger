@extends('layouts.app')
@section('title', trans('companies.page-title'))
@section('css')

@endsection

@section('content')

     @pageTitle('trans'=>'companies','title'=>'companies','description'=>'description',
               'breadcrumb'=>[trans('companies.administration'),trans('companies.index.list')],
               'buttons'=> slug() == 'admin' ? [
                  ['text'=> trans('companies.index.create_btn'),'url'=> route('companies.create')],
              ] : []
           )
    <div class="container-fluid container-fullw bg-white">

       <form style="margin-bottom: 10px;" name="search_form" class="pull-right" method="GET" action="{{route('companies.index')}}">
           <input id="search_grid" placeholder="Search In Grid"  type="text" name="string">
       </form>

       <form style="margin-bottom: 10px;" name="paginate_form" method="GET" action="{{route('companies.index')}}">
           <label>Show</label>
           <select name="paginate" id="paginate">
               <option {{($paginate == 10 ? 'selected' : '')}} value="10">10</option>
               <option {{($paginate == 25 ? 'selected' : '')}} value="25">25</option>
               <option {{($paginate == 50 ? 'selected' : '')}} value="50">50</option>
               <option {{($paginate == 100 ? 'selected' : '')}} value="100">100</option>
           </select>
           <label>Entries</label>
       </form>

       <table class="table table-bordered" id="companies-table">
           <thead>
           <tr>
                <th> <a href="{{route('companies.index')}}?field=code&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('companies.code') }}</a></th>
                <th> <a href="{{route('companies.index')}}?field=name&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('companies.name') }}</a></th>
                <th> <a href="{{route('companies.index')}}?field=abbreviation&orderBy={{$orderBy}}&string={{$searchString}}&paginate={{$paginate}}" >{{ trans('companies.abbreviation') }}</a></th>
                <th> <a href="#" >{{ trans('companies.image') }}</a></th>
                <th>{{ trans('companies.index.action') }}</th>
           </tr>
           </thead>
           <tbody>
           @foreach($companies as $item)
               <tr>
                   <td>{{ $item->code }}</td>
                   <td>{{ $item->name }}</td>
                   <td>{{ $item->abbreviation }}</td>
                   <td>
                       <img width="50" src="{{asset('company/images')}}/{{$item->image}}" alt="">
                   </td>
                   <td>
                       <a href="{{ route('companies.show', $item->id ) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="View"><i class="fa fa-eye"></i></a>
                       <a href="{{ route('companies.edit', $item->id) }}" class="btn btn-transparent btn-xs" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="javascript:void(0)" class="btn btn-transparent btn-xs delete-companies" data-id="{{ $item->id }}" data-toggle="tooltip" data-placement="left" title="Delete"><i class="fa fa-trash"></i></a>
                   </td>
               </tr>
           @endforeach
           </tbody>
       </table>
       {{ $companies->appends(Request::except('page'))->links() }}

    </div>

@endsection

@section('page-plugins')

@endsection


@section('page-scripts')

    <script>
            var table_selector = '#companies-table';

            $('.table').on('click', '.delete-companies', function(e){
                    tr = $(this).closest('tr');

                    var itemId = $(this).attr('data-id');

                    swal({
                        title: "{{ trans('companies.index.delete_box_title') }}",
                        text: "{{ trans('companies.index.delete_conformation') }}",
                        icon: "warning",
                        dangerMode: true,
                        buttons: {
                            cancel: true,
                            confirm: true,
                        },
                    }).then(willDelete => {
                        if(willDelete){

                            $.ajax({
                                url:  '{{ str_replace('-1','',route('companies.destroy',-1))  }}'+itemId,
                                headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
                                error: function() {
                                    swal("Cancelled", "{{trans('companies.index.delete_unable')}}", "error");
                                },
                                success: function(response) {
                                    if(response.success == 'true'){
                                        tr.remove();
                                        swal("{{trans('companies.index.delete_validation')}}", "{{trans('companies.index.delete_msg')}}", "success");
                                    }else{
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