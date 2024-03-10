@extends('adminlte::page')

@section('content_top_nav_left')
    <div class="ml-5 d-flex align-items-center">
        <h6 class="m-0">Patient - {{ $patient->user()->first()->user_serial_no }}</h6>
    </div>
@stop

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

            <form method="POST" action="{{ route('patients-update', ['id' => $patient->id]) }}" id="update-patient-form"
                enctype="multipart/form-data" class="">
                @csrf


                <div class="row justify-content-between">
                    <div class="col-md-12 justify-content-end">
                        <div class="image-container">
                            <div id="imageContainer">

                                <!-- Hidden file input -->
                                <input type="file" id="image-upload-input" accept="image/*" name="profile-image"
                                    value="{{ $patient->user()->first()->profile_image }}">

                                <!-- Image container  -->

                                <?php
                                $image_url = $patient->user()->first()->profile_image;
                                    if($image_url == null){
                                        ?>
                                <div id="image-container">
                                    <img id="image-preview" src="{{ asset('images/default_user_image.png') }}"
                                        width="100" height="100" alt="Image Preview">
                                </div>

                                <?php
                                    }else{
                                        ?>
                                <div id="image-container">
                                    <img id="image-preview"
                                        src="{{ asset('storage/' . $patient->user()->first()->profile_image) }}"
                                        width="100" height="100" alt="Image Preview">
                                </div>

                                <?php

                                    }
                                ?>

                            </div>
                            <button type="button" id="edit-button">Change</button>
                        </div>


                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-md-6 justify-content-end">

                        <div class="form-group row">
                            <label for="name" class="col-5 text-right">Name:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="name" name="name"
                                    value="{{ $patient->user()->first()->name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user-name" class="col-5 text-right">User Name:</label>
                            <div class="col-7"><input type="text" class="form-control form-control-sm" id="user-name"
                                    name="user-name" value="{{ $patient->user()->first()->user_name }}">
                            </div>
                        </div>
                        <div class="form-group
                                    row">
                            <label for="phone-number" class="col-5 text-right">Phone Number:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="phone-number"
                                    name="phone-number" value="{{ $patient->user()->first()->phone }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alt-phone-number" class="col-5 text-right">Alternative Phone Number:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="alt-phone-number"
                                    name="alt-phone-number" value="{{ $patient->alternative_phone }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="emergency-contact" class="col-5 text-right">Emergency Contact:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="emergency-contact"
                                    name="emergency-contact" value="{{ $patient->emergency_contact }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dob" class="col-5 text-right">Date of Birth:</label>
                            {{-- <input type="date" class="form-control" id="dob" name="dob"
                                onchange="calculateAge()"> --}}
                            {{-- <input type="text" class="form-control" id="dob" name="dob" onchange="calculateAge()"> --}}
                            @php
                                $config = ['format' => 'DD-MM-YYYY'];
                            @endphp
                            <div class="col-7">
                                <x-adminlte-input-date name="dob" :config="$config" placeholder="Choose a date..."
                                    id="dob" onchange="calculateAge()" :value="$patient->user()->first()->date_of_birth" class="form-control-sm">
                                    <x-slot name="appendSlot">
                                        <div class="input-group-text bg-gradient-primary">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input-date>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="age" class="col-5 text-right">Age:</label>
                            <div class="col-7"><input type="number" class="form-control form-control-sm"
                                    id="age" name="age" readonly></div>
                        </div>
                        <div class="form-group row">
                            <label for="marital-status" class="col-5 text-right">Marital Status:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="marital-status" name="marital-status">
                                    <option value="Single"
                                        {{ $patient->user()->first()->marital_status == 'Single' ? 'selected' : '' }}>
                                        Single
                                    </option>
                                    <option value="Married"
                                        {{ $patient->user()->first()->marital_status == 'Married' ? 'selected' : '' }}>
                                        Married
                                    </option>
                                    <option value="Divorced"
                                        {{ $patient->user()->first()->marital_status == 'Divorced' ? 'selected' : '' }}>
                                        Divorced
                                    </option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-5 text-right">Status:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="status" name="status">
                                    <option value="Active"
                                        {{ $patient->user()->first()->status == 'Avtive' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="Inavtive"
                                        {{ $patient->user()->first()->status == 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sex" class="col-5 text-right">Sex:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="sex" name="sex">
                                    <option value="Male"
                                        {{ $patient->user()->first()->sex == 'Male' ? 'selected' : '' }}>
                                        Male</option>
                                    <option value="Femail"
                                        {{ $patient->user()->first()->sex == 'Female' ? 'selected' : '' }}>
                                        Femail</option>
                                    <option value="Other"
                                        {{ $patient->user()->first()->sex == 'Other' ? 'selected' : '' }}>
                                        Other</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="occupation" class="col-5 text-right">Occupation:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="occupation"
                                    name="occupation" value="{{ $patient->occupation }}">
                            </div>
                        </div>
                    </div>
                    {{-- {{ dd($patient->blood_group) }} --}}
                    <div class="col-md-6 justify-content-start">
                        <div class="form-group row">
                            <label for="blood-group" class="col-5 text-right">Blood group:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm" id="blood-group" name="blood-group">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+" {{ $patient->blood_group === 'A+' ? 'selected' : '' }}>A+
                                    </option>
                                    <option value="A-" {{ $patient->blood_group === 'A-' ? 'selected' : '' }}>A-
                                    </option>
                                    <option value="B+" {{ $patient->blood_group === 'B+' ? 'selected' : '' }}>B+
                                    </option>
                                    <option value="B-" {{ $patient->blood_group === 'B-' ? 'selected' : '' }}>B-
                                    </option>
                                    <option value="O+" {{ $patient->blood_group === 'O+' ? 'selected' : '' }}>B-
                                    </option>
                                    <option value="O-" {{ $patient->blood_group === 'O-' ? 'selected' : '' }}>B-
                                    </option>
                                    <option value="AB+" {{ $patient->blood_group === 'AB+' ? 'selected' : '' }}>B-
                                    </option>
                                    <option value="AB-" {{ $patient->blood_group === 'AB-' ? 'selected' : '' }}>B-
                                    </option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="country" class="col-5 text-right">Country:</label>
                            <div class="col-7">
                                <select class="form-control form-control-sm selectpicker" id="country" name="country"
                                    data-live-search="true">
                                    {{-- <option value="country1" {{ $patient->blood_group === 'AB-' ? 'selected' : '' }}>Country 1</option>
                                    <option value="country1" {{ $patient->blood_group === 'AB-' ? 'selected' : '' }}>Country 2</option>
                                    <option value="country1" {{ $patient->blood_group === 'AB-' ? 'selected' : '' }}>Country 3</option> --}}
                                    @foreach ($countries as $country)
                                        <option value="{{ $country['name_en'] }}"
                                            {{ $patient->country === $country['name_en'] ? 'selected' : '' }}>
                                            {{ $country['name_en'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city-state" class="col-5 text-right">City/State:</label>
                            <div class="col-7">
                                <input class="form-control form-control-sm" id="city-state" name="city-state"
                                    value="{{ $patient->city_or_state }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-5 text-right">Email:</label>
                            <div class="col-7">
                                <input type="email" class="form-control form-control-sm" id="email" name="email"
                                    value="{{ $patient->user()->first()->email }}">
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div> --}}
                        <div class="form-group row">
                            <label for="insurance-number" class="col-5 text-right">Insurance Number:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="insurance-number"
                                    name="insurance-number" value="{{ $patient->insurance_number }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="area" class="col-5 text-right">ZIP Code:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="area" name="area"
                                    value="{{ $patient->area }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bsn-number" class="col-5 text-right">BSN Number:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="bsn-number"
                                    name="bsn-number" value="{{ $patient->BSN_number }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="remarks" class="col-5 text-right">Remarks:</label>
                            <div class="col-7">
                                <input type="text" class="form-control form-control-sm" id="remarks" name="remarks"
                                    value="{{ $patient->remarks }}">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="residential-address" class="col-5 text-right">Residential Address:</label>
                            <div class="col-7">
                                <textarea class="form-control" id="residential-address" rows="3" name="residential-address">{{ $patient->residential_address }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="medical-history" class="col-5 text-right">Medical History:</label>
                            <div class="col-7">
                                <textarea class="form-control" id="medical-history" rows="3" name="medical-history">{{ $patient->medical_history }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
            </form>

        </div>
    </div>

@stop

@section('js')
    <script>
        // $("#dob").datepicker();
        function calculateAge() {
            var dobInput = moment(document.getElementById('dob').value, 'DD-MM-YYYY');
            var dob = new Date(dobInput);
            var today = new Date();
            if (isNaN(Date.parse(dobInput))) {
                console.log("Invalid date input:", dobInput);
                return;
            }
            var age = today.getFullYear() - dob.getFullYear();

            // Check if the birthday hasn't happened yet this year
            if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob
                    .getDate())) {
                age--;
            }

            // Set the calculated age in the input field
            document.getElementById('age').value = age;
        }


        // submit form
        $(document).ready(function() {
            document.getElementById('top-submit-button').addEventListener('click', function() {
                $('#update-patient-form').submit()
            });
            $('#update-patient-form').submit(function(event) {
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
                    //data: formData,
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
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

            $('.go-back').click(function() {
                history.go(-1); // Go back one page
                console.log('click back button')
            });
        });


        //edit  image


        $(document).ready(function() {
            // Trigger file input when the "Edit" button is clicked
            $("#edit-button").click(function() {
                $("#image-upload-input").click();
            });

            // Handle file input change to preview the selected image
            $("#image-upload-input").change(function() {
                readURL(this);
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $("#image-preview").attr("src", e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@stop
