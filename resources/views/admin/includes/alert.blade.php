<?php
  $type = '';
  $message = '';
  if(session('success')){
     $type = 'success';
     $message = session('success');
     clear_alert($type);
  }

  elseif(session('warning')){
     $type = 'warning';
     $message = session('warning');
     clear_alert($type);
  }

  elseif(session('error')){
     $type = 'error';
     $message = session('error');
     clear_alert($type);
  }

  elseif(session('info')){
     $type = 'info';
     $message = session('info');
     clear_alert($type);
  }

?>


<script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        var message = "{{ addslashes($message) }}";
        var type = "{{ $type }}";

        if (type === 'success') {
            toastr.success(message);
        } else if (type === 'warning') {
            toastr.warning(message);
        } else if (type === 'info') {
            toastr.info(message);
        } else if (type === 'error') {
            toastr.error(message);
        }
   });
</script>