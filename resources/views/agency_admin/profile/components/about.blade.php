<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#aboutme">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('About Your Agency')</span>
        </div>
        <div class="card-header-sub">
            @lang('Tell something about your agency')
        </div>
        <div class="card-body collapse show" id="aboutme">
            @if (old('notify') == 'about')
                @include('AgencyAdmin::common.notifications')
            @endif

            <form action="{{ route('agency_admin.profile.update_about') }}" method="POST" class="es es-validation" id="form_about">
                @csrf
                <input type="hidden" name="form_about" value="1">
                @foreach ($languages as $language)
                @if (!isset($showTab) && $errors->has("about.{$language->code}"))
                @php($showTab=$loop->iteration)
                @endif
                @endforeach
                @if (!isset($showTab))
                @php($showTab=1)
                @endif
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    @foreach ($languages as $language)
                        <li class="nav-item text-uppercase"> <a class="nav-link  @if ($loop->iteration == $showTab) active show @endif" data-toggle="tab" href="#tab-about-{{ $language->code }}" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">{{ $language->name }}</span></a> </li>
                    @endforeach
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabcontent-border m-b-20">
                    @foreach ($languages as $language)
                        <div class="tab-pane  @if ($loop->iteration == $showTab) active show @endif" id="tab-about-{{ $language->code }}" role="tabpanel">
                            <div class="p-20">
                                <label for="about-{{ $language->code }}" class="es-required" style="display:none;">About ({{ $language->name }})</label>
                                <textarea name="about[{{ $language->code }}]" class="form-control" id="about-{{ $language->code }}" rows="3" placeholder="@lang('About yourself')">@if(!empty(old('form_about'))){{ old("about.{$language->code}")}}@else{{ $agency->getDescription($language->code)->content }}@endif</textarea>

                                @include('AgencyAdmin::common.form.error', ['key' => "about.{$language->code}"])
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save text-uppercase">@lang('Save')</button>
            </form>
        </div>
    </div>
</div>

@pushAssets('scripts.post')
<script>
    $(document).ready(function() {
        var $form_about = $('#form_about');
        $form_about.submit(function() {
            $firstInputError = $form_about.find('small.form-control-feedback.text-danger:first');
            if ($firstInputError.length) {
                var $tabPane = $firstInputError.closest('.tab-pane');
                if ($tabPane.length) {
                    var $tabId = $tabPane.attr('id');
                    if (typeof $tabId !== 'undefined' && $tabId != '') {
                        var $tabLink = $form_about.find('[href="#' + $tabId + '"]');
                        if ($tabLink.length) {
                            $tabLink.trigger('click');
                        }
                    }
                }
            }
        });
    });
</script>
@endPushAssets