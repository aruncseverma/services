<div class="col-md-6">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#language-prof">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Language Proficiency')</span>
        </div>
        <div class="card-header-sub">
            @lang('Please select your language proficiency')
        </div>
        <div class="card-body collapse show" id="language-prof">
            <form action="{{ route('escort_admin.profile.language_proficiency.add') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>@lang('Language')</th>
                            <th>@lang('Proficiency')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user->escortLanguages as $lang)
                            <tr>
                                <td>{{ $lang->attribute->description->content ?? '' }}</td>
                                <td>{{ $languageProficiencyOptions[$lang->proficiency] ?? $lang->proficiency }}</td>
                                <td class="td-icons"><a href="{{ route('escort_admin.profile.language_proficiency.delete', ['id' => $lang->attribute_id ]) }}" class="es es-confirm"><i class="mdi mdi-delete"></i></a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" align="center">@lang('No data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-sm-5 form-group">
                    <label for="language_proficiency_language" class="">@lang('Add language')</label>
                    <select class="selectpicker" data-style="form-drop" name="language_proficiency[language]" id="language_proficiency_language">
                        @forelse ($escortLanguageOptions as $option)
                            <option value="{{ $option->id }}">{{ $option->description->content ?? '--' }}</option>
                        @empty
                            <option selected="">@lang('No data')</option>
                        @endforelse
                        @include('Admin::common.form.error', ['key' => 'language_profiency.language'])
                    </select>
                </div>
                <div class="col-sm-5 form-group">
                    <label for="language_profiency_proficiency" class="">@lang('Proficiency')</label>
                    <select class="selectpicker" data-style="form-drop" name="language_proficiency[proficiency]" id="language_proficiency_proficiency">
                        @forelse ($languageProficiencyOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @empty
                            <option selected="">@lang('No data')</option>
                        @endforelse
                    </select>
                    @include('Admin::common.form.error', ['key' => 'hair_length_2_liner_id'])
                </div>
                <div class="col-sm-2 form-group">
                    <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save" style="width: 100%">+</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
