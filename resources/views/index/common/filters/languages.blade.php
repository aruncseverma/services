{{-- Language Filter --}}

<div class="languagesF mobileN" id="langfilter">
    <div class="addLanguage">
        <div class="addLangL">
            <label>Languages</label>
            @php
            $langIds = isset($param['lang_ids']) && !empty($param['lang_ids']) ? explode(',', $param['lang_ids']) : [];
            @endphp
            <div class="pleaseSelect">
                <div class="oSelect">
                    <select class="custom-control-input" id="filter_languages" name="language" multiple>
                        <option value="">Please select</option>
                        @foreach($languages as $language)
                        <option value="{{ $language->id }}" @if($language->total==0) disabled @endif>{{ $language->content }} ({{ $language->total }})</option>
                        @endforeach
                    </select>
                    <span class="fNumber languageTotal"></span>
                </div>
                <button class="addLang" id="addlanguagenutton">+</button>
            </div>
        </div>
        <div class="addLangR">
            <ul class="clear langclear">
                <!--<li><a href="#">Japanese<span>X</span></a></li>
                <li><a href="#">Spanish<span>X</span></a></li>
                <li><a href="#">English<span>X</span></a></li>
                <li><a href="#">Korean<span>X</span></a></li>
                <li><a href="#">English<span>X</span></a></li>
                <li><a href="#">Korean<span>X</span></a></li>
                <li><a href="#">Japanese<span>X</span></a></li>-->
            </ul>
        </div>
    </div>
    <div class="twoBtn">
        <input type="reset" value="Reset" id="resetLanguageFilter" class="resetBtn">
        <a href="#" class="closeBtn">X</a>
    </div>
</div>
{{-- End Language Filter --}}