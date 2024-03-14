@extends('adminlte::page')
@section('content')

    <div class="pt-5">

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


    <div class="modal fade bd-example-modal-lg" id="pib-form-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">PIB FORMULIER</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="pib-pit-form-body">
                    <div>
                        <h6>Pre intake beoordeling (PIB)</h6>
                        <table class="table table-bordered pib-pit-table">

                            <tr>
                                <td class="w-25">
                                    Naam PiB-er:
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-25">
                                    Naam patiënt:
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-25">
                                    Patiëntcode:
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-25">
                                    Soort Legitimatie:
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-25">
                                    Documentnummer:
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-25">
                                    Vervaldatum legitimatie:
                                </td>
                                <td>

                                </td>
                            </tr>
                        </table>
                        <table class="table table-bordered pib-pit-table-2">
                            <tr>
                                <td colspan="2">
                                    <strong>Triageformulier:</strong>
                                    <p style="font-size: 12px;">Wij hebben uw verwijsbrief beoordeeld en hebben aanvullende
                                        vragen die we u willen
                                        stellen om goed een
                                        keuze te kunnen maken of wij u de juiste behandeling kunnen bieden. Het gesprek zal
                                        ongeveer 15minuten
                                        duren. Hierna zullen we u met enkele (2-3 dagen) terugbellen. Mochten wij niet de
                                        goede zorg voor u hebben,
                                        zullen we uitleggen waarom dat zo is en indien mogelijk een andere instelling
                                        adviseren. Wij zijn een
                                        diagnostisch en psychotherapeutisch centrum en verstrekken geen medicatie tijdens de
                                        behandeling. Indien
                                        nodig/nuttig zal tijdens uw behandeling bij ons de huisarts u medicatie geven.</p>
                                </td>
                            </tr>



                        </table>

                        <form id="pib-pit-table-form" method="GET" action="{{ route('update-answer') }}">
                            @csrf

                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" id="pib-print">Print</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-lg" id="pit-form-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">PIT FORMULIER</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="pib-pit-form-body">
                    <div>
                        <h6>Pre intake beoordeling (PIT)</h6>
                        <table class="table table-bordered pib-pit-table">

                            <tr>
                                <td class="w-25">
                                    Naam PiT-er:
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-25">
                                    Naam patiënt:
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-25">
                                    Patiëntcode:
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-25">
                                    Soort Legitimatie:
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-25">
                                    Documentnummer:
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td class="w-25">
                                    Vervaldatum legitimatie:
                                </td>
                                <td>

                                </td>
                            </tr>
                        </table>
                        <table class="table table-bordered pib-pit-table-2">
                            <tr>
                                <td colspan="2">
                                    <strong>Triageformulier:</strong>
                                    <p style="font-size: 12px;">Wij hebben uw verwijsbrief beoordeeld en hebben aanvullende
                                        vragen die we u willen
                                        stellen om goed een
                                        keuze te kunnen maken of wij u de juiste behandeling kunnen bieden. Het gesprek zal
                                        ongeveer 15minuten
                                        duren. Hierna zullen we u met enkele (2-3 dagen) terugbellen. Mochten wij niet de
                                        goede zorg voor u hebben,
                                        zullen we uitleggen waarom dat zo is en indien mogelijk een andere instelling
                                        adviseren. Wij zijn een
                                        diagnostisch en psychotherapeutisch centrum en verstrekken geen medicatie tijdens de
                                        behandeling. Indien
                                        nodig/nuttig zal tijdens uw behandeling bij ons de huisarts u medicatie geven.</p>
                                </td>
                            </tr>



                        </table>

                        <form id="pit2-table-form" method="GET" action="{{ route('update-answer') }}">
                            @csrf

                        </form>

                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-sm btn-primary" id="pit-print">Print</button>
                    {{-- <button type="button" class="btn btn-sm btn-primary" id="pib-pit-submit">Save changes</button> --}}
                </div>
            </div>
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
