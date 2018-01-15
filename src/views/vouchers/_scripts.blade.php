<script type="text/javascript">

    $(function(){

        var entry_details = [];
        var index         = 0;
        var totalCredit   = 0;
        var totalDebit    = 0;

        totalDebit  = ($("#totalDebit").data('debit')) ? parseInt($("#totalDebit").data('debit'), 10) : 0;
        totalCredit = ($("#totalCredit").data('credit')) ? parseInt($("#totalCredit").data('credit') , 10) : 0;

        $("#vouchers-form").validate({

            rules: {
                voucher_type_id: "required",
            },

            messages: {

                voucher_date: "Please select voucher type ",
            },
            submitHandler: function(form) {
//                form.submit();
            }
        });


        $("#add").on('click' , function(e){
            e.preventDefault();

            var details = $("#entry_details");
            if(details.find('.account_id').val()){

                /* Insert new row at last  */
                AddTableRow(details);
            }else{
                swal({
                    text: "Please select account !",
                });
            }

        });

        $(document).on('click' ,'.delete', function(e){
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
                    $(this).parent("tr:first").remove();
                    swal("Deleted!", "Voucher details has been deleted!", "success");
                    updateTotalDebitCreditBalance();
                }
            });
            
            
        });

        $(document).on('submit', "#vouchers-form", function(e){

            var form = $("#vouchers-form");
            if(form.valid()){

                var $this = $(this);
                e.preventDefault();

                entry_details.length = 0;
                index = 0;

                $('tr.details').each(function(i, tr) {
                    AddDetails($(this));
                });
                console.log(entry_details);
                if(totalDebit != totalCredit){

                    swal({
                        text: "Please Balance Debit or Credit!",
                    });

                    return false;

                }

                var formData = new FormData($('#vouchers-form')[0]);

                var count = 1;

                $('tr.files').each(function(i, tr) {

                    var $this = $(this);
                    var fileSelect = document.getElementById(count+++'file-select');
                    var files = fileSelect.files;

                    for (var i = 0; i < files.length; i++) {

                        var file = files[i];
                        formData.append('files[]', file, file.name);
                    }

                    formData.append('fileName[]', $this.find('.fileName').text());
                });

                formData.append('voucher_date', $('input[name=voucher_date]').val());
                formData.append('remarks', $('#fc-remarks').val());
                formData.append('voucher_type_id', $("#voucher_type_id option:selected").val());
                formData.append('details' ,  JSON.stringify(entry_details));

                var url = $this.attr( 'action' );
                var method = $('#method').val();
                $.ajax({
                    url:url,
                    type:method,
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(res){

                        entry_details.length = 0;
                        index = 0;
                        $('tr.details').remove();
                        $("#entry_details").find("input[type=text]").val("");

                            window.location.replace(res);

                    },
                    error: function(res){
                        console.log(res);
                    }
                })
            }

        });

        $(document).on('submit', "#vouchers-update-form", function(e){


            var form = $("#vouchers-update-form");
            e.preventDefault();
            e.stopPropagation();
            if(form.valid()){

                var $this = $(this);


                entry_details.length = 0;
                index = 0;

                $('tr.details').each(function(i, tr) {
                    AddDetails($(this));
                });
                if(totalDebit != totalCredit){

                    swal({
                        text: "Please Balance Debit or Credit!",
                    });

                    return false;

                }
                var count = 1;

                var formData = new FormData();
                formData.append('voucher_date', $('input[name=voucher_date]').val());
                formData.append('remarks', $('#fc-remarks').val());
                formData.append('voucher_type_id', $("#voucher_type_id option:selected").val());
                formData.append('details' ,  JSON.stringify(entry_details));

                var url = $this.attr('action');
                $.ajax({
                    url:url,
                    type:"POST",
                    headers: { 'X-XSRF-TOKEN' : '{{\Illuminate\Support\Facades\Crypt::encrypt(csrf_token())}}' },
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(res){

                        entry_details.length = 0;
                        index = 0;
                        $('tr.details').remove();
                        $("#entry_details").find("input[type=text]").val("");

                            window.location.replace(res);

                    },
                    error: function(res){
                        console.log(res);
                    }
                })
            }

        });


        function AddDetails($this) {

            var data = {};
            data.account_id   = $this.find('.account_id').text();
            data.cheque_no    = $this.find('.cheque_no').text();
            data.narration    = $this.find('.narration').text();
            data.debit        = $this.find('.debit').text();
            data.credit       = $this.find('.credit').text();
            entry_details[index] = data;
            index++;

        }

        function AddTableRow(details) {

            var debit  = parseInteger(details.find('.debit').val());
            var credit = parseInteger(details.find('.credit').val());

            if((debit + credit) > 0){

                $('#vouchers tr:last').after(

                    '<tr class="details">' +
                        '<td class="account_id">'+ details.find('.account_id').val() +'</td>' +
                        '<td>'+ details.find('.account_id option:selected').text() +'</td>' +
                        '<td class="cheque_no">'+ details.find('.cheque_no').val() +'</td>' +
                        '<td colspan="2" class="narration">'+ details.find('.narration').val() +'</td>' +
                        '<td class="debit">'+ debit +'</td>' +
                        '<td class="credit">'+ credit +'</td>' +
                        '<td class="delete"> ' +
                            '<a class=" btn btn-danger btn-sm" href="javascript:;">' +
                            'Delete'+
                            '</a>'+
                        '</td>' +
                    '</tr>'
                );

                /* Clear inputs  */
                details.find(".cheque_no").val("");
                details.find("input[type=number]").val(0);
                

            }else{
                swal({
                    text: "Please Enter Debit or Credit !",
                });
            }

            updateTotalDebitCreditBalance();
            if(totalDebit == totalCredit){
                details.find(".narration").val("");
            }
        }

        $("#update").on('click' , function(e){

            var details = $("#entry_details");
            var data = {};

            data.voucher_id = parseInt($("#voucher_id").val(), 10);
            data.account_id = $("#account_id option:selected").val();
            data.cheque_no  = details.find('.cheque_no').val();
            data.narration  = details.find('.narration').val();
            data.debit      = parseInt(details.find('.debit').val() , 10);
            data.credit     = parseInt(details.find('.credit').val(), 10);

            if((data.debit + data.credit) > 0){

                var id = $("#details_id").val() ? $("#details_id").val() : 0 ;
                $.ajax({
                    url:"{{url('voucher-details')}}" + "/" + id,
                    type:"PATCH",
                    data: data,
                    success: function(res){

                        if(details.find('.account_id').val()){

                            /* Insert new row at last  */
                            AddTableRow(details);
                        }else{
                            swal({
                                text: "Please select account !",
                            });
                        }
                        swal({
                            icon: "success",
                        });
                    },
                    error: function(res){
                        console.log(res);
                    }
                })
            }
        });

        function updateTotalDebitCreditBalance()
        {
            totalDebit = 0;
            totalCredit = 0;

            $("#totalDebit").text("");
            $("#totalCredit").text("");

            $("#vouchers tr.details").each(function (ix, tr) {

                totalDebit  += parseInt($(this).find('.debit').text(),10);
                totalCredit += parseInt($(this).find('.credit').text(),10);

            });

            var difference = (totalCredit - totalDebit);
            var amount     = Math.abs(difference);

            (difference > 0) ? $("#debitInput").val(amount) : $("#creditInput").val(amount);

            $("#totalDebit").text(totalDebit);
            $("#totalCredit").text(totalCredit);

        }

        $('#debitInput , #creditInput').on('focusout' , function(event){
            
            var target   = $( event.target );
            var debit    = $("#debitInput");
            var credit   = $("#creditInput"); 
            var amount   = $(this).val();
           if(amount > 0){
               if ( target.is( debit )) {

                    credit.val(0);

               }else if(target.is( credit )){
                   
                    debit.val(0);                
               }
            }
        })

        function parseInteger(val){
            if(val){
                
                return parseInt(val , 10);
            }
            return 0;
        }

        $('#account_id').select2({
            ajax: {
                url: '{{route("accounts_search")}}',
                dataType: 'json',
                cache: true,
                delay: 250,
                processResults: function (data) {
                // Tranforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                }
            }
        });

        fileCount = 1;



        $(document).on('click', '#addFiles', function (e) {
                addFiles();
        });


        $(document).on('click', '.deleteVoucherFile', function (e) {
            $(this).closest('.files').remove();
        });


          $("#date").datepicker('setDate', new Date());

        var startOfMonth  = moment().startOf('month').subtract(2, "days").format('MM/DD/YYYY');
        var endOfMonth  = moment().endOf('month').format('MM/DD/YYYY');
        var now = moment().format('MM/DD/YYYY');

        $("#date").datepicker({
            startDate: startOfMonth,
            endDate  : endOfMonth,
        });

        var date = $("#edit_date").val();
        var startOfMonth  = moment(date).startOf('month').format('MM/DD/YYYY');
        var endOfMonth  = moment(date).endOf('month').format('MM/DD/YYYY');

        $("#edit_date").datepicker({
            startDate: startOfMonth,
            endDate  : endOfMonth,
        });
    })

    function addFiles() {

        var fileName = $("#fileName").val();
        var clone    = $("#file").clone();

        clone.attr('class', 'hidden');
        clone.attr('name', 'files[]');
        clone.attr('id', fileCount+'file-select');

        $('#files').append(
            '<tr class="files">' +
                '<td>'+ fileCount++ +'</td>'+
                '<td class="fileName">'+ fileName +'</td>'+
                '<td class="text-right">' +
                    '<button type="button" class="deleteVoucherFile btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
                '</td>'+
            '</tr>');

        $(clone).appendTo('#files tr:last');

        $("#fileName").val('');
        $("#file").val('');
    }
</script>