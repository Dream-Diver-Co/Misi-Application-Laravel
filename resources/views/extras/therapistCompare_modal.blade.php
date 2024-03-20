<!-- Modal -->

<div class="modal fade" id="compareTherapist-view-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Compare Therapist Appointments time & date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('update-from-ticket', ['id' => $patient->id]) }}"
                    id="update-patient-form">
                    @csrf

                    <div class="row justify-content-between">


                        <div class="col-md-4 justify-content-end">
                            <p>Therapist name 1</p>
                            @foreach($appointment_of_therapist_one as $appointment)
                                <p><span>{{$appointment->date}}</span> <span>{{$appointment->time}}</span></p>
                            @endforeach
                        </div>
                        <div class="col-md-4 justify-content-end">
                            <p>Therapist name 2 </p>
                            @foreach($appointment_of_therapist_two as $appointment)
                                <p><span>{{$appointment->date}}</span> <span>{{$appointment->time}}</span></p>
                            @endforeach
                        </div>
                        <div class="col-md-4 justify-content-end">
                            <p>Therapist name 3 </p>
                            @foreach($appointment_of_therapist_three as $appointment)
                                <p><span>{{$appointment->date}}</span> <span>{{$appointment->time}}</span></p>
                            @endforeach
                        </div>



                    </div>


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
