@extends('adminlte::page')

@section('content')
    <div class="d-flex justify-content-between align-items-center w-100 sticky-top"
        style="min-height: 10px; background-color: #fff;">
        <div>
            <div class="d-flex flex-direction-row button-container">
                <button class="top-button go-back" id="goback">Go Back</button>
                <button class="top-button top-submit-button" id="top-submit-button">Submit</button>


            </div>
        </div>
        <div>

        </div>
    </div>




    <div class="p-5">
        {{-- <h2>Ticket Form</h2> --}}
        <form method="POST" action="{{ route('tickets.store') }}" id="create-ticket-form" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-between">
                <div class="col-md-12 justify-content-end">
                    <div class="container">
                        <input type="file" id="fileInput" class="file-input" name="files[]" accept="image/*,.pdf"
                            multiple />
                        <!-- Allow image and PDF files -->
                        <div id="thumbnailContainer" class="thumbnail-container"></div>
                    </div>
                </div>
            </div>


            {{-- <div class="row justify-content-between">
                <div class="col-md-12 justify-content-end">
                    <input type="file" name="files[]" id="multifileInput" multiple>
                    <div id="fileList"></div>
                </div>
            </div> --}}


            <div class="row justify-content-between">

                <!-- First Column -->
                <div class="col-md-6 justify-content-end">



                    <div class="form-group row">
                        <label for="select-department" class="col-5 text-right">Select Therapist:</label>
                        <div class="col-7">
                            <select class="form-control form-control-sm selectpicker" id="select-patient"
                                name="select-patient" data-live-search="true">
                                <option value="">Select Therapist</option>
                                @foreach ($therapists as $therapist)
                                    <option value="{{ $therapist->id }}">
                                        {{ $therapist->user()->first()->name ? $therapist->user()->first()->name : $therapist->user()->first()->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="startTime" class="col-5 text-right">Start Time:</label>
                        <div class="col-7">
                            {{-- <input type="time" name="start-time" id="start-time" class="form-control form-control-sm timepicker" placeholder="Choose a time..." value="09:00:00"> --}}

                            <div class="input-group date" id="startTime" data-target-input="nearest">
                                <input type="text"
                                    class="form-control form-control-sm datetimepicker-input"
                                    data-target="#startTime" id="startTimeInput" name="start-time" />
                                <div class="input-group-append" data-target="#startTime"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>





                </div>


                <!-- Second Column -->
                <div class="col-md-6">

                    <div class="form-group row">
                        <label for="weekoff" class="col-3 text-right">Weekly Off:</label>
                        <select name="weeklyoff[]" id="weekoff"
                            class="form-control from-control-sm col-8 selectpicker" multiple>

                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="endTime" class="col-5 text-right">End Time:</label>
                        <div class="col-7">
                            {{-- <input type="time" name="start-time" id="start-time" class="form-control form-control-sm timepicker" placeholder="Choose a time..." value="09:00:00"> --}}

                            <div class="input-group date" id="endTime" data-target-input="nearest">
                                <input type="text"
                                    class="form-control form-control-sm datetimepicker-input"
                                    data-target="#endTime" id="endTimeInput" name="end-time" />
                                <div class="input-group-append" data-target="#endTime"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>







                </div>
            </div>
            {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
        </form>
    </div>
@stop

@section('js')
    <script>
        // submit form
        $(document).ready(function() {
            document.getElementById('top-submit-button').addEventListener('click', function() {
                $('#create-ticket-form').submit()
            });
            $('#create-ticket-form').submit(function(event) {
                event.preventDefault(); // Prevent form submission

                var formData = $(this).serialize(); // Serialize form data
                console.log(formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    //data: formData,
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                        Swal.fire('Success!', 'Request successful', 'success');
                    },
                    error: function(xhr) {
                        // Handle error response
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






        // upload attatchment


        document.addEventListener("DOMContentLoaded", function() {
            const fileInput = document.getElementById("fileInput");
            const thumbnailContainer = document.getElementById("thumbnailContainer");
            const showFileInputButton = document.getElementById("showFileInput");

            showFileInputButton.addEventListener("click", function() {
                fileInput.click();
            });

            fileInput.addEventListener("change", function() {
                const selectedFiles = fileInput.files;

                if (selectedFiles.length > 0) {
                    thumbnailContainer.innerHTML = "";

                    for (let i = 0; i < selectedFiles.length; i++) {
                        const fileName = selectedFiles[i].name; // Get file name

                        const thumbnailWrapper = document.createElement("div");
                        thumbnailWrapper.className = "thumbnail-wrapper";

                        const thumbnail = document.createElement("div");
                        thumbnail.className = "thumbnail";

                        const fileNameElement = document.createElement("span");
                        fileNameElement.textContent = fileName; // Display file name

                        const removeIcon = document.createElement("span");
                        removeIcon.innerHTML = "&#10006;"; // Cross symbol (✖)
                        removeIcon.className = "remove-icon";

                        removeIcon.addEventListener("click", function() {
                            thumbnailContainer.removeChild(thumbnailWrapper);
                        });

                        thumbnail.appendChild(fileNameElement);
                        thumbnail.appendChild(removeIcon);

                        thumbnailWrapper.appendChild(thumbnail);
                        thumbnailContainer.appendChild(thumbnailWrapper);
                    }
                } else {
                    thumbnailContainer.innerHTML = "";
                }
            });
        });
    </script>
@stop
