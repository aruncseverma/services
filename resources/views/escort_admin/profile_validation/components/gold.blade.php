<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#goldvalidation">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Gold Validation')</span>
        </div>
        <div class="card-header-sub">
            @lang('Get your profile the Gold Status')
        </div>
        <div class="card-body collapse show" id="goldvalidation">
            @if (old('notify') === "membership.gold")
                @include('EscortAdmin::common.notifications')
            @endif
            @if ($membership === 'basic')
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="text-uppercase">@lang('Silver Validation is')&nbsp;<span class="font-bold text-uppercase">@lang('Required')</span></h2>
                        <p>@lang('Before you can apply for <span class="text-uppercase">GOLD STATUS</span>')</p>
                    </div>
                </div>
            @elseif ($membership === 'silver')
                <form action="{{ route('escort_admin.profile_validation.gold') }}" method="POST" enctype="multipart/form-data" class="es es-validation">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 ">
                            <p>@lang('First you need to provide a photo of your ID with the following'):</p>
                            <div class="form-group">
                                <label for="" class="">@lang('Name, Birthday and Photo')</label>
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-secondary btn-file">
                                        <span class="fileinput-new">@lang('Select file')</span>
                                    <span class="fileinput-exists">@lang('Change')</span>
                                    <input type="file" name="photo_id_file" id="photo_id_file">
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-secondary fileinput-exists text-uppercase" data-dismiss="fileinput">@lang('Remove')</a>
                                </div>
                            </div>
                            <h6>@lang('Photo of your ID must be clear and readable to be accepted')</h6>
                            <h6>(@lang('Must be JPG only, maximum of 1200 pixels and not exceeding 3MB'))</h6>
                            <label for="photo_id_file" class="es-required es-image" style="display:none;" data-error-after-label="true">Photo</label>
                            @include('EscortAdmin::common.form.error', ['key' => 'photo_id_file'])
                        </div>
                        <div class="col-sm-6">
                            <p>@lang('Next, you need to provide the following information'):</p>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="elm_private_name" class="es-required">@lang('Real Name')</label>
                                    <input class="form-control" type="text" name="private[name]" value="{{ old('private.name') }}" id="elm_private_name" autocomplete="off">
                                    @include('EscortAdmin::common.form.error', ['key' => 'private.name'])
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="elm_private_birthdate" class="es-required">@lang('Birthday'):</label>
                                    <input class="form-control" type="date" name="private[birthdate]" value="{{ old('private.birthdate') }}" id="elm_private_birthdate" autocomplete="off">
                                    @include('EscortAdmin::common.form.error', ['key' => 'private.birthdate'])
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="elm_private_email" class="es-required es-email">@lang('Private Email'):</label>
                                    <input class="form-control" type="text" name="private[email]" value="{{ old('private.email') }}" id="elm_private_email" autocomplete="off">
                                    @include('EscortAdmin::common.form.error', ['key' => 'private.email'])
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="elm_private_tel" class="es-required">@lang('Private Telephone'):</label>
                                    <input class="form-control" type="text" name="private[tel]" value="{{ old('private.tel') }}" id="elm_private_tel" autocomplete="off">
                                    @include('EscortAdmin::common.form.error', ['key' => 'private.tel'])
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="elm_private_emergency_tel" class="es-required">@lang('Telephone in case of Emergency'):</label>
                                    <input class="form-control" type="text" name="private[emergency_tel]" value="{{ old('private.emergency_tel') }}" id="elm_private_emergency_tel" autocomplete="off">
                                    @include('EscortAdmin::common.form.error', ['key' => 'private.emergency_tel'])
                                </div>
                            </div>
                            <h6>* @lang('Information you provide here will remain confidential and for internal purpose only')</h6>
                            <h6>* @lang('We will not post or give your info to anyone')</h6>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save text-uppercase">@lang('Submit')</button>
                </form>
            @elseif ($membership === 'gold')
                <div class="row">
                    <div class="col-sm-4 t-center silvergoldval text-warning">
                        <i class="mdi mdi-marker-check"></i>
                    </div>
                    <div class="col-sm-8">
                        <h4>@lang('You are already a')</h4>
                        <h3 class="text-uppercase">@lang('Valid Gold member')</h3>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
