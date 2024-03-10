<!-- Modal -->
<div class="modal fade" id="leaveCreateModal" tabindex="-1" role="dialog" aria-labelledby="worktime" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Create Leave</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="leaveCreateForm">
                    @csrf
                    <div>
                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="therapist" class="col-3 text-right">Therapist:</label>
                                    <div class="col-9">
                                        <select class="form-control form-control-sm selectpicker" id="therapist"
                                            name="therapist" data-live-search="true">
                                            <option value="">Select Therapist</option>

                                            @foreach ($therapists as $therapist)
                                                <option value="{{ $therapist->id }}">
                                                    {{ $therapist->user()->first()->first_name }}
                                                    {{ $therapist->user()->first()->last_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="dates" class="col-3 text-right">Dates:</label>
                                    <div class="col-9">
                                        <div class="input-group date dateinput">
                                            <input type="text" class="form-control form-control-sm" name="dates"
                                                id="dates" />
                                            <div class="input-group-append" data-toggle="datetimepicker">
                                                <div class="input-group-text"> <i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="start-date" class="col-5 text-right">Start Date:</label>
                                    <div class="col-7">
                                        <div class="input-group date dateinput" id="start-date">
                                            <input type="text" class="form-control form-control-sm" name="start-date" data-target="#start-date"/>
                                            <div class="input-group-append" data-target="#start-date"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"> <i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                          </div>
                                    </div>

                                </div>
                            </div> --}}

                            {{-- <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="end-date" class="col-5 text-right">End Date:</label>
                                    <div class="col-7">
                                        <div class="input-group date dateinput" id="end-date">
                                            <input type="text" class="form-control form-control-sm " name="end-date" data-target="#end-date"/>
                                            <div class="input-group-append" data-target="#end-date"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"> <i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div> --}}
                        </div>
                        <!-- First Column -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="start-time" class="col-5 text-right">Start Time:</label>
                                <div class="col-7">
                                    <input type="text" class="form-control form-control-sm" name="start-time"
                                        id="start-time" placeholder="Select start time" />
                                </div>
                            </div>
                        </div>

                        <!-- Second Column -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="end-time" class="col-5 text-right">End Time:</label>
                                <div class="col-7">
                                    <input type="text" class="form-control form-control-sm" name="end-time"
                                        id="end-time" placeholder="Select end time" />
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="leavesubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>
