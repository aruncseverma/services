{{-- Extra Services --}}
<div class="ServicesSearch" id="servfilterlist">
    <div class="addLanguage">
        <div class="addLangL">
            <label>Escort Services</label>
            <div class="pleaseSelect">
                <div class="oSelect">
                @php
                $escortServiceIds = isset($param['escort_service_ids']) && !empty($param['escort_service_ids']) ? explode(',', $param['escort_service_ids']) : [];
                @endphp
                    <select id="filter_escort_services" name="escort_service_ids" multiple>
                        <option value="">Please select</option>
                        @forelse($escortServices as $service)
                        <option value="{{ $service->id }}" @if(in_array($service->id, $escortServiceIds)) selected @endif @if($service->total==0) disabled @endif>{{ $service->content }} ({{ $service->total }})</option>
                        @empty
                        @endforelse
                    </select>
                    <span class="fNumber escortServiceTotal"></span>
                </div>
                <button class="addLang" id="addescortservice">+</button>
            </div>
        </div>
        <div class="addLangR">
            <ul class="clear escortservicellist">
                <!--<li><a href="#">Anal<span>X</span></a></li>
                <li><a href="#">69<span>X</span></a></li>
                <li><a href="#">Blowjob<span>X</span></a></li>
                <li><a href="#">Sensual<span>X</span></a></li>-->
            </ul>
        </div>
    </div>
    <div class="addLanguage">
        <div class="addLangL">
            <label>Erotic Services</label>
            <div class="pleaseSelect">
            @php
            $eroticServiceIds = isset($param['erotic_service_ids']) && !empty($param['erotic_service_ids']) ? explode(',', $param['erotic_service_ids']) : [];
            @endphp
                <div class="oSelect">
                    <select id="filter_erotic_services" name="erotic_service_ids">
                        <option value="">Please select</option>
                        @forelse($eroticServices as $service)
                        <option value="{{ $service->id }}" @if(in_array($service->id, $eroticServiceIds)) selected @endif @if($service->total==0) disabled @endif>{{ $service->content }} ({{ $service->total }})</option>
                        @empty
                        @endforelse
                    </select>
                    <span class="fNumber eroticServiceTotal"></span>
                </div>
                <button class="addLang" id="addEroticServiceBtn">+</button>
            </div>
        </div>
        <div class="addLangR">
            <ul class="clear eroticservicellist">
                <!--<li><a href="#">Sensual BJ<span>X</span></a></li>
                <li><a href="#">The GF Experience<span>X</span></a></li>-->
            </ul>
        </div>
    </div>
    <div class="addLanguage">
        <div class="addLangL">
            <label>Fetish</label>
            <div class="pleaseSelect">
                @php
                $fetishServiceIds = isset($param['fetish_service_ids']) && !empty($param['fetish_service_ids']) ? explode(',', $param['fetish_service_ids']) : [];
                @endphp
                <div class="oSelect">
                    <select id="filter_fetish_services" name="fetish_service_ids">
                        <option value="">Please select</option>
                        @forelse($fetishServices as $service)
                        <option value="{{ $service->id }}" @if(in_array($service->id, $fetishServiceIds)) selected @endif @if($service->total==0) disabled @endif>{{ $service->content }} ({{ $service->total }})</option>
                        @empty
                        @endforelse
                    </select>
                    <span class="fNumber fetishTotal"></span>
                </div>
                <button class="addLang" id="addFetishServiceBtn">+</button>
            </div>
        </div>
        <div class="addLangR">
            <ul class="clear fetishservicellist">
                <!--<li><a href="#">Leather<span>X</span></a></li>
                <li><a href="#">Foot Fetish<span>X</span></a></li>-->
            </ul>
        </div>
    </div>
    <div class="addLanguage">
        <div class="addLangL">
            <label>Extra Services</label>
            <div class="pleaseSelect">
            @php
            $extraServiceIds = isset($param['extra_service_ids']) && !empty($param['extra_service_ids']) ? explode(',', $param['extra_service_ids']) : [];
            @endphp
                <div class="oSelect">
                    <select id="filter_extra_services" name="extra_service_ids">
                        <option value="">Please select</option>
                        @forelse($extraServices as $service)
                        <option value="{{ $service->id }}" @if(in_array($service->id, $extraServiceIds)) checked @endif @if($service->total==0) disabled @endif>{{ $service->content }} ({{ $service->total }})</option>
                        @empty
                        @endforelse
                    </select>
                    <span class="fNumber extraServiceTotal"></span>
                </div>
                <button class="addLang" id="addExtraServiceBtn">+</button>
            </div>
        </div>
        <div class="addLangR">
            <ul class="clear extraservicelist">
                <!-- <li><a href="#">Ass then Mouth<span>X</span></a></li>
                <li><a href="#">Handcuffs<span>X</span></a></li>-->
            </ul>
        </div>
    </div>
    <div class="twoBtn">
        <input type="reset" value="Reset" id="serviceresetbtn" class="resetBtn">
        <a href="#" class="closeBtn">X</a>
    </div>
</div>
{{-- End Extra Services --}}