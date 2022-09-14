<div class="col-md-6">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#switch">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></i></a>
            </div>
            <span>Switch Account</span>
        </div>
        <div class="card-header-sub">
            Switch to your other accounts
        </div>
        <div class="card-body collapse show" id="switch">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                <h3 class="text-success"><i class="fa fa-check-circle"></i> Success</h3> You successfully switched account to THISACCOUNT
            </div>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                <h3 class="text-danger"><i class="fa fa-exclamation-triangle"></i> Oooopss!</h3> Please check again. The account does not exist.
            </div>
            <form class="es es-validation es-prevent" data-prevent-text="{{ __('No Function Yet!') }}">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="es-required es-email">Email address</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="youremail@yourdomain.com">
                </div>
                <button type="submit" class="btn btn-primary waves-effect waves-light button-save">SAVE</button>
            </form>
        </div>
    </div>
</div>