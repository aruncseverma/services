<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#aboutme">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('About Me')</span>
        </div>
        <div class="card-header-sub">
            @lang('Tell something about yourself')
        </div>
        <div class="card-body collapse show" id="aboutme">
            <form action="{{ route('escort_admin.profile.about_me') }}" method="POST" class="es es-validation" id="form_about">
            @csrf
            <input type="hidden" name="form_about" value="1">
            @foreach ($languageOptions as $language)
            @if (!isset($showTab) && $errors->has("descriptions.{$language->code}"))
            @php($showTab=$loop->iteration)
            @endif
            @endforeach
            @if (!isset($showTab))
            @php($showTab=1)
            @endif
            @forelse ($languageOptions as $language)
                @if ($language->code)
                    @section('tab_menu')
                        <li class="nav-item"> <a class="nav-link @if ($loop->iteration == $showTab) active show @endif" data-toggle="tab" href="#tab_{{ $language->code ?? '' }}" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">{{ $language->name ?? '' }}</span></a> </li>
                        @parent
                    @endsection
                    @section('tab_content')
                        <div class="tab-pane @if ($loop->iteration == $showTab) active show @endif" id="tab_{{ $language->code}}" role="tabpanel">
                            <div class="p-20">
                                <label for="descriptions-{{ $language->code }}" class="es-required" style="display:none;">About ({{ $language->name }})</label>
                                <textarea class="form-control" id="descriptions-{{ $language->code }}" name="descriptions[{{ $language->code }}]" id="" rows="3" placeholder="About yourself">@if(!empty(old('form_about'))){{ old("descriptions.{$language->code}")}}@else{{ $user->getDescription($language->code)->content }}@endif</textarea>
                                @include('EscortAdmin::common.form.error', ['key' => "descriptions.{$language->code}"])
                            </div>
                        </div>
                        @parent
                    @endsection
                @endif
            @empty
            @endforelse

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                @section('tab_menu')
                @show
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tabcontent-border m-b-20">
                @section('tab_content')
                @show
            </div>

            <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save">@lang('SAVE')</button>
            <button type="submit" class="btn btn-outline-secondary waves-effect waves-light button-save-two m-r-10">@lang('CLEAR')</button>
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