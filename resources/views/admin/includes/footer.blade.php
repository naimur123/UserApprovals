
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

@include('admin.includes.alert')
<script>
    $(document).ready(function() {
        $('#toggleSidebar').click(function() {
            $('.sidebar').toggleClass('collapsed');
            $('#mainContent').toggleClass('expanded');
        });

        $('#modal_close').click(function(){
            $("#user_view").modal('hide');
        })
    });

    /* Approve/Reject request */
    function approve_request(user_id, status){
        if(user_id){
            $.ajax({
                url: '{{ route("approve_pending_user") }}',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    id : user_id,
                    approve_staus: status
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
</script>



</body>

</html>