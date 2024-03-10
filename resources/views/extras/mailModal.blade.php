<div id="mailModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mail Modal</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="cancelReason">comment:</label>
                        <input type="text" id="comment" name="cancelReason" class="form-control form-control-sm">
                    </div>



                    <div id="emailFields">
                        <div class="form-group">
                            <label for="emailTypeSend">Email Type:</label>
                            <select id="emailTypeSend" name="emailTypeSend" class="form-control form-control-sm">
                                <option value="">Select Type</option>
                                @foreach ($mailTypes as $mailType)
                                    <option value="{{ $mailType }}">{{ $mailType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=" ">Email Name:</label>
                            <select id="emailNameSend" name="emailNameSend"
                                class="form-control form-control-sm"></select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="emailSendForCancel" class="btn btn-primary">Email Send</button>

                <button type="button" id="printTemplate" class="btn btn-primary">Print</button>
            </div>
        </div>
    </div>
</div>
