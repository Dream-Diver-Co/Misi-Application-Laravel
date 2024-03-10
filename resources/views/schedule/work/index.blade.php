@extends('adminlte::page')


@section('content')
    <div class="pt-5">

        {{-- <div class="pull-right mt-5">
            <a class="btn btn-success" href="{{ route('work.create') }}"> Create New Patient</a>
        </div> --}}
        <div class="mt-2 datatable-container">
            <x-adminlte-datatable id="workTable" :heads="$heads" striped hoverable bordered with-buttons beautify
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
    @include('schedule.work.modals.edit')
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
            $('#workTable').DataTable().destroy();
            $('#workTable tfoot th').each(function(index) {
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
            $('#workTable th').css('text-align', 'center');
            $('#workTable').DataTable({
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



            // $("#pib-form-modal").on("hidden.bs.modal", function () {
            //     $("#pib-pit-table-form").empty();
            // });

            document
                .getElementById("worktimesubmit")
                .addEventListener("click", function() {
                    $("#worktimeform").submit();
                });
            $("#worktimeform").submit(function(event) {
                event.preventDefault(); // Prevent form submission

                var formData = $(this).serialize(); // Serialize form data
                console.log(formData);

                $.ajax({
                    url: '/update-worktime/' + $(this).data('worktime-id'),
                    type: "GET",
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                        Swal.fire("Success!", "Form updated", "success");
                    },
                    error: function(xhr) {
                        // Handle error response
                        console.log(xhr.responseText);
                        Swal.fire("Error!", "Request failed", "error");
                    },
                });
            });

            function fetchWorkTimeInfo(id) {
                $.ajax({
                    url: "/to-fetch-worktime",
                    method: "get",
                    data: {
                        worktimeId: id
                    },
                    success: function(response) {
                        console.log(response);
                        console.log(response.start_time);
                        console.log(response.end_time);
                        console.log("Success");

                        $('#startTimeInput').val(response.start_time)
                        $('#endTimeInput').val(response.end_time)
                        // $('#weekoff').val(response.weekly_off)

                        $('#worktimeform').attr('data-worktime-id', response.id)

                        let days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday',
                            'Saturday'
                        ]

                        var $weekoff = $('#weekoff');

                        // Clear existing options
                        $weekoff.empty();

                        // Add new options
                        console.log(response.weekly_off)
                        days.forEach((day, index) => {
                            isSelected = response.weekly_off.includes(`${index}`);
                            console.log(isSelected)

                            $weekoff.append($('<option></option>').attr('value', index).prop(
                                'selected', isSelected).text(day));
                        });

                        // $weekoff.val(response.weekly_off);

                        // Refresh the Bootstrap Select dropdown



                        $("#worktimeModal").modal("show");

                        $(function() {
                            $('#startTime').datetimepicker({
                                format: 'LT'
                            });

                            $('#endTime').datetimepicker({
                                format: 'LT'
                            });
                        });

                        $weekoff.selectpicker('refresh');

                        $weekoff.selectpicker('val', response.weekly_off)
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    },
                });
            }

            $(".workmodalshow").click(function() {
                let id = $(this).data("worktime-id");


                fetchWorkTimeInfo(id);
            });
        });
    </script>

@stop
