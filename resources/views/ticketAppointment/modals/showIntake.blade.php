<!-- Modal -->
<div class="modal fade" id="showIntakeModal" tabindex="-1" role="dialog" aria-labelledby="intake-show" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Intake Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="intake-update-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div>
                        <div class="row">
                            <!-- First Column -->
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="show-date" class="col-3 text-right">Date:</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control form-control-sm" name="date"
                                            id="show-date">
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="show-time" class="col-3 text-right">Time:</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control form-control-sm" name="time"
                                            id="show-time">

                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="show-status" class="col-3 text-right">Status:</label>
                                    <div class="col-9">
                                        <select class="form-control form-control-sm selectpicker" id="show-status"
                                            name="status">
                                            <option value="visited">Visited</option>
                                            <option value="not_visited">Not Visited</option>

                                        </select>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="show_payment_method" class="col-3 text-right">Payment Method:</label>
                                    <div class="col-9">
                                        <select class="form-control form-control-sm selectpicker"
                                            id="show_payment_method" name="payment_method">
                                            <option value="N/A">N/A</option>
                                            <option value="card">Card</option>
                                            <option value="insurance">Insurance</option>
                                            <option value="cash">Cash</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="show_payment_status" class="col-3 text-right">Payment Status:</label>
                                    <div class="col-9">
                                        <select class="form-control form-control-sm selectpicker"
                                            id="show_payment_status" name="payment_status">
                                            <option value="paid">Paid</option>
                                            <option value="unpaid">Unpaid</option>

                                        </select>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="update-intake-submit">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="leaveShowModal" tabindex="-1" role="dialog" aria-labelledby="worktime" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Work Schedule</h5>
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="start-date" class="col-5 text-right">Start Date:</label>
                                    <div class="col-7">
                                        <div class="input-group date dateinput" id="start-date-show">
                                            <input type="text" class="form-control form-control-sm"
                                                name="start-date" data-target="#start-date-show"
                                                id="start-show-update" />
                                            <div class="input-group-append" data-target="#start-date-show"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"> <i class="fas fa-calendar-alt"></i>
                                                </div>
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
                                            <input type="text" class="form-control form-control-sm "
                                                name="end-date" data-target="#end-date-show" id="end-show-update" />
                                            <div class="input-group-append" data-target="#end-date-show"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"> <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="leaveUpdateSubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>
