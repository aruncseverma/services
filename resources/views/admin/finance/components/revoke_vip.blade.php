<div class="modal" tabindex="-1" role="dialog" id="revokeMembership" aria-labelledby="revokeMembership" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Revoke Membership')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <form method="POST" id="revokeForm" class="es es-validation es-submit">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="order_id" id="order_id">
                    <label for="revokeReason" class="es-required" data-error-after-label="true">Reason</label>
                    <textarea id="revokeReason" class="form-control" name="content" rows="5"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-info waves-effect">@lang('Revoke Membership')</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('Close')</button>
                </div>
            </form>
        </div>
    </div>
</div>