{{-- Language Filter --}}
<h2 class="resp-accordion hor_1" role="tab"></h2>
<div class="item-content row" id="filter_languages">
    @php
    $langIds = isset($param['lang_ids']) && !empty($param['lang_ids']) ? explode(',', $param['lang_ids']) : [];
    @endphp
    @foreach($languages as $language)
    <div class="col-lg-5">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="{{ $language->id }}" value="{{ $language->id }}" @if(in_array($language->id, $langIds)) checked @endif>
            <label class="custom-control-label" for="{{ $language->content }}">{{ $language->content }} ({{ $language->total }})</label>
        </div>
    </div>
    @endforeach
    <div class="clearfix"></div>
</div>
{{-- End Language Filter --}}