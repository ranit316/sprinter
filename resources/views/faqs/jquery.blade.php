<script>
    function checkAll() {
        var status = $('#checkAll').is(":checked") ? true : false;

        $(".faq_checkbox_id").prop("checked", status);
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
        //console.log(editor);
    })
    .catch(error => {
        //console.error(error);
    });
  


   
    $( ".add-new-modal" ).on( "submit", function(e) {


      
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
                url: '{{ route('faqs.store') }}',
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {

                    //alert(data.type);
                    //alert(JSON.stringify(data));

                  
                    if (data.type == 'error') {

                        $('#modal_add').html('Save');

                        var all_errors = data.all_errors;

                        for (var p = 0; p < all_errors.length; p++) {
                            var temp = all_errors[p];
                            $('#' + temp.error_id).html(temp.message);
                            $('#' + all_errors[0].id).focus();

                        }


                    } else {

                        $('#name').val('');
                        $('#description').val('');
                        //
                        //  $('body').removeClass('modal-open');
                        // $('body').css('padding-right', '0px');
                        // $('.modal-backdrop').remove();
                      
                        //$('#category_id').val('');
                      
                      
                        $('#modal_add').html('Save');
                        $('#modals-add').modal('hide');
                        $('#search_btn').trigger('click');

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
    



    function confirm_delete_button(form_id) {
        var confirmstatus = confirm('Are you confirm to delete ?');
        if (confirmstatus) {
            $('#' + form_id).submit();
        }
    }

    $(document).ready(function() {
        $('#answer').hide();
           $('#type').change(function(e) {
               e.preventDefault();
               var type = $(this).val();
               //console.log(state);
               $('#category_id').html('<option value="">Select District</option>');
               var selectedTypeName = $(this).find('option:selected').text();
               if(selectedTypeName == "Support"){
                $('#answer').show();
               }else{
                $('#answer').hide();
               }
               if (type) {
                   $.ajax({
                       type: "GET",
                       url: '{{ route("type.category", ":type") }}'.replace(':type', type),
                       success: function (data) {
                           $.each(data, function (key, value) {
                           $('#category_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                       });
                       //$('.selectpicker').selectpicker('refresh')
                       }
                   });
               }
           });
       });
</script>
