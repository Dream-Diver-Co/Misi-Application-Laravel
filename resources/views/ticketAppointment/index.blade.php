@extends('adminlte::page')
@section('content')
    <div class="pt-5">
        {{-- <div class="pull-right mt-5">
            <a class="btn btn-success" href="{{ route('patients.create') }}"> Create New Patient</a>
        </div> --}}
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

        @include('ticketAppointment.modals.createIntakeModal')
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


            // MODAL SHOW AND ACTIONS

            $(document).on('click', '.createModal', function() {

                var appointment_id = $(this).data('appointment');
                console.log(appointment_id);
                console.log($('#appointment'));

                $('#appointment').empty();
                var newOption = $('<option>', {
                    value: appointment_id,
                    text: appointment_id
                });
                $('#appointment').append(newOption);

                var selectedTicketId = $(this).data('ticket-id')

                console.log(selectedTicketId);

                $.ajax({
                    url: '/datesandappoints/' + selectedTicketId,
                    method: 'GET',
                    success: function(response) {
                        // Handle the response data
                        console.log(response);
                        var leaves = response.leave_dates;

                        // Weekly holidays value from the database (0: Sunday, 1: Monday, etc.)
                        var weeklyHolidays = response
                            .holidays; // Example: Sunday and Monday

                        // Function to check if a date is in the leaves array
                        function isDateInLeaves(date) {
                            var year = date.getFullYear();
                            var month = date.getMonth() +
                                1; // Months are zero-indexed, so we add 1
                            var day = date.getDate();
                            var dateString = year + '-' + month.toString().padStart(2,
                                    '0') + '-' + day
                                .toString().padStart(2, '0');
                            return leaves.includes(dateString);
                        }


                        // Function to check if a date is a weekly holiday
                        function isDateWeeklyHoliday(date) {
                            var dayOfWeek = date.getDay();
                            return weeklyHolidays.includes(dayOfWeek);
                        }

                        // Initialize the flatpickr
                        flatpickr("#date", {
                            disable: [
                                function(date) {
                                    return isDateInLeaves(date) ||
                                        isDateWeeklyHoliday(date);
                                }
                            ],
                            locale: {
                                firstDayOfWeek: 1 // Set Monday as the first day of the week (change according to your locale)
                            },


                        });

                        flatpickr('#time', {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i:s",
                            time_24hr: false
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors
                        console.error('Error fetching dates and holidays:', error);
                    }
                });

                $('#createIntakeModal').modal('show');
            });

            $('#intakesubmit').click(function() {
                // Get the form data
                var formData = $('#create-intake-form').serialize();

                // Make the AJAX call
                $.ajax({
                    url: $('#create-intake-form').attr(
                        'action'), // Get the form action URL
                    method: 'POST', // Get the form method (e.g., POST)
                    data: formData, // Pass the form data
                    success: function(response) {
                        // Handle the success response
                        console.log(response);
                        Swal.fire('Success!', 'Request successful', 'success');
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'Request failed', 'error');
                    }
                });
            });


        });
    </script>

@endsection
