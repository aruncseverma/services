<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#silvervalidation">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Silver Validation')</span>
        </div>
        <div class="card-header-sub">
            @lang('Get your profile the Silver Status')
        </div>
        <div class="card-body collapse show" id="silvervalidation">
            @if (old('notify') === "membership.silver")
                @include('EscortAdmin::common.notifications')
            @endif
            @if ($membership === 'silver')
                <div class="row">
                    <div class="col-sm-4 t-center silvergoldval">
                        <i class="mdi mdi-marker-check"></i>
                    </div>
                    <div class="col-sm-8">
                        <h4>@lang('You are already a')</h4>
                        <h3 class="text-uppercase">@lang('Valid silver member')</h3>
                    </div>
                </div>
            @elseif ($membership === 'basic')
                <form action="{{ route('escort_admin.profile_validation.silver') }}" method="POST" enctype="multipart/form-data" class="es es-validation">
                    <div class="row">
                        <div class="col-sm-4 t-center">
                                <img src="{{ asset('assets/theme/admin/default/images/badge-lumia-model.jpg') }}" alt="user-img" >
                            </div>
                            <div class="col-sm-8">
                                <h3 class="text-uppercase">@lang('Valid Silver Member')</h3>
                                <p>@lang('Simply take a photo of yourself holding a white sign that says "I am a LUMIS MODEL", with the current date.')</p>
                                <h6 class="text-danger text-uppercase">*@lang('Hand written not printed')</h6>
                                <p>(@lang('Example photo on your left'))</p>
                                <div class="form-group">

                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput">
                                            <span class="fileinput-filename"></span>
                                        </div>
                                        <span class="input-group-addon btn btn-secondary btn-file">
                                            <span class="fileinput-new">@lang('Select file')</span>
                                            <span class="fileinput-exists">@lang('Change')</span>
                                            <input type="file" name="mug_shot_file" id="mug_shot_file">
                                        </span>
                                        <a href="#" class="input-group-addon btn btn-secondary fileinput-exists" data-dismiss="fileinput">@lang('Remove')</a>
                                    </div>
                                </div>
                                <h6>(@lang('Must be JPG only, maximum of 1200 pixels and not exceeding 3MB'))</h6>
                                <h6>* @lang('the photo you will upload will not appear on your profile and will remain confidential')</h6>
                                <label for="mug_shot_file" class="es-required es-image" style="display:none;" data-error-after-label="true">Mug Shot File</label>
                                @include('EscortAdmin::common.form.error', ['key' => 'mug_shot_file'])
                            </div>
                        </div>

                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save text-uppercase">@lang('Submit')</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
