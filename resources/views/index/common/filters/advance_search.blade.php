{{-- Advance Search --}}
<div class="advancedSearch">
    <div id="advancedSearch">
        <ul class="resp-tabs-list hor_2">
            <li>Physical</li>
            <li>Extra</li>
            <li>Languages</li>
        </ul>
        <div class="resp-tabs-container hor_2">
            <div class="physicalF" id="physicalfiltermobile">
                <div class="basicL">
                    <div class="pRange">
                        <div class="rangeArea">
                            <label>Height (Range)<span></span></label>                            
                        </div>                        
                        <div class="euroOption">
                            <input type="text" name="height" value="" id="heightRangeEM"/>                            
                        </div>
                    </div>
                    <div class="selectBox">
                        <label>Origin / Ethnicity</label>
                        <select id="ethnicity" name="ethnicity">
                            <option value="">Please select</option>
                            @foreach($ethnicityOptions as $ethnicity)
                            <option value="{{ $ethnicity->id }}" @if(isset($param['ethnicity']) && $param['ethnicity']==$ethnicity->id ) selected @endif @if($ethnicity->total==0) disabled @endif>{{ $ethnicity->content ?? '--' }}({{$ethnicity->total}})</option>
                            @endforeach
                        </select>
                        <span class="fNumber ethi_total"></span>
                    </div>
                    <div class="selectBox">
                        <label>Breast Size</label>
                        <select id="cup_size" name="cup_size">
                            <option value="">Please select</option>
                            @forelse($cupSizeOptions as $cup)                
                            <option value="{{ $cup->id }}" @if(isset($param['cup_size']) && $param['cup_size']==$cup->id ) selected @endif @if($cup->total==0) disabled @endif>{{ $cup->content }} ({{$cup->total}})</option> 
                            @empty
                            @endforelse 
                        </select>
                        <span class="fNumber cupSizeTotal"></span>
                    </div>
                    <div class="selectBox">
                        <label>Build</label>
                        <select id="body_type" name="body_type">
                            <option value="">Please select</option>
                            @forelse($buildOptions as $build)                
                            <option value="{{ $build->id }}" @if(isset($param['body_type']) && $param['body_type']==$build->id ) selected @endif @if($build->total==0) disabled @endif>{{ $build->content }} ({{$build->total}})</option>
                            @empty
                            @endforelse 
                        </select>
                        <span class="fNumber buildTotal"></span>
                    </div>
                </div>
                <div class="basicR">
                    <div class="selectBox">
                        <label>Hair Length</label>
                        <select id="hair_length" name="hair_length">
                            <option value="">Please select</option>
                            @forelse($hairLengthOptions as $val => $lbl)
                            <option value="{{ $val }}" @if(isset($param['hair_length']) && $param['hair_length']==$val ) selected @endif>{{ $lbl }}</option>
                            @empty
                            @endforelse                    
                        </select>
                        <span class="fNumber hairLengthTotal"></span>
                    </div>
                    <div class="selectBox">
                        <label>Eye Color</label>
                        <select id="eye_color" name="eye_color_id">
                            <option value="">Please select</option>
                            @forelse($eyeColors as $k)
                            <option value="{{ $k->id }}" @if(isset($param['eye_color_id']) && $param['eye_color_id']==$k->id ) selected @endif @if($k->total==0) disabled @endif>{{ $k->content }} ({{$k->total}})</option>
                            @empty
                            @endforelse
                        </select>
                        <span class="fNumber eyeColorTotal"></span>
                    </div>
                    <div class="selectBox">
                        <label>Pubic Hair</label>
                        <select id="public_hair" name="public_hair">
                            <option value="">Please select</option>
                            @forelse($publicHairs as $phair)                
                            <option value="{{ $phair->id }}" @if(isset($param['public_hair']) && $param['public_hair']==$phair->id ) selected @endif @if($phair->total==0) disabled @endif>{{ $phair->content }} ({{$phair->total}})</option> 
                            @empty
                            @endforelse               
                        </select>
                        <span class="fNumber publicHairTotal"></span>
                    </div>
                    <div class="twoBtn">
                        <input type="reset" value="Reset" id="physicalresetbtn" class="resetBtn">
                        <a href="#" class="closeBtn">X</a>
                    </div>
                </div>
            </div>
            <div class="extraF" id="extrafiltermobile">
                <div class="basicL">
                    <div class="selectBox">
                        <label>Escort Type</label>
                        <select id="escort_type" name="escort_type">
                            <option value="">Please select</option>
                            @foreach($escortTypeOptions as $esttype)
                            <option value="{{ $esttype->id }}" @if(isset($param['escort_type']) && $param['escort_type']==$esttype->id ) selected @endif @if($esttype->total==0) disabled @endif>{{$esttype->content}} ({{$esttype->total}})</option>
                            @endforeach
                        </select>
                        <span class="fNumber escortTypeTotal"></span>
                    </div>
                    <div class="selectBox">
                        <label>Nationality</label>
                        <select id="origin" name="origin">
                            <option value="">Please select</option>
                            @foreach($originOptions as $origin)
                            <option value="{{ $origin->id }}" @if(isset($param['origin']) && $param['origin']==$origin->id ) selected @endif @if($origin->total==0) disabled @endif>{{ $origin->name }} ({{ $origin->total }})</option>
                            @endforeach
                        </select>
                        <span class="fNumber originTotal"></span>
                    </div>
                    <div class="selectBox">
                        <label>Travels</label>
                        <select id="travel" name="travel">
                            <option value="">Please select</option>
                            @foreach($travelOptions as $travel)
                            <option value="{{ $travel->id }}" @if(isset($param['travel']) && $param['travel']==$travel->id ) selected @endif @if($travel->total==0) disabled @endif>{{$travel->content}} ({{$travel->total}})</option>
                            @endforeach
                        </select>
                        <span class="fNumber travelTotal"></span>
                    </div>
                    <div class="selectBox">
                        <label>Smokes</label>
                        <select id="smoke" name="smoke">
                            <option value="">Please select</option>
                            @foreach($smokeOptions as $smoke)
                            <option value="{{ $smoke->id }}" @if(isset($param['smoke']) && $param['smoke']==$drink->id ) selected @endif @if($smoke->total==0) disabled @endif>{{$smoke->content}} ({{$smoke->total}})</option>
                            @endforeach
                        </select>
                        <span class="fNumber smokeTotal"></span>
                    </div>
                </div>
                <div class="basicR">
                    <div class="selectBox">
                        <label>Drinks</label>
                        <select id="drink" name="drink">
                            <option value="">Please select</option>
                            @foreach($drinkOptions as $drink)
                            <option value="{{ $drink->id }}" @if(isset($param['drink']) && $param['drink']==$drink->id ) selected @endif @if($drink->total==0) disabled @endif>{{$drink->content}} ({{$drink->total}})</option>
                            @endforeach
                        </select>
                        <span class="fNumber drinkTotal"></span>
                    </div>
                    <div class="selectBox">
                        <label>Has Videos</label>
                        <select id="with_video" name="with_video">
                            <option value="">Please select</option>
                            <option value="1" @if(isset($param['with_video']) && $param['with_video']==1 ) selected @endif @if($total_with_video==0) disabled @endif>Yes ({{ $total_with_video ?? 0 }})</option>
                            <option value="0" @if(isset($param['with_video']) && $param['with_video']==0 ) selected @endif @if($total_without_video==0) disabled @endif>No ({{ $total_without_video ?? 0 }})</option>
                        </select>
                        <span class="fNumber videoTotal"></span>
                    </div>
                    <div class="selectBox">
                        <label>Has Reviews</label>
                        <select id="has_reviews" name="with_review">
                            <option value="">Please select</option>
                            <option value="1" @if(isset($param['with_review']) && $param['with_review']==1 ) selected @endif @if($total_with_review==0) disabled @endif>Yes ({{ $total_with_review ?? 0 }})</option>
                            <option value="0" @if(isset($param['with_review']) && $param['with_review']==0 ) selected @endif @if($total_without_review==0) disabled @endif>No ({{ $total_without_review ?? 0 }})</option>
                        </select>
                        <span class="fNumber reviewTotal"></span>
                    </div>
                    <div class="twoBtn">
                        <input type="reset" value="Reset" id="extraresetbtn" class="resetBtn">
                        <a href="#" class="closeBtn">X</a>
                    </div>
                </div>
            </div>
            <div class="languagesF">
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
                                <option value="{{ $language->id }}" @if($language->total==0) disabled @endif>{{ $language->content }} ({{ $language->total }}) </option>
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
        </div>
    </div>
</div>
{{-- End Advance Search --}}