@pushAssets('scripts.post')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
        document.getElementById('{{ $formId ?? "" }}').submit();
    }
</script>
@endPushAssets

<button class="g-recaptcha {{ $classes ?? '' }}" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-callback='onSubmit' data-action='submit'>{!! $txt ?? 'Save' !!}</button>
@include('Index::common.form.error', ['key' => 'g-recaptcha-response'])