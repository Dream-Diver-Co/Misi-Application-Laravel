<!-- Modal -->

<div class="modal fade" id="patient-view-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ $patient->user()->first()->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('update-from-ticket', ['id' => $patient->id]) }}"
                    id="update-patient-form">
                    @csrf

                    <div class="row justify-content-between">
                        <div class="col-md-6 justify-content-end">

                            <div class="form-group row">
                                <label for="name" class="col-5 text-right">Name:</label>
                                <div class="col-7">
                                    <input type="text" class="form-control form-control-sm" id="name"
                                        name="name" value="{{ $patient->user()->first()->name }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="user-name" class="col-5 text-right">User Name:</label>
                                <div class="col-7"><input type="text" class="form-control form-control-sm"
                                        id="user-name" name="user-name"
                                        value="{{ $patient->user()->first()->user_name }}">
                                </div>
                            </div>


                            <div class="form-group row">
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
                                    <x-adminlte-input-date name="dob" :config="$config"
                                        placeholder="Choose a date..." id="dob" onchange="calculateAge()"
                                        :value="$patient->user()->first()->date_of_birth" class="form-control-sm">
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
                                    <select class="form-control form-control-sm" id="marital-status"
                                        name="marital-status">
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
                                            {{ $patient->user()->first()->status == 'Avtive' ? 'selected' : '' }}>
                                            Active
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
                                        <option value="A+" {{ $patient->blood_group === 'A+' ? 'selected' : '' }}>
                                            A+
                                        </option>
                                        <option value="A-" {{ $patient->blood_group === 'A-' ? 'selected' : '' }}>
                                            A-
                                        </option>
                                        <option value="B+" {{ $patient->blood_group === 'B+' ? 'selected' : '' }}>
                                            B+
                                        </option>
                                        <option value="B-" {{ $patient->blood_group === 'B-' ? 'selected' : '' }}>
                                            B-
                                        </option>
                                        <option value="O+" {{ $patient->blood_group === 'O+' ? 'selected' : '' }}>
                                            B-
                                        </option>
                                        <option value="O-" {{ $patient->blood_group === 'O-' ? 'selected' : '' }}>
                                            B-
                                        </option>
                                        <option value="AB+"
                                            {{ $patient->blood_group === 'AB+' ? 'selected' : '' }}>B-
                                        </option>
                                        <option value="AB-"
                                            {{ $patient->blood_group === 'AB-' ? 'selected' : '' }}>B-
                                        </option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="country" class="col-5 text-right">Country:</label>
                                <div class="col-7">
                                    <select class="form-control form-control-sm selectpicker" id="country"
                                        name="country">
                                        {{-- <option value="country1" {{ $patient->blood_group === 'AB-' ? 'selected' : '' }}>Country 1</option>
                                        <option value="country1" {{ $patient->blood_group === 'AB-' ? 'selected' : '' }}>Country 2</option>
                                        <option value="country1" {{ $patient->blood_group === 'AB-' ? 'selected' : '' }}>Country 3</option> --}}
                                        {{-- @foreach ($countries as $country)
                                            <option value="{{ $country['name_en'] }}"
                                                {{ $patient->country === $country['name_en'] ? 'selected' : '' }}>
                                                {{ $country['name_en'] }}</option>
                                        @endforeach --}}
                                        {{-- <option value="{{ $patient->country }}">{{ $patient->country }}</option> --}}

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
                                    <input type="email" class="form-control form-control-sm" id="email"
                                        name="email" value="{{ $patient->user()->first()->email }}">
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
                                    <input type="text" class="form-control form-control-sm" id="area"
                                        name="area" value="{{ $patient->area }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dob-number" class="col-5 text-right">DOB Number:</label>
                                <div class="col-7">
                                    <input type="text" class="form-control form-control-sm" id="dob-number"
                                        name="dob-number" value="{{ $patient->DOB_number }}">
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
                                    <input type="text" class="form-control form-control-sm" id="remarks"
                                        name="remarks" value="{{ $patient->remarks }}">
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="file-type" class="col-5 text-right">File Type:</label>
                                <div class="col-7">
                                    <select class="form-control form-control-sm" id="file-type" name="file-type">
                                        <option value="type1">File Type 1</option>
                                        <option value="type2">File Type 2</option>
                                        <option value="type3">File Type 3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="file" class="col-5 text-right">File:</label>
                                <div class="col-7"><input type="file"
                                        class="form-control-file form-cntrol-file-sm" id="file" name="file">
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="residential-address" class="col-3 text-right">Residential Address:</label>
                                <div class="col-9">
                                    <textarea class="form-control" id="residential-address" rows="3" name="residential-address">{{ $patient->residential_address }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="medical-history" class="col-3 text-right">Medical History:</label>
                                <div class="col-9">
                                    <textarea class="form-control" id="medical-history" rows="3" name="medical-history">{{ $patient->medical_history }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
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
</script>
