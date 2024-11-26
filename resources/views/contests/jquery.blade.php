<script>
    function checkAll() {
        var status = $('#checkAll').is(":checked") ? true : false;

        $(".contest_checkbox_id").prop("checked", status);
        all_selected_check_boxes();
    }

    function all_selected_check_boxes() {
        var all_seltd = [];

        $("input:checkbox[name=all_ids]:checked").each(function() {
            all_seltd.push($(this).val());
        });
        var all_sel_val = all_seltd.join(",");
        $('#all_ids_excell').val(all_sel_val);
        $('#all_ids_csv').val(all_sel_val);
        $('#all_ids_pdf').val(all_sel_val);
    }

    function submit_form(form_id, field_id, typeval) {

        var type = $('#' + typeval).val();
        if (type == 'All') {
            $('#' + form_id).submit();
        } else {
            var field_id_val = $('#' + field_id).val();
            if (field_id_val == '' || field_id_val == null) {
                alert('Please checke minimum one checkbox from left side check boxes');
            } else {
                $('#' + form_id).submit();
            }
        }

    }

    function error_msg_clear() {
        $('.error_msg').html('');
    }


    ClassicEditor
    .create(document.querySelector('#description'))
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });
  
    var start = moment().subtract(29, "days");
var end = moment();

function cb(start, end) {
    $("#kt_daterangepicker_4").html(start.format("MMMM D, YYYY HH:mm:ss") + " - " + end.format("MMMM D, YYYY HH:mm:ss"));
}

$("#kt_daterangepicker_4").daterangepicker({
    startDate: start,
    endDate: end,
    timePicker: true,
    timePickerIncrement: 10,
    locale: {
        format: 'MMMM D, YYYY HH:mm:ss'
    },
    ranges: {
    "Today": [moment(), moment()],
    "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
    "Last 7 Days": [moment().subtract(6, "days"), moment()],
    "Last 30 Days": [moment().subtract(29, "days"), moment()],
    "This Month": [moment().startOf("month"), moment().endOf("month")],
    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
    }
}, cb);

cb(start, end);

    var newForm = $('.add-new-modal');

    if (newForm.length) {


        newForm.on('submit', function(e) {

            e.preventDefault();

            error_msg_clear();


            $('#modal_add').html('Sending..');


            var formData = new FormData(this);

            $.ajax({
                beforeSend: function() {
                    $('.ajax-loader').css("visibility", "visible");
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //data: $('#postForm').serialize(),
                url: '{{ route('contests.store') }}',
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {

                    if (data.type == 'error') {

                        $('#modal_add').html('Save');

                        var all_errors = data.all_errors;

                        for (var p = 0; p < all_errors.length; p++) {
                            var temp = all_errors[p];
                            $('#' + temp.error_id).html(temp.message);
                            $('#' + all_errors[0].id).focus();

                        }


                    } else {


                        $('#search_btn').trigger('click');
                        //  $('body').removeClass('modal-open');
                        // $('body').css('padding-right', '0px');
                        // $('.modal-backdrop').remove();
                        $('#name').val('');
                        $('#description').val('');
                        $('#category_id').val('');
                        $('#platform_id').val(''); 

                        $('#result_link').val('');
                        //$('#cta_type').val('');
                        $('#cta_link').val(''); 
                        $('#file').val('');                        
                        $("#file").attr("src","");
                      

                        $('#modal_add').html('Save');
                        $('#modals-add').modal('hide');

                    }





                },
                error: function(data) {
                    alert('error');
                    alert(JSON.stringify(data));

                    $('#modal_add').html('Save Changes');

                    //newGameSidebar.modal('hide');
                    $('#search_btn').trigger('click');
                    $('body').removeClass('modal-open');
                    $('body').css('padding-right', '0px');
                    $('.modal-backdrop').remove();

                },
                complete: function() {
                    $('.ajax-loader').css("visibility", "hidden");
                }
            });




        });
    }

    function changetype(ty)
    {
        $('#Tel_div').hide();
        $('#Link_div').hide();
        $('#Email_div').hide();
        $('#WA_div').hide();
        $('#'+ty+'_div').show();
    }


    function confirm_delete_button(form_id) {
        var confirmstatus = confirm('Are you confirm to delete ?');
        if (confirmstatus) {
            $('#' + form_id).submit();
        }
    }
</script>
