<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#basic_info">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Basic Information')</span>
        </div>
        <div class="card-header-sub">
            @lang('Update your information')
        </div>
        <div class="card-body collapse show" id="basic_info">
            <form action="{{ route('escort_admin.profile.basic_information') }}" method="POST">
            @csrf
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <label for="name" class="">@lang('Name')</label>
                        <input class="form-control" type="text" value="{{ $user->name ?? old('name') }}" id="name" name="name">
                        @include('Admin::common.form.error', ['key' => 'name'])
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 form-group">
                                <label for="gender" class="">@lang('Gender')</label>
                                <select class="selectpicker" data-style="form-drop" name="gender" id="gender">
                                    @forelse ($genderOptions as $value => $label)
                                        <option value="{{ $value }}" @if ($user->gender == $value) selected="" @endif>{{ $label }}</option>
                                    @empty
                                        <option selected="">@lang('No data')</option>
                                    @endforelse
                                </select>
                                @include('Admin::common.form.error', ['key' => 'gender'])
                            </div>
                            <div class="col-md-3 col-sm-6 form-group">
                                <label for="orientation_2_liner" class="">@lang('Orientation 2 Liner')</label>
                                <select class="selectpicker" data-style="form-drop" name="orientation_2_liner" id="orientation_2_liner">
                                    @forelse ($orientation2LinerOptions as $value => $label)
                                        <option value="{{ $value }}" @if ($user->userData->orientation2Liner == $value) selected="" @endif>{{ $label }}</option>
                                    @empty
                                        <option selected="">@lang('No data')</option>
                                    @endforelse
                                </select>
                                @include('Admin::common.form.error', ['key' => 'orientation_2_liner'])
                            </div>
                            <div class="col-md-3 col-sm-6 form-group">
                                <label for="birthdate" class="">@lang('Birthday')</label>
                                <input type="text" class="form-control" name="birthdate" id="birthdate" placeholder="mm/dd/yyyy" value="{{ $user->birthdate ?? '' }}" autocomplete="off">
                                @include('Admin::common.form.error', ['key' => 'birthdate'])
                            </div>
                            <div class="col-md-3 col-sm-6 form-group">
                                <label for="ethnicity_id" class="">@lang('Ethnizität')</label>
                                <select class="selectpicker" data-style="form-drop" name="ethnicity_id" id="ethnicity_id">
                                    @forelse ($ethnicityOptions as $ethnicity)
                                        <option value="{{ $ethnicity->id }}" @if ($user->userData->ethnicityId == $ethnicity->id) selected="" @endif>{{ $ethnicity->description->content ?? '--' }}</option>
                                    @empty
                                        <option selected="">@lang('No data')</option>
                                    @endforelse
                                    @include('Admin::common.form.error', ['key' => 'ethnicity_id'])
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <label for="origin_id" class="">@lang('Origin')</label>
                        @include(
                            'EscortAdmin::common.form.country',
                            [
                                'name' => 'origin_id',
                                'value' => (int)$user->userData->originId ?? old('origin_id'),
                                'classes' => 'select2 form-control',
                                'attributes' => 'data-style=form-drop'
                            ]
                        )
                        @include('Admin::common.form.error', ['key' => 'origin_id'])
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 form-group">
                                <label for="example-text-input" class="">@lang('Service Type')</label>
                                <select class="selectpicker" data-style="form-drop" name="service_type">
                                    @forelse ($serviceTypeOptions as $value => $label)
                                        <option value="{{ $value }}" @if ($user->userData->serviceType == $value) selected="" @endif>{{ $label }}</option>
                                    @empty
                                        <option selected="">@lang('No data')</option>
                                    @endforelse
                                </select>
                                @include('Admin::common.form.error', ['key' => 'service_type'])
                            </div>
                            <div class="col-md-3 col-sm-6 form-group">
                                <label for="social" class="">@lang('Social')</label>
                                <select class="selectpicker" data-style="form-drop" name="social" id="social">
                                    @forelse ($socialOptions as $value => $label)
                                        <option value="{{ $value }}" @if ($user->userData->social == $value) selected="" @endif>{{ $label }}</option>
                                    @empty
                                        <option selected="">@lang('No data')</option>
                                    @endforelse
                                </select>
                                @include('Admin::common.form.error', ['key' => 'social'])
                            </div>
                            <div class="col-md-3 col-sm-6 form-group">
                                <label for="pornstar" class="">@lang('Pornstar')</label>
                                <select class="selectpicker" data-style="form-drop" name="pornstar" id="pornstar">
                                    @forelse ($pornstarOptions as $value => $label)
                                        <option value="{{ $value }}" @if ($user->userData->pornstar == $value) selected="" @endif>{{ $label }}</option>
                                    @empty
                                        <option selected="">@lang('No data')</option>
                                    @endforelse
                                </select>
                                @include('Admin::common.form.error', ['key' => 'pornstar'])
                            </div>
                            <div class="col-md-3 col-sm-6 form-group">
                                <label for="ethnicity_id2" class="">@lang('Ethnizität')</label>
                                <select class="selectpicker" data-style="form-drop" name="ethnicity_id2" id="ethnicity_id2">
                                    @forelse ($ethnicityOptions as $ethnicity)
                                        <option value="{{ $ethnicity->id }}" @if ($user->userData->ethnicityId2 == $ethnicity->id) selected="" @endif>{{ $ethnicity->description->content ?? '--' }}</option>
                                    @empty
                                        <option selected="">@lang('No data')</option>
                                    @endforelse
                                    @include('Admin::common.form.error', ['key' => 'ethnicity_id2'])
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save">@lang('SAVE')</button>
            </form>
        </div>
    </div>
</div>
