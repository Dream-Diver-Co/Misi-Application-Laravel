@extends('adminlte::page')
@section('content')

    <div class="pt-5">
        {{-- <h1>Heranmelding</h1> --}}

        <div class="mt-2 datatable-container">
            <x-adminlte-datatable id="patientsTable" :heads="$heads" striped hoverable bordered with-buttons beautify
                with-footer>
                @foreach ($config['data'] as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td>{!! $cell !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop

@section('css')
    <style>
        table.dataTable td,
        table.dataTable th {
            padding: 5px 5px;
            width: 1px;
            white-space: nowrap;
        }

        .column-search-input::placeholder {
            text-align: center;
        }
    </style>
@stop

@section('js')

    <script>
        $(document).ready(function() {
            $('#patientsTable').DataTable().destroy();
            $('#patientsTable tfoot th').each(function(index) {
                if (index != 0) {
                    var title = $(this).text();
                    $(this).html('<input type="text" placeholder="Search ' + title +
                        '" class="form-control column-search-input" />');
                    $('.column-search-input').each(function() {
                        var placeholder = $(this).attr('placeholder');
                        var placeholderLength = placeholder.length;

                        // Calculate the minimum width based on placeholder length
                        var minWidth = placeholderLength * 10 +
                            'px'; // Adjust the multiplier to suit your needs

                        $(this).css('min-width', minWidth);
                    });
                }

            });
            $('#patientsTable th').css('text-align', 'center');
            $('#patientsTable').DataTable({
                initComplete: function() {
                    // Apply the search
                    this.api()
                        .columns()
                        .every(function() {
                            var that = this;

                            $('input', this.footer()).on('keyup change clear', function() {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });
                },
                scrollX: true, // Enable horizontal scrolling
                fixedHeader: true,
                scrollY: '50vh',
                scrollCollapse: true,
                paging: true,
                dom: 'Bftip',
                buttons: [
                    'pageLength', 'copy', 'excel', 'pdf', 'print', 'colvis'
                ]
            })

            $('#patientsTable').DataTable().on('click', '.assign-me', function() {
                var row = $(this).closest('tr');
                var rowData = $('#patientsTable').DataTable().row(row).data();
                var assignedToCell = row.find(
                    'td:eq(2)'); // Adjust the index based on the assigned to column position
                var authUserId = "{{ Auth::id() }}";

                // You can also make an AJAX request to update the assigned_to value in the database if needed
                // Example AJAX request:
                console.log($(this).data('row-id'));

                $.ajax({
                    url: '/update-assigned-to', // Your update route
                    type: 'GET',
                    data: {
                        rowId: $(this).data('row-id'),
                        assignedTo: authUserId
                    },
                    success: function(response) {
                        // Handle success response
                        // Update the assigned_to cell with the authenticated user's ID (Assuming you are using Laravel's Auth)

                        assignedToCell.html(
                            '<span class="d-inline-block badge badge-success badge-pill badge-lg owned" style="cursor: pointer">Owned</span>'
                        );
                        console.log(response);

                    },
                    error: function(xhr) {
                        // Handle error response
                        console.log(xhr);
                    }
                });

            });
        });
    </script>

@endsection
