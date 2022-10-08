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