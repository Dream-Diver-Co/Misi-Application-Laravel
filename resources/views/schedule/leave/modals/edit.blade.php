<!-- Modal -->
<div class="modal fade" id="leaveShowModal" tabindex="-1" role="dialog" aria-labelledby="worktime" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Leave Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="leaveUpdateForm">
                    <div>

                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="therapistshow" class="col-2 text-right">Therapist:</label>
                                    <div class="col-10">
                                        <select class="form-control form-control-sm" id="therapistshow"
                                            name="therapist">
                                        </select>
                                    </div>

                                </div>
                            </div>

                        </div>

                        {{-- dates start --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="dates" class="col-3 text-right">Dates:</label>
                                    <div class="col-9">
                                        <div class="input-group date dateinput">
                                            <input type="text" class="form-control form-control-sm leaveDate"
                                                name="dates-edit" id="dates-edit" />
                                            <div class="input-group-append" data-toggle="datetimepicker">
                                                <div class="input-group-text"> <i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                        {{-- dates end --}}




                        {{-- time start --}}

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="start-time-edit" class="col-5 text-right">Start Time:</label>
                                <div class="col-7">
                                    <input type="text" class="form-control form-control-sm" name="start-time-edit"
                                        value="" id="start-time-edit" placeholder="Select start time" />
                                </div>
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="end-time-edit" class="col-5 text-right">End Time:</label>
                                <div class="col-7">
                                    <input type="text" class="form-control form-control-sm" name="end-time-edit"
                                        value="" id="end-time-edit" placeholder="Select end time" />
                                </div>
                            </div>
                        </div>
                        {{-- time end --}}






                        {{-- <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="start-date" class="col-5 text-right">Start Date:</label>
                                    <div class="col-7">
                                        <div class="input-group date dateinput" id="start-date-show">
                                            <input type="text" class="form-control form-control-sm" name="start-date"
                                                data-target="#start-date-show" id="start-show-update" />
                                            <div class="input-group-append" data-target="#start-date-show"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"> <i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="end-date" class="col-5 text-right">End Date:</label>
                                    <div class="col-7">
                                        <div class="input-group date dateinput" id="end-date-show">
                                            <input type="text" class="form-control form-control-sm " name="end-date"
                                                data-target="#end-date-show" id="end-show-update" />
                                            <div class="input-group-append" data-target="#end-date-show" id="dates"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"> <i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div> --}}

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="leaveUpdateSubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>
