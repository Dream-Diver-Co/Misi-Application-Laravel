<!-- Modal -->
<div class="modal fade" id="worktimeModal" tabindex="-1" role="dialog" aria-labelledby="worktime" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Work Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="worktimeform">
                    <div>
                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="weekoff" class="col-3 text-right">Weekly Off:</label>
                                    <select name="weeklyoff[]" id="weekoff"
                                        class="form-control from-control-sm col-8 selectpicker" multiple>

                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="worktimesubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>
