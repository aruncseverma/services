<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#physical_info">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Physical Information')</span>
        </div>
        <div class="card-header-sub">
            @lang('Please describe your phyical characteristics')
        </div>
        <div class="card-body collapse show" id="physical_info">
            <form action="{{ route('escort_admin.profile.physical_information') }}" method="POST">
                @csrf
                <div class="row">
                   
                    <div class="col-md-3 col-sm-6 form-group">
                        <label for="hair_color_id" class="">@lang('Hair Color')</label>
                        <select class="selectpicker" data-style="form-drop" name="hair_color_id" id="hair_color_id">
                            @forelse ($hairColorOptions as $option)
                                <option value="{{ $option->id }}" @if ($user->userData->hairColorId == $option->id) selected="" @endif>{{ $option->description->content ?? '--' }}</option>
                            @empty
                                <option selected="">@lang('No data')</option>
                            @endforelse
                            @include('Admin::common.form.error', ['key' => 'hair_color_id'])
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6 form-group">
                        <label for="hair_length_2_liner_id" class="">@lang('Hair Length 2 Liner')</label>
                        <select class="selectpicker" data-style="form-drop" name="hair_length_2_liner_id" id="hair_length_2_liner_id">
                            @forelse ($hairLenght2LinerOptions as $value => $label)
                                <option value="{{ $value }}" @if ($user->userData->hairLength2LinerId == $value) selected="" @endif>{{ $label }}</option>
                            @empty
                                <option selected="">@lang('No data')</option>
                            @endforelse
                        </select>
                        @include('Admin::common.form.error', ['key' => 'hair_length_2_liner_id'])
                    </div>
                    <div class="col-md-3 col-sm-6 form-group">
                        <label for="cup_size_id" class="">@lang('Cup Size')</label>
                        <select class="selectpicker" data-style="form-drop" name="cup_size_id" id="cup_size_id">
                            @forelse ($cupSizeOptions as $option)
                                <option value="{{ $option->id }}" @if ($user->userData->cupSizeId == $option->id) selected="" @endif>{{ $option->description->content ?? '--' }}</option>
                            @empty
                                <option selected="">@lang('No data')</option>
                            @endforelse
                            @include('Admin::common.form.error', ['key' => 'cup_size_id'])
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6 form-group">
                        <label for="eye_color_id" class="">@lang('Eye Color')</label>
                        <select class="selectpicker" data-style="form-drop" name="eye_color_id" id="eye_color_id">
                            @forelse ($eyeColorOptions as $option)
                                <option value="{{ $option->id }}" @if ($user->userData->eyeColorId == $option->id) selected="" @endif>{{ $option->description->content ?? '--' }}</option>
                            @empty
                                <option selected="">@lang('No data')</option>
                            @endforelse
                            @include('Admin::common.form.error', ['key' => 'eye_color_id'])
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6 form-group">
                        <label for="height_id" class="">@lang('Height')</label>
                        <select class="selectpicker" data-style="form-drop" name="height_id" id="height_id">
                            @forelse ($heightOptions as $value => $label)
                                <option value="{{ $value }}" @if ($user->userData->heightId == $value) selected="" @endif>{{ $label }}</option>
                            @empty
                                <option selected="">@lang('No data')</option>
                            @endforelse
                        </select>
                        @include('Admin::common.form.error', ['key' => 'height_id'])
                    </div>
                    <div class="col-md-3 col-sm-6 form-group">
                        <label for="weight_id" class="">@lang('Weight')</label>
                        <select class="selectpicker" data-style="form-drop" name="weight_id" id="weight_id">
                            @forelse ($weightOptions as $value => $label)
                                <option value="{{ $value }}" @if ($user->userData->weightId == $value) selected="" @endif>{{ $label }}</option>
                            @empty
                                <option selected="">@lang('No data')</option>
                            @endforelse
                        </select>
                        @include('Admin::common.form.error', ['key' => 'weight_id'])
                    </div>
                    <div class="col-md-3 col-sm-6 form-group">
                        <label for="blood_type_id" class="">@lang('Blood Type')</label>
                        <select class="selectpicker" data-style="form-drop" name="blood_type_id" id="blood_type_id">
                            @forelse ($bloodTypeOptions as $value => $label)
                                <option value="{{ $value }}" @if ($user->userData->bloodTypeId == $value) selected="" @endif>{{ $label }}</option>
                            @empty
                                <option selected="">@lang('No data')</option>
                            @endforelse
                        </select>
                        @include('Admin::common.form.error', ['key' => 'blood_type_id'])
                    </div>
                    <div class="col-md-3 col-sm-6 form-group">
                        <label for="bust_id" class="">@lang('Bust')</label>
                        <select class="selectpicker" data-style="form-drop" name="bust_id" id="bust_id">
                            @forelse ($bustOptions as $value => $label)
                                <option value="{{ $value }}" @if ($user->userData->bustId == $value) selected="" @endif>{{ $label }}</option>
                            @empty
                                <option selected="">@lang('No data')</option>
                            @endforelse
                        </select>
                        @include('Admin::common.form.error', ['key' => 'bust_id'])
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save">@lang('SAVE')</button>
            </form>
        </div>
    </div>
</div>
