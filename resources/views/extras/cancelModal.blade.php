<div id="cancelModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Modal</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="cancelReason">Reason for cancellation:</label>
                        <input type="text" id="cancelReason" name="cancelReason"
                            class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label for="sendEmailToggle">Send cancellation email:</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input custom-control-input-sm"
                                id="sendEmailToggle" name="sendEmailToggle">
                            <label class="custom-control-label" for="sendEmailToggle" id="clickable"></label>
                        </div>
                    </div>
                    <div id="emailFields" style="display: none;">
                        <div class="form-group">
                            <label for="emailTypeCancel">Email Type:</label>
                            <select id="emailTypeCancel" name="emailTypeCancel" class="form-control form-control-sm">
                                <option value="">Select Type</option>
                                @foreach ($mailTypes as $mailType)
                                    <option value="{{ $mailType }}">{{ $mailType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="emailNameCancel">Email Name:</label>
                            <select id="emailNameCancel" name="emailNameCancel"
                                class="form-control form-control-sm"></select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitCancel" class="btn btn-primary">Submit</button>
                <button type="button" id="printTemplate2" class="btn btn-primary">Print</button>
            </div>
        </div>
    </div>
</div>
