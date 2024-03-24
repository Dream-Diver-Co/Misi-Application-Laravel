@extends('adminlte::page')

@section('content')
    <div class="d-flex justify-content-between align-items-center w-100 sticky-top"
        style="min-height: 10px; background-color: #fff;">
        <div>
            <div class="d-flex flex-direction-row button-container">
                <button class="top-button go-back">Go Back</button>
                <button class="top-button top-submit-button" id="top-submit-button">Submit</button>

            </div>
        </div>
        <div>

        </div>
    </div>
    <div class="p-5">
        {{-- <h1>User Management</h1> --}}
        <div class="">

            <form method="POST" action="{{ route('ticket-appointments.store') }}" id="create-appointment-form"
                class="">
                @csrf
                <div class="row justify-content-between">
                    <div class="col-md-6 justify-content-end">

                        <div class="form-group row" style="display: none">
                            <p class=" col-5 text-right"></p>
                            <p class="ticket-id-selected col-7 " style="color: blue" ></p>
                        </div>

                        <div class="form-group row">
                            <label for="select-ticket" class="col-5 text-right">Slected Ticket:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="select-ticket" name="select-ticket">
                                    <option value="">Select Ticket</option>
                                    @foreach ($tickets as $ticket)
                                        <option value="{{ $ticket->id }}">Ticket {{ $ticket->id }}</option>
                                    @endforeach


                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>


                        <div class="form-group row" id="appointment-date-group">
                            <label for="appointment-date" class="col-5 text-right">Appointment Date:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="appointment-date"
                                    name="appointment-date">
                            </div>
                        </div>


                        <div class="form-group row" id="appointment-time-group2" style="display: none;">
                            <label for="appointment-time2" class="col-5 text-right">Therapist avilable Time:</label>
                            <div class="col-7">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="appointment-time2"
                                            name="appointment-time2" data-enable-time data-no-calendar placeholder="Select Time" value="" readonly>

                                        <div class="input-group-append " id="compare" data-toggle="modal"
                                                        data-target="#compareTherapist-view-modal">
                                            <div class="input-group-text bg-gradient-primary">
                                                <i class="fas fa-balance-scale"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="form-group row" id="appointment-time-group" style="display: none;">
                            <label for="appointment-time" class="col-5 text-right">Appointment Time:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="appointment-time"
                                    name="appointment-time" data-enable-time data-no-calendar placeholder="Select Time">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="appointment-fee" class="col-5 text-right">Appointment Fee:</label>
                            <div class="col-7"><input type="text" class="form-control form-control-sm"
                                    id="appointment-fee" name="appointment-fee"></div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="language" class="col-5 text-right">Language:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="language" name="language">
                                    <option value="language1">Language 1</option>
                                    <option value="language2">Language 2</option>
                                    <option value="language3">Language 3</option>

                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div> --}}




                    </div>
                    <div class="col-md-6 justify-content-start">


                        <div class="form-group row">
                            <label for="remarks" class="col-5 text-right">Remarks:</label>
                            <div class="col-7"><input type="text" class="form-control form-control-sm" id="remarks"
                                    name="remarks"></div>
                        </div>

                        <div class="form-group row">
                            <label for="select-status" class="col-5 text-right">Select Status:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="select-status" name="select-status">
                                    <option value="active">Active</option>
                                    <option value="cancelled">Canceled</option>

                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="appointment-type" class="col-5 text-right">Appointment Type:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="appointment-type" name="appointment-type">
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>

                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>


                        {{-- <div class="form-group row">
                            <label for="payment-method" class="col-5 text-right">Payment Method:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="payment-method" name="payment-method">
                                    <option value="card">Card</option>
                                    <option value="insurance">Insurance</option>
                                    <option value="cash">Cash</option>

                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <label for="therapist-comment" class="col-5 text-right">Therapist Comment:</label>
                            <div class="col-7"><input type="text" class="form-control form-control-sm"
                                    id="therapist-comment" name="therapist-comment"></div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="appointment-history" class="col-5 text-right">Appointment History:</label>
                            <div class="col-7"><input type="text" class="form-control form-control-sm"
                                    id="appointment-history" name="appointment-history"></div>
                        </div> --}}
                    </div>
                </div>
            </form>

        </div>
    </div>

    @include('extras.therapistCompare_modal_two')

@stop

@section('js')

<script>
    // Function to remove the query parameter from the URL
    function removeTicketIdFromURL() {
        history.replaceState({}, document.title, window.location.pathname);
    }

    // Get the ticket ID from the URL query parameter
    const urlParams = new URLSearchParams(window.location.search);
    const ticketId = urlParams.get('ticket_id');

    // Update the content of the <p> tag with the ticket ID
    document.addEventListener('DOMContentLoaded', function() {
        const ticketIdElement = document.querySelector('.ticket-id-selected');
        if (ticketIdElement && ticketId) {
            ticketIdElement.textContent = "Your selected ticket id is: " + ticketId;
            removeTicketIdFromURL();
        } else if (ticketIdElement) {
            ticketIdElement.style.display = "none"; // Hide the <p> tag if no ticket ID is found
        }

        // Show the parent <div> if it's hidden by default
        const formGroupDiv = document.querySelector('.form-group.row');
        if (formGroupDiv) {
            formGroupDiv.style.display = "block";
        }
    });
</script>






    <script>


        $(document).ready(function() {


            // Hide the appointment date field initially
            $('#appointment-date-group').hide();

            // Listen for changes in the selected ticket field
            $('#select-ticket').change(function() {
                // Get the selected ticket value
                var selectedTicket = $(this).val();

                // Check if the selected ticket is empty or null
                if (selectedTicket === '' || selectedTicket === null) {
                    // Hide the appointment date field
                    $('#appointment-date-group').hide();
                } else {

                    // Show the appointment date field
                    $('#appointment-date-group').show();

                    var selectedTicketId = $(this).val();

                    // ajax query
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

                            var start_time = response.start_time;
                            var end_time = response.end_time;

                            var work_time = start_time + ' - ' + end_time;

                            var appointment_of_therapist_one = response.appointment_of_therapist_one;
                            var therapistId = response.therapistId;


                            //ajax for

                            $('#compare').click(function() {
                                // Run AJAX request using therapistId
                                $.ajax({
                                    url: '/compareAppointment/' + therapistId,
                                    method: 'GET',
                                    success: function(data) {
                                        // Handle success response
                                        console.log(data);

                                        var modalBody = $('#compareTherapist-view-modal').find('.modal-body');
                                        modalBody.empty(); // Clear existing content

                                        // Display therapist's name
                                        modalBody.append('<p>Therapist Name: ' + data.user_with_therapist + ', ID: ' + data.therapistId + '</p>');

                                        // Loop through appointments and display them
                                        $.each(data.appointment_of_therapist_one, function(date, appointments) {
                                            modalBody.append('<strong>' + date + '</strong>');
                                            $.each(appointments, function(index, appointment) {
                                                modalBody.append('<p>' + appointment.date + ' : ' + appointment.time + '</p>');
                                            });
                                        });

                                        // Show the modal
                                        $('#compareTherapist-view-modal').modal('show');
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error response
                                        console.error('Error:', error);
                                    }
                                });
                            });





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
                            flatpickr("#appointment-date", {
                                disable: [
                                    function(date) {
                                        return isDateInLeaves(date) ||
                                            isDateWeeklyHoliday(date);
                                    }
                                ],
                                locale: {
                                    firstDayOfWeek: 1 // Set Monday as the first day of the week (change according to your locale)
                                },

                                onChange: function(selectedDates, dateStr, instance) {
                                    // Check if a date is selected
                                    if (selectedDates.length > 0) {
                                        // Show the appointment time field
                                        $('#appointment-time-group').show();

                                        $('#appointment-time-group2').show();

                                        // Enable timepicker for the selected date
                                        var appointmentTimeInput = document
                                            .getElementById('appointment-time');
                                        flatpickr(appointmentTimeInput, {
                                            enableTime: true,
                                            noCalendar: true,
                                            dateFormat: "H:i:s",
                                            time_24hr: false
                                        });

                                        var appointmentTimeInput2 = document.getElementById('appointment-time2');
                                        appointmentTimeInput2.value = work_time;




                                    } else {
                                        // Hide the appointment time field
                                        $('#appointment-time-group').hide();
                                    }
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle any errors
                            console.error('Error fetching dates and holidays:', error);
                        }
                    });
                    // end query
                    // Dates from the leaves array

                }
            });


            // create appointment and intake
            document.getElementById('top-submit-button').addEventListener('click', function() {
                $('#create-appointment-form').submit()
            });
            $('#create-appointment-form').submit(function(event) {
                event.preventDefault(); // Prevent form submission

                var formData = $(this).serialize(); // Serialize form data
                // console.log(formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: 'Patient succesfully created'
                        // });
                        Swal.fire('Success!', 'Request successful', 'success');

                    },
                    error: function(xhr) {
                        // Handle error response
                        console.log(xhr.responseText);
                        // Toast.fire({
                        //     icon: 'error',
                        //     title: 'Patient not created'
                        // });
                        Swal.fire('Error!', 'Request failed', 'error');
                    }
                });
            });
        });
    </script>
@stop
