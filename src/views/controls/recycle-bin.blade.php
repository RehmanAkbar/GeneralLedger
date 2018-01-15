@if(auth()->user()->isOfType(ADMIN))
    @if($item->trashed())
        <a href="javascript:void(0)" class="btn btn-transparent btn-xs restore-item" data-id="{{ $item->id }}"
           data-toggle="tooltip" data-placement="left" title="{{ trans('tooltips.restore') }}"><i class="fa fa-recycle"></i></a>

    @else
        <a href="javascript:void(0)" class="btn btn-transparent btn-xs delete-item" data-id="{{ $item->id }}"
           data-toggle="tooltip" data-placement="left" title="{{ trans('tooltips.delete') }}"><i
                    class="fa fa-trash"></i></a>
    @endif
@endif
<td class="hidden">
    @if($item->trashed())
        0
    @else
        1
    @endif
</td>
@section('component-script-recycle')

    <script>
        /*
         'l' - Length changing
         'f' - Filtering input
         't' - The table!
         'i' -Information
         'p' - Pagination
         'r' - pRocessing
         */
        var table = $('.table');
        var filterHtml = ' <div class="col-md-2 form-group remove-padding-left"><label>{!! trans('filter.record_status') !!}</label><select class="form-control trash-filter"><option value="all">All</option><option value="enabled" selected>Enabled</option><option value="disabled">Disabled</option> </select></div>';

        table.find('thead').find('tr').append($('<th class="hidden"></th>')); //

        var oTable = $(table).dataTable({
            "sDom": 'Rfrtpil',
            "aoColumnDefs": [
                    {!! isset($ColumnDefs) ? $ColumnDefs : "{'aTargets': [0]}"  !!}
            ],
            "oLanguage": {
                "sLengthMenu": "Show _MENU_ Rows",
                "sSearch": "",
                "oPaginate": {
                    "sPrevious": "",
                    "sNext": ""
                }
            },
            "bStateSave": true,
            "aaSorting" : [ {!! isset($sortIndex) ? $sortIndex : "[ 0 , 'asc']"  !!}],
            "bSortClasses": false,
            "aLengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 10
        });
        var wrapper = $('.dataTables_wrapper');
        wrapper.find('.dataTables_filter input').addClass("form-control").attr("placeholder", "Search");
        wrapper.find('.dataTables_filter input').parent().prepend('Search');

        //$('.dataTables_filter').prepend($(filterHtml));
        $('.bg-white').find('.col-md-12').eq(0).prepend(filterHtml);


        $('.dataTables_length').find('label').first().css('float: right;');

        $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var filterval = $('.trash-filter').val();
                    var last_td = $('.table tr:first').find('th:last').index();
                    var tdval = data[last_td];
                    if (filterval == 'enabled') {
                        if (tdval == '1') {
                            return true;
                        }
                    }

                    else
                    if (filterval == 'disabled') {
                        if (tdval == '0') {
                            return true;
                        }
                    }
                    else {
                        return true;
                    }
                }
        );

        $('.trash-filter').change(function () {
            oTable.dataTable().fnDraw();
        });


        table.on('click', '.delete-item', function (e) {
            tr = $(this).closest('tr');

            var itemId = $(this).attr('data-id');
            var thisobj = $(this);
            var parent = $(this).parent();


            swal({
                showLoaderOnConfirm: true,
                title: "{{ trans('controls.delete-item.title') }}",
                text: "{{ trans('controls.delete-item.text') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#007AFF",
                confirmButtonText: "{{ trans('controls.delete-item.confirm') }}",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    url: '{{str_replace('-1','',route($entity.'.destroy',-1))}}' + itemId,
                    headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                    error: function (response) {
                        swal(response.statusText,(response.status==403 ? '{{trans('error_page.messages')}}' : response.responseText));
                    },
                    success: function (response) {
                        if (response.success == 'true') {
                            //tr.remove();
                            thisobj.remove();
                            parent.append('<a href="javascript:void(0)" class="btn btn-transparent btn-xs restore-item" data-id="' + itemId + '" data-toggle="tooltip" data-placement="left" title="Restore"><i class="fa fa-recycle"></i></a>');
                            parent.parent().find('td:last').html('0');
                            $('.table').DataTable().destroy();
                            $('.table').dataTable({"sDom": 'Rfrtpil'}).fnDraw();
                            $('.dataTables_wrapper').find('.dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
                            swal("{{trans((isset($trans) ? $trans: $entity).'.index.delete_validation')}}", "{{trans((isset($trans) ? $trans: $entity).'.index.delete_msg')}}", "success");
                        } else {
                            swal("Cancelled", "{{trans((isset($trans) ? $trans: $entity).'.index.delete_unable')}}")
                            toastr.error('{{trans((isset($trans) ? $trans: $entity).'.index.delete_unable')}}', '{{trans((isset($trans) ? $trans: $entity).'.index.error')}}');
                        }
                    },
                    type: 'DELETE'
                });
            });
            e.preventDefault();
        });

        table.on('click', '.restore-item', function (e) {
            e.preventDefault();
            tr = $(this).closest('tr');
            var thisobj = $(this);
            var parent = $(this).parent();
            var itemId = $(this).attr('data-id');
            swal({
                showLoaderOnConfirm: true,
                title: "{{ trans('controls.restore-item.title') }}",
                text: "{{ trans('controls.restore-item.text') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#007AFF",
                confirmButtonText: "{{ trans('controls.restore-item.confirm') }}",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    url: '{{str_replace('-1','',route($entity.'.restore',['slug'=>auth()->user()->slug,-1]))}}' + itemId,
                    headers: {'X-XSRF-TOKEN': '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}'},
                    error: function (response) {
                        swal(response.statusText,(response.status==403 ? '{{trans('error_page.messages')}}' : response.responseText));
                    },
                    success: function (response) {
                        if (response.success == 'true') {
                            //tr.remove();
                            thisobj.remove();
                            parent.append('<a href="javascript:void(0)" class="btn btn-transparent btn-xs delete-item" data-id="' + itemId + '" data-toggle="tooltip" data-placement="left" title="{{ trans('tooltips.delete') }}"><i class="fa fa-trash"></i></a>');
                            parent.parent().find('td:last').html('1');
                            $('.table').DataTable().destroy();
                            $('.table').dataTable({"sDom": 'Rfrtpil'}).fnDraw();
                            $('.dataTables_wrapper').find('.dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
                            swal("{{trans((isset($trans) ? $trans: $entity).'.index.restore_validation')}}", "{{trans((isset($trans) ? $trans: $entity).'.index.restore_msg')}}", "success");
                        } else {
                            swal("Cancelled", "{{trans((isset($trans) ? $trans: $entity).'.index.restore_unable')}}")
                            toastr.error('{{trans((isset($trans) ? $trans: $entity).'.index.restore_unable')}}', '{{trans((isset($trans) ? $trans: $entity).'.index.error')}}');
                        }
                    },
                    type: 'POST',
                    data: {
                        id: itemId
                    }
                });
            });

        });

        $("body").on("keyup", ".input-sm", function () {
            if (($('.trash-filter').val() == 'enabled' || $('.trash-filter').val() == 'disabled') && ($('.input-sm').val() == "")) {
                var status = $('.trash-filter').val();
                $('.trash-filter').val('all');
                $('.trash-filter').change();
                $('.trash-filter').val(status);
                $('.trash-filter').change();
            }
        });
        //initialize
        oTable.dataTable().fnDraw();


        $("body").find('input[type=search]').first().css('margin-top','25px;');

    </script>
@endsection