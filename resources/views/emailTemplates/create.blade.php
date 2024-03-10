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

            <form method="POST" action="{{ route('email-templates.store') }}" id="create-email-form" class="">
                @csrf
                <div class="row justify-content-between">
                    <div class="col-md-12 justify-content-end">

                        <div class="form-group row">
                            <label for="email-name" class="col-1 text-right">Email Name:</label>
                            <div class="col-11"><input type="text" class="form-control form-control-sm" id="email-name"
                                    name="email-name"></div>
                        </div>

                        <div class="form-group row">
                            <label for="select-type" class="col-1 text-right">Select Mail Type:</label>
                            <div class="col-11">
                                <select class="form-control form-control-sm" id="select-type" name="select-type">
                                    <option value="type 1">Type 1</option>
                                    <option value="type 2">Type 2</option>
                                    <option value="type 3">Type 3</option>

                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email-subject" class="col-1 text-right">Email Subject:</label>
                            <div class="col-11"><input type="text" class="form-control form-control-sm"
                                    id="email-subject" name="email-subject"></div>
                        </div>
                        <div class="form-group row">
                            <label for="email-body" class="col-1 text-right">Email Body:</label>
                            <div class="col-11">
                                <textarea class="form-control" id="email-body" name="email-body"></textarea>
                            </div>
                        </div>


                    </div>

                </div>
            </form>

        </div>
    </div>

@stop

@section('js')
    <script>
        $(document).ready(function() {
            $.getScript('https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js', function() {
                $('#email-body').summernote();


            });

            document.getElementById('top-submit-button').addEventListener('click', function() {
                $('#create-email-form').submit()
            });
            $('#create-email-form').submit(function(event) {
                event.preventDefault(); // Prevent form submission

                var formData = $(this).serialize(); // Serialize form data
                // console.log(formData);

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        Swal.fire('Success!', 'Email template created', 'success');

                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        Swal.fire('Error!', 'Request failed', 'error');
                    }
                });
            });

            $('.go-back').click(function() {
                history.go(-1); // Go back one page
                console.log('click back button')
            });
        });
    </script>

@stop
