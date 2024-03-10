@extends('adminlte::page')

@section('content')

    <div class="pt-5">
        <div class=" pull-right">
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Create Question
            </button>
        </div>

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

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('questions.store') }}" id="create-question-form">

                        @csrf
                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="select-type" class="col-5 text-right">Select Type:</label>
                                    <div class="col-7">
                                        <select class="form-control form-control-sm" id="select-type" name="select-type">
                                            <option value="">Select Type</option>
                                            <option value="1">PiB</option>
                                            <option value="2">PiT</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="select-answer-type" class="col-5 text-right">Select Answer Type:</label>
                                    <div class="col-7">
                                        <select class="form-control form-control-sm" id="select-answer-type"
                                            name="select-answer-type">
                                            <option value="">Select Answer Type</option>
                                            <option value="text">Text</option>
                                            <option value="number">Number Scale</option>
                                            <option value="check">Check</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="options" class="col-2 text-right">Options:</label>

                                    <div class="col-10">
                                        <input type="text" class="form-control form-control-sm" id="options"
                                            name="options">
                                        <small>Options must be seperated with comma (ex: option1, option2)</small>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="question" class="col-2 text-right">Question:</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control form-control-sm" id="question"
                                            name="question">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-primary" id="question-submit">Save Question</button>
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

            document.getElementById('question-submit').addEventListener('click', function() {
                $('#create-question-form').submit()
            });
            $('#create-question-form').submit(function(event) {
                event.preventDefault(); // Prevent form submission

                var formData = $(this).serialize(); // Serialize form data
                console.log(formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                        setTimeout(function() {
                            $('#exampleModalCenter').modal('hide');
                        }, 100);
                        Swal.fire('Success!', 'Question Saved Successfully', 'success');
                    },
                    error: function(xhr) {
                        // Handle error response
                        console.log(xhr.responseText);
                        Swal.fire('Error!', 'Request failed', 'error');
                    }
                });
            });
        });
    </script>

@endsection
