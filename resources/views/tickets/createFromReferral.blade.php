@extends('adminlte::page')

@section('content')
    <div class="d-flex justify-content-between align-items-center w-100 sticky-top"
        style="min-height: 10px; background-color: #fff;">
        <div>
            <div class="d-flex flex-direction-row button-container">
                <button class="top-button go-back" id="goback">Go Back</button>
                {{-- <button class="top-button " id="showFileInput"> <i class="fas fa-fw fa-solid fa-paperclip"></i></button> --}}
                {{-- <button class="top-button top-submit-button" id="top-submit-button-test">Submit</button> --}}


            </div>
        </div>
        <div>

        </div>
    </div>




    <div class="p-5">

        <div class="col-md-12 ">
            <div class="container">
                <div class="input-container">
                    <form method="POST" action="{{ route('ticket-referral') }}" id="create-ticket-form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="pdf-input-field">
                            <label for="formFile" class="form-label">Upload Referral Letter </label>
                            <input class="form-control" type="file" id="formFile" name="referral_file" accept=".pdf">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm mt-10 refferel-submit-button ">Create
                            Ticket</button>
                    </form>
                </div>


            </div>
        </div>


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
