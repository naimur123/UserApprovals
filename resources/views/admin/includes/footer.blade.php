
      </div>
     </div>
   </div>



<!-- jQuery-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.2/datatables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

 <!-- Handson -->
 <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

@include('admin.includes.alert')
<script>
    $(document).ready(function() {
        $('#toggleSidebar').click(function() {
            $('.sidebar').toggleClass('collapsed');
            $('#mainContent').toggleClass('expanded');
        });

        $('#modal_close').click(function(){
            $("#user_view").modal('hide');
        });

        $('select').select2({
            placeholder: "None Selected",
            allowClear: true,
            width: '100%',
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

    });

    /* Toaster Alert */
    function set_alert(type, message) {
        toastr[type](message);
    }

    /* Approve/Reject request */
    function approve_request(id, status, rel_type){
        if(id){
            $.ajax({
                url: '{{ route("pending_list_approve") }}',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    id : id,
                    approve_staus: status,
                    rel_type: rel_type
                },
                success : function(response){
                    if(response.success === true){
                        toastr['success'](response.alert_message);
                        $('#table').DataTable().ajax.reload();
                    }
                }
            })
        }
    }

    /* User view */
    function user_view(user_id){
        if(user_id){
            $.ajax({
                url: '{{ route("get_user") }}',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    id : user_id,
                },
                success : function(response){
                    if(response.success === true){
                        $("#user_view").modal('show');
                        $("#modal_title").text('User Details');
                        $("#full_name").text(response.user.full_name);
                        $("#user_name").text(response.user.user_name);
                        $("#phone").text(response.user.phone);
                        $("#email").text(response.user.email);
                    }
                }
            })
        }
    }

    /* Input Validation */
    function validateInput(inputFields){
        let isValid = true;
        inputFields.forEach(function (fieldName) {
            const input = $(`[name="${fieldName}"]`);

            // $('.error-message').remove();
            // For select elements
            if (input.is('select')) {
                if (input.val() === '') {
                    input.addClass('is-invalid');
                    // input.css('border-color', 'red');
                    // if (input.next('.error-message').length === 0) {
                    //     input.after('<div class="error-message" style="color: red;">This field is required</div>');
                    // }
                    isValid = false;
                } else {
                    input.removeClass('is-invalid');
                }
            } else if (input.is('input')) {
                // For input fields
                if (input.val() === '') {
                    input.addClass('is-invalid');
                    isValid = false;
                } else {
                    input.removeClass('is-invalid');
                }
            }
        });
        return isValid;
    }

    /* Handson table validation */
    function validateHandson(handsonData, from) {
        let isValid = true;
        let message = 'can\'t be empty';

        if (!handsonData.some(row => row.some(cell => cell !== null && cell !== ''))) {
            isValid = false;

            if (from === 'billing') {
                message = 'Billing information ' + message;
            } else if (from === 'technician') {
                message = 'Technician information ' + message;
            }

            set_alert('error', message);
        }
        
        return isValid;
    }    
</script>



</body>

</html>