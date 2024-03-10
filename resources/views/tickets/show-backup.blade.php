@extends('adminlte::page')

@section('content_top_nav_left')
    <div class="ml-5 d-flex align-items-center">
        <h6 class="m-0">Ticket - {{ $ticket->id }}</h6>
    </div>
@stop

@section('content')
    <div class="d-flex justify-content-between align-items-center w-100 sticky-top"
        style="min-height: 10px; background-color: #fff;">
        <div>
            <div class="d-flex flex-direction-row button-container">
                <button class="top-button go-back">Go Back</button>
                <button class="top-button " id="showFileInput"> <i class="fas fa-fw fa-solid fa-paperclip"></i></button>
                <button class="top-button top-submit-button" id="top-submit-button">Submit</button>

            </div>
        </div>
        <div>

        </div>
    </div>
    <div class="p-5">
        {{-- <h1 class="text-align-center">Ticket Information</h1> --}}

        <div class="">


            <form method="POST" action="{{ route('update-ticket', ['id' => $ticket->id]) }}" id="update-ticket-form"
                enctype="multipart/form-data">
                @csrf

                <div class="row justify-content-between">
                    <div class="col-md-12 justify-content-end">
                        <div class="container">
                            <input type="file" id="fileInput" class="file-input" name="files[]" accept="image/*,.pdf"
                                multiple />
                            <!-- Allow image and PDF files -->
                            <div id="thumbnailContainer" class="thumbnail-container">
                                <?php

                                //dd($attachments);
                                foreach ($attachments as $attachment) {
                                $file_type = substr($attachment['attatchment'],-4);
                                    if($file_type == ".png"){
                                        $edit_file_name = substr($attachment['attatchment'],19)
                                        ?>
                                <div class="thumbnail-wrapper">
                                    <div class="thumbnail">
                                        <img src="{{ asset('storage/' . $attachment['attatchment']) }}" width="100"
                                            height="100" alt="Image Preview">
                                    </div>
                                    <p class="attatchment_name">{{ $edit_file_name }}</p>
                                    <a href="" class=" btn btn-danger btn-sm delete_product"
                                        data-id="{{ $attachment->id }}">Delete</a>
                                </div>

                                <?php
                                    }else{
                                        $edit_file_name = substr($attachment['attatchment'],19)
                                ?>
                                <div class="thumbnail-wrapper">
                                    <div class="thumbnail">
                                        <img src="{{ asset('images/default_pdf_logo.png') }}" width="100" height="100"
                                            alt="Image Preview">

                                    </div>
                                    <p class="attatchment_name">{{ $edit_file_name }}</p>
                                    <a href="" class=" btn btn-danger btn-sm delete_product"
                                        data-id="{{ $attachment->id }}">Delete</a>
                                </div>

                                <?php
                                    }
                                    ?>

                                <?php
                                } ?>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row justify-content-between">
                    <!-- First Column -->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="select-department" class="col-5 text-right">Select Department:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="select-department"
                                    name="select-department">
                                    @foreach ($matchingRoles as $matchingRole)
                                        <option value="{{ $matchingRole->id }}"
                                            {{ $ticket->department_id == $matchingRole->id ? 'selected' : '' }}>
                                            {{ $matchingRole->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="assign-to" class="col-5 text-right">Assign To:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="assign-to" name="assign-to">
                                    <option value="">Select Staff</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mono-multi-zd" class="col-5 text-right">Mono/Multi ZD:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="mono-multi-zd"
                                    name="mono-multi-zd" value="{{ $ticket->mono_multi_zd }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zd_id" class="col-5 text-right">ZD_ID:</label>
                            <div class="col-7"><input type="text" class="form-control form-control-sm" id="zd_id"
                                    name="zd_id" value="{{ $ticket->zd_id }}"></div>
                        </div>

                        <div class="form-group row">
                            <label for="mono-multi-screening" class="col-5 text-right">Mono/Multi Screening:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="mono-multi-screening"
                                    name="mono-multi-screening" value="{{ $ticket->mono_multi_screening }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="intakes-therapist" class="col-5 text-right">Intakes/Therapist:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="intakes-therapist"
                                    name="intakes-therapist" value="{{ $ticket->intake_or_therapist }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tresonit-number" class="col-5 text-right">Tresonit Number:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="tresonit-number"
                                    name="tresonit-number" value="{{ $ticket->tresonit_number }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="datum-intake" class="col-5 text-right">Datum Intake:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="datum-intake"
                                    name="datum-intake" value="{{ $ticket->datum_intake }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="datuem-intake-2" class="col-5 text-right">Datuem Intake 2:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="datuem-intake-2"
                                    name="datuem-intake-2" value="{{ $ticket->datum_intake_2 }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nd-account" class="col-5 text-right">ND Account:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="nd-account"
                                    name="nd_account" value="{{ $ticket->nd_account }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="avc-alfmvm-sbg" class="col-5 text-right">AvC/AlfmVm/SBG:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="avc-alfmvm-sbg"
                                    name="avc-alfmvm-sbg" value="{{ $ticket->avc_alfmvm_sbg }}">
                            </div>
                        </div>
                        <div class="form-group row" class="col-5 text-right">
                            <label for="honos" class="col-5 text-right">Honos:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="honos" name="honos"
                                    value="{{ $ticket->honos }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="berha-intake" class="col-5 text-right">Berha Intake:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="berha-intake"
                                    name="berha-intake" value="{{ $ticket->berha_intake }}">
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="strike-history" class="col-5 text-right">Strike History:</label>
                            <div class="col-7">
                                <textarea class="form-control form-control-sm" id="strike-history" rows="3" name="strike-history">{{ $ticket->strike_history }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ticket-history" class="col-5 text-right">Ticket History:</label>
                            <div class="col-7">
                                <textarea class="form-control form-control-sm" id="ticket-history" rows="3" name="ticket-history">{{ $ticket->ticket_history }}</textarea>
                            </div>
                        </div> --}}
                    </div>
                    <!-- Second Column -->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="select-department" class="col-5 text-right">Select Patient:</label>
                            <div class="col-7">
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control form-control-sm selectpicker" id="select-patient"
                                            name="select-patient" data-live-search="true">
                                            <option value="">Select Patient</option>
                                            @foreach ($patients as $pat)
                                                <option value="{{ $pat->id }}"
                                                    {{ $ticket->patient()->first()->id == $pat->id ? 'selected' : '' }}>
                                                    {{ $pat->user()->first()->name ? $pat->user()->first()->name : $pat->user()->first()->id }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append " id="view-patient" data-toggle="modal"
                                            data-target="#patient-view-modal">
                                            <div class="input-group-text bg-gradient-primary">
                                                <i class="fas fa-eye"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $config = ['format' => 'DD-MM-YYYY'];
                        @endphp
                        <div class="form-group row">
                            <label for="rom-start" class="col-5 text-right">ROM Start:</label>
                            <div class="col-7">
                                <x-adminlte-input-date name="rom-start" :config="$config" placeholder="Choose a date..."
                                    id="rom-start" :value="$ticket->rom_start" class="form-control-sm">
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
                                    id="rom-end" :value="$ticket->rom_end" class="form-control-sm">
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
                                    id="berha-eind" :value="$ticket->berha_end" class="form-control-sm">
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
                                    id="vtcb-date" :value="$ticket->vtcb_date" class="form-control-sm">
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
                                    id="closure" :value="$ticket->closure" class="form-control-sm">
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
                                <x-adminlte-input-date name="aanm-intake" :config="$config"
                                    placeholder="Choose a date..." id="aanm-intake" :value="$ticket->aanm_intake_1"
                                    class="form-control-sm">
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
                            <div class="col-7">
                                <input class="form-control form-control-sm" id="location" name="location"
                                    value="{{ $ticket->location }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="call-strike" class="col-5 text-right">Call Strike:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="call-strike" name="call-strike">
                                    <option value="">Select Strike</option>
                                    <option value="strike_1" {{ $ticket->call_strike == 'strike_1' ? 'selected' : '' }}>
                                        Strike 1</option>
                                    <option value="strike_2" {{ $ticket->call_strike == 'strike_2' ? 'selected' : '' }}>
                                        Strike 2</option>
                                    <option value="strike_3" {{ $ticket->call_strike == 'strike_3' ? 'selected' : '' }}>
                                        Strike 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="remarks" class="col-5 text-right">Remarks:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="remarks" name="remarks"
                                    value="{{ $ticket->remarks }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="select-status" class="col-5 text-right">Status:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="select-status" name="select-status">
                                    <option value="">Select Status</option>
                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>

                                        Open</option>
                                    <option value="onhold" {{ $ticket->status == 'onhold' ? 'selected' : '' }}>

                                        On hold</option>
                                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>

                                        In progess</option>
                                    <option value="finished" {{ $ticket->status == 'finished' ? 'selected' : '' }}>

                                        Finished</option>
                                    {{-- <option value="work_finished"
                                        {{ $ticket->call_strike == 'work_finished' ? 'selected' : '' }}>
                                        Work Finished</option> --}}
                                    <option value="cancelled" {{ $ticket->status == 'cancelled' ? 'selected' : '' }}
                                        disabled>
                                        Cancelled</option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="comments" class="col-5 text-right">Comments:</label>
                            <div class="col-7"><input type="text" class="form-control form-control-sm"
                                    id="comments" name="comments"></div>
                        </div> --}}
                        <div class="form-group row">
                            <label for="language-treatment" class="col-5 text-right">Language Treatment:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="language-treatment"
                                    name="language-treatment">
                                    <option value="">Select Language</option>
                                    <option value="dutch" {{ $ticket->language == 'dutch' ? 'selected' : '' }}>Dutch
                                    </option>
                                    <option value="english" {{ $ticket->language == 'english' ? 'selected' : '' }}>English
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <h6 class="ml-3 col-2 text-right">Activity Log</h6>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">

                        <div class="form-group row work_note">
                            <label for="comments" class="col-2 text-right">Work Note:</label>
                            <div class="col-10">
                                <textarea class="form-control form-control-sm" id="comments" name="comments"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
            </form>
        </div>


        <div id="ticket-history">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="pr-3 col-2 text-right ticket_history_title">Activites</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="ticket_history_card" id="history-card">
                        <div class="card">
                            <div class="card-body" id="history-body">
                                {{-- <div id="history-content"></div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>

    @include('extras.patient_modal')
@stop

@section('js')
    <script>
        // submit form
        $(document).ready(function() {
            var assignToSelect = $('#assign-to');

            var defaultRole = $('#select-department').val();

            var assignedStaff = '{{ $ticket->assigned_staff }}' !== null ? '{{ $ticket->assigned_staff }}' : '';
            var ticketId = '{{ $ticket->id }}';
            getHistories(ticketId)


            document.getElementById('top-submit-button').addEventListener('click', function() {
                $('select[name="select-status"] option').removeAttr('disabled');
                $('#update-ticket-form').submit()
            });

            $('#update-ticket-form').submit(function(event) {

                event.preventDefault(); // Prevent form submission

                // var formData = new FormData(this); // Serialize form data
                // console.log('FormData', formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire('Success!', 'Request successful', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Request failed', 'error');
                    }
                });

                getHistories(ticketId)
            });




            getUsers(defaultRole)


            function getUsers(roleVal) {
                $.ajax({
                    url: '/get-role-users', // Replace with your Laravel route
                    type: 'GET',
                    data: {
                        role: roleVal
                    },
                    success: function(response) {
                        // Populate the "Assign To" select input with the retrieved users
                        assignToSelect.empty()
                        $.each(response.users, function(index, user) {
                            var option = $('<option></option>').text(user.first_name).val(user
                                .id);



                            // Check if the user ID matches the "Assign To" value
                            if (user.id == assignedStaff) {
                                option.prop('selected', true);
                            }

                            assignToSelect.append(option);
                            assignToSelect.prepend($('<option></option>').val("").text(
                                'Select Staff'));
                        });

                        console.log(response.users)
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // function getHistories(ticketId) {
            //     $.ajax({
            //         url: '/get-histories', // Replace with your Laravel route
            //         type: 'GET',
            //         data: {
            //             id: ticketId
            //         },
            //         success: function(response) {
            //             // Populate the "Assign To" select input with the retrieved users
            //             var history_card = $('#history-card');
            //             const histories = [];
            //             $.each(response.histories, function(index, history) {

            //                 var history_content = $('<div class="card p-5"></div>').html(
            //                     '<div class="card-body" id="history-body"></div>').html(
            //                     history.comment);

            //                 histories.push(history_content)


            //             });

            //             history_card.html(histories);

            //             console.log(response.histories)
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(xhr.responseText);
            //         }
            //     });
            // }



            // Handle the change event of the "Roles" select input
            $('#select-department').on('change', function() {
                var selectedRole = $(this).val();

                getUsersChanged(selectedRole, assignToSelect)


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
                    //thumbnailContainer.innerHTML = ""; // Clear previous thumbnails

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


        // delet attatchment



        $(document).on('click', '.delete_product', function(e) {
            e.preventDefault();
            let attachment_id = $(this).data('id');
            //alert(product_id);

            //if (confirm('are sure?')) {
            $.ajax({
                url: "{{ route('attachment') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'post',
                data: {
                    attachment_id: attachment_id
                },
                success: function(res) {
                    if (res.status == 'success') {

                        $("#thumbnailContainer").load(" #thumbnailContainer");
                    }

                }


            })
            //}
        })
    </script>
@stop
