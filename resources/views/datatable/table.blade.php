@extends('masterPage')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h5>{{ ucfirst( str_replace(['_','-'], ' ', $pageTitle) ) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
&nbsp;
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table">
                        <thead>
                            <tr>
                                @foreach($tableColumns as $column)
                                    <th> @lang('table.'.$column)</th>
                                @endforeach
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loader" style="display: none;">
    <img src="{{ asset('loading.gif') }}" width="100" alt="Loading">
</div>

<!-- Modal -->
<div class="modal fade hide" id="user_view" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title"></h5>
        </div>
        <div class="modal-body">
           <table class="table">
             <tr>
                <td class="bold" width="30%">Full Name</td>
                <td id="full_name"></td>
             </tr>
             <tr>
                <td class="bold" width="30%">User Name</td>
                <td id="user_name"></td>
             </tr>
             <tr class="bold" width="30%">
                <td>Mobile Number</td>
                <td id="phone"></td>
             </tr>
             <tr class="bold" width="30%">
                <td>Email</td>
                <td id="email"></td>
             </tr>
           </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="modal_close">Close</button>
        </div>
      </div>
    </div>
</div>

<script type="module">
    let table;
    $(document).ready(function() {
        $.noConflict();
        table = $('#table').DataTable({
            processing: false,
            serverSide: true,
            ajax:{
                url: '{{ isset($dataTableUrl) && !empty($dataTableUrl) ? $dataTableUrl : URL::current() }}',
                beforeSend: function() {
                    $('#loader').show();
                },
                complete: function() {
                    $('#loader').hide();
                }
            },
            columns: [
                @foreach($dataTableColumns as $column)
                    { data: '{{ $column }}', name: '{{ $column }}' },
                @endforeach
            ],
            "pageLength": 50,
            "lengthMenu": [[50, 100, -1], [50, 100, "All"]],
            oLanguage: {
               sLengthMenu: "_MENU_",
            },
            language: { search: "" },
            dom: 'lBfrti',
            buttons: [
                {
                    extend: 'collection',
                    text: 'Export',
                    buttons: [
                        'copy',
                        'csv',
                        'excel',
                        'pdf',
                        'print',
                    ],
                    fade: false
                },
                {
                    extend: 'collection',
                    text: '<i class="fa-solid fa-arrows-rotate"></i>',
                    action: function (e, dt, node, config) {
                        dt.ajax.reload();
                    },
                    className: 'btn-refresh'
                }
            ],
        });
    });
</script>

@endsection
