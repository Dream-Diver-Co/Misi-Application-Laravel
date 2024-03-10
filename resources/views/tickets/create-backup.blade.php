@extends('adminlte::page')

@section('content')
    <div class="d-flex justify-content-between align-items-center w-100 sticky-top"
        style="min-height: 10px; background-color: #fff;">
        <div>
            <div class="d-flex flex-direction-row button-container">
                <button class="top-button go-back" id="goback">Go Back</button>
                <button class="top-button " id="showFileInput"> <i class="fas fa-fw fa-solid fa-paperclip"></i></button>
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
                        <label for="select-department" class="col-5 text-right">Select Department:</label>
                        <div class="col-7">
                            <select class="form-control form-control-sm" id="select-department" name="select-department">
                                <option value="{{ $screener->id }}">{{ $screener->name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mono-multi-zd" class="col-5 text-right">Mono/Multi ZD:</label>
                        <div class="col-7"><input type="text" class="form-control form-control-sm" id="mono-multi-zd"
                                name="mono-multi-zd"></div>
                    </div>

                    <div class="form-group row">
                        <label for="zd_id" class="col-5 text-right">ZD_ID:</label>
                        <div class="col-7"><input type="text" class="form-control form-control-sm" id="zd_id"
                                name="zd_id"></div>
                    </div>

                    <div class="form-group row">
                        <label for="mono-multi-screening" class="col-5 text-right">Mono/Multi Screening:</label>
                        <div class="col-7">
                            <input type="text" class="form-control form-control-sm" id="mono-multi-screening"
                                name="mono-multi-screening">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="intakes-therapist" class="col-5 text-right">Intakes/Therapist:</label>
                        <div class="col-7">
                            <input type="text" class="form-control form-control-sm" id="intakes-therapist"
                                name="intakes-therapist">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tresonit-number" class="col-5 text-right">Tresonit Number:</label>
                        <div class="col-7">
                            <input type="text" class="form-control form-control-sm" id="tresonit-number"
                                name="tresonit-number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="datum-intake" class="col-5 text-right">Datum Intake:</label>
                        <div class="col-7"><input type="text" class="form-control form-control-sm" id="datum-intake"
                                name="datum-intake"></div>
                    </div>
                    <div class="form-group row">
                        <label for="datuem-intake-2" class="col-5 text-right">Datuem Intake 2:</label>
                        <div class="col-7">
                            <input type="text" class="form-control form-control-sm" id="datuem-intake-2"
                                name="datuem-intake-2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nd-account" class="col-5 text-right">ND Account:</label>
                        <div class="col-7"><input type="text" class="form-control form-control-sm" id="nd-account"
                                name="nd_account"></div>
                    </div>
                    <div class="form-group row">
                        <label for="avc-alfmvm-sbg" class="col-5 text-right">AvC/AlfmVm/SBG:</label>
                        <div class="col-7">
                            <input type="text" class="form-control form-control-sm" id="avc-alfmvm-sbg"
                                name="avc-alfmvm-sbg">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="honos" class="col-5 text-right">Honos:</label>
                        <div class="col-7"><input type="text" class="form-control form-control-sm" id="honos"
                                name="honos"></div>
                    </div>
                    <div class="form-group row">
                        <label for="berha-intake" class="col-5 text-right">Berha Intake:</label>
                        <div class="col-7"><input type="text" class="form-control form-control-sm" id="berha-intake"
                                name="berha-intake"></div>
                    </div>
                    {{-- <div class="form-group row">
                        <label for="strike-history" class="col-5 text-right">Strike History:</label>
                        <div class="col-7">
                            <textarea class="form-control form-control-sm" id="strike-history" rows="3" name="strike-history"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ticket-history" class="col-5 text-right">Ticket History:</label>
                        <div class="col-7">
                            <textarea class="form-control form-control-sm" id="ticket-history" rows="3" name="ticket-history"></textarea>
                        </div>
                    </div> --}}
                </div>
                <!-- Second Column -->
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="select-department" class="col-5 text-right">Select Patient:</label>
                        <div class="col-7">
                            <select class="form-control form-control-sm selectpicker" id="select-patient"
                                name="select-patient" data-live-search="true">
                                <option value="">Select Patient</option>
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}">
                                        {{ $patient->user()->first()->name ? $patient->user()->first()->name : $patient->user()->first()->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @php
                        $config = ['format' => 'DD-MM-YYYY'];
                    @endphp
                    <div class="form-group row">
                        <label for="rom-start" class="col-5 text-right">ROM Start:</label>
                        <div class="col-7">
                            <x-adminlte-input-date name="rom-start" :config="$config" placeholder="Choose a date..."
                                id="rom-start" class="form-control-sm">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="rom-end" class="col-5 text-right">ROM End:</label>
                        <div class="col-7">
                            <x-adminlte-input-date name="rom-end" :config="$config" placeholder="Choose a date..."
                                id="rom-end" class="form-control-sm">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="berha-eind" class="col-5 text-right">Berha Eind:</label>
                        <div class="col-7">
                            <x-adminlte-input-date name="berha-eind" :config="$config" placeholder="Choose a date..."
                                id="berha-eind" class="form-control-sm">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="vtcb-date" class="col-5 text-right">VTCB Date:</label>
                        <div class="col-7">
                            <x-adminlte-input-date name="vtcb-date" :config="$config" placeholder="Choose a date..."
                                id="vtcb-date" class="form-control-sm">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="closure" class="col-5 text-right">Closure:</label>
                        <div class="col-7">
                            <x-adminlte-input-date name="closure" :config="$config" placeholder="Choose a date..."
                                id="closure" class="form-control-sm">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="aanm-intake" class="col-5 text-right">Aanm Intake 1 (dagentussen):</label>
                        <div class="col-7">
                            <x-adminlte-input-date name="aanm-intake" :config="$config" placeholder="Choose a date..."
                                id="aanm-intake" class="form-control-sm">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="location" class="col-5 text-right">Location:</label>
                        <div class="col-7"><input class="form-control form-control-sm" id="location" name="location">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="call-strike" class="col-5 text-right">Call Strike:</label>
                        <div class="col-7">
                            <select class="form-control form-control-sm" id="call-strike" name="call-strike">
                                <option value="">Select Strike</option>
                                <option value="strike_1">Strike 1</option>
                                <option value="strike_2">Strike 2</option>
                                <option value="strike_3">Strike 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="remarks" class="col-5 text-right">Remarks:</label>
                        <div class="col-7"><input type="text" class="form-control form-control-sm" id="remarks"
                                name="remarks"></div>
                    </div>
                    <div class="form-group row">
                        <label for="comments" class="col-5 text-right">Comments:</label>
                        <div class="col-7"><input type="text" class="form-control form-control-sm" id="comments"
                                name="comments"></div>
                    </div>
                    <div class="form-group row">
                        <label for="language-treatment" class="col-5 text-right">Language Treatment:</label>
                        <div class="col-7">
                            <select class="form-control form-control-sm" id="language-treatment"
                                name="language-treatment">
                                <option value="">Select Language</option>
                                <option value="dutch">Dutch</option>
                                <option value="english">English</option>
                            </select>
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

            // Add click event listener to the "Upload File" button
            showFileInputButton.addEventListener("click", function() {
                // Trigger the file input when the button is clicked
                fileInput.click();
            });

            fileInput.addEventListener("change", function() {
                const selectedFiles = fileInput.files;

                if (selectedFiles.length > 0) {
                    thumbnailContainer.innerHTML = ""; // Clear previous thumbnails

                    // Loop through selected files
                    for (let i = 0; i < selectedFiles.length; i++) {
                        const fileType = selectedFiles[i].type;

                        // Create a container for each thumbnail and button
                        const thumbnailWrapper = document.createElement("div");
                        thumbnailWrapper.className = "thumbnail-wrapper";

                        // Create a thumbnail element
                        const thumbnail = document.createElement("div");
                        thumbnail.className = "thumbnail";

                        if (fileType.startsWith("image/")) {
                            // Display image thumbnails
                            const imgThumbnail = document.createElement("img");
                            imgThumbnail.src = URL.createObjectURL(selectedFiles[i]);
                            thumbnail.appendChild(imgThumbnail);
                        } else if (fileType === "application/pdf") {
                            // Display PDF thumbnails using PDF.js
                            const pdfThumbnail = document.createElement("canvas");
                            thumbnail.appendChild(pdfThumbnail);

                            const reader = new FileReader();
                            reader.onload = function(event) {
                                const pdfData = new Uint8Array(event.target.result);
                                renderPdfThumbnail(pdfThumbnail, pdfData);
                            };
                            reader.readAsArrayBuffer(selectedFiles[i]);
                        } else {
                            // Handle other file types (e.g., documents) here
                            const unsupportedThumbnail = document.createElement("div");
                            unsupportedThumbnail.textContent =
                                "Thumbnail not available for this file type.";
                            thumbnail.appendChild(unsupportedThumbnail);
                        }

                        // Create a remove button for each thumbnail
                        const removeButton = document.createElement("button");
                        removeButton.textContent = "Remove";
                        removeButton.className = "remove-button";

                        // Attach a click event listener to the remove button
                        removeButton.addEventListener("click", function() {
                            thumbnailContainer.removeChild(thumbnailWrapper);
                        });

                        // Append the thumbnail and button to the container
                        thumbnailWrapper.appendChild(thumbnail);
                        thumbnailWrapper.appendChild(removeButton);

                        // Append the container to the main thumbnail container
                        thumbnailContainer.appendChild(thumbnailWrapper);
                    }
                } else {
                    // Hide the thumbnail container if no file is selected
                    thumbnailContainer.innerHTML = "";
                }
            });

            function renderPdfThumbnail(canvas, pdfData) {
                pdfjsLib
                    .getDocument({
                        data: pdfData
                    })
                    .promise.then(function(pdfDocument) {
                        pdfDocument.getPage(1).then(function(page) {
                            const viewport = page.getViewport({
                                scale: 0.5
                            });
                            const context = canvas.getContext("2d");
                            canvas.width = viewport.width;
                            canvas.height = viewport.height;

                            const renderContext = {
                                canvasContext: context,
                                viewport: viewport,
                            };

                            page.render(renderContext).promise.then(function() {
                                // PDF thumbnail rendered successfully
                            });
                        });
                    })
                    .catch(function(error) {
                        // Handle errors
                        console.error("Error loading PDF:", error);
                    });
            }
        });
    </script>
@stop
