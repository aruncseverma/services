{{-- Basic Filter --}}
<form class="default_form" style="display: contents;">
    <div class="lookingFor">
        <input type="text" class="lookingBox" id="filter-search-text" placeholder="Who are you looking for?">
        <button class="searchOne" id="filter-search-btn"><i class="fas fa-search"></i></button>
    </div>
    <div class="basicL">
        <div class="basicBox">
            <label>Escort Gender</label>
            <div class="gender escortG">                
                <label class="escortG1 @if(!isset($param['gender']) || $param['gender']=='F') active @endif">
                    <input id="escortG1" value="F" type="radio" name="gender">
                    <img src="{{ asset('assets/theme/index/default/images/index/female.png') }}" alt="Female">
                    <span class="Onumber gf">{{ (!isset($param['gender']) || $param['gender']=='F') ? $femaleTotal : ''}}</span>
                </label>
                   
                <label class="escortG2 @if(isset($param['gender']) && $param['gender']=='M') active @endif">
                    <input id="escortG2" value="M" type="radio" name="gender">
                    <img src="{{ asset('assets/theme/index/default/images/index/male.png') }}" alt="Male">
                    <span class="Onumber gm">{{ (isset($param['gender']) && $param['gender']=='M') ? $maleTotal : ''}}</span>
                </label>
                   
                <label class="escortG3 @if(isset($param['gender']) && $param['gender']=='B') active @endif">
                    <input id="escortG3" value="B" type="radio" name="gender">
                    <img src="{{ asset('assets/theme/index/default/images/index/intersex.png') }}" alt="Bysexual">
                    <span class="Onumber gb">{{ (isset($param['gender']) && $param['gender']=='B') ? $bysexualTotal : ''}}</span>
                </label>
                    
                <label class="escortG4 @if(isset($param['gender']) && $param['gender']=='C') active @endif">
                    <input id="escortG4" value="C" type="radio" name="gender">
                    <img src="{{ asset('assets/theme/index/default/images/index/hetero.png') }}" alt="Couple">
                    <span class="Onumber gh">{{ (isset($param['gender']) && $param['gender']=='B') ? $hetroTotal : ''}}</span>
                </label>
                    
            </div>
        </div>
        <div class="basicBox">
            <label>Client Gender</label>
            <div class="gender clientG">
                <label class="clientG1"><input id="clientG1" type="radio" name="clientG"><img src="{{ asset('assets/theme/index/default/images/index/female.png') }}" alt=""><span></span></label>
                <label class="clientG2"><input id="clientG2" type="radio" name="clientG"><img src="{{ asset('assets/theme/index/default/images/index/male.png') }}" alt=""><span></span></label>
                <label class="clientG3"><input id="clientG3" type="radio" name="clientG"><img src="{{ asset('assets/theme/index/default/images/index/intersex.png') }}" alt=""><span></span></label>
                <label class="clientG4"><input id="clientG4" type="radio" name="clientG"><img src="{{ asset('assets/theme/index/default/images/index/hetero.png') }}" alt=""><span></span></label>
            </div>
        </div>
        <div class="pRange">
            <div class="rangeArea">
                <label>Price (Range)</label>
                <div class="selectBox">
                    <select>
                        <option>Dollar</option>
                        <option>Euro</option>
                    </select>
                </div>
            </div>
            <input type="text" name="price" value="" id="priceRange"/>
        </div>
        <div class="aRange">
            <label>Age (Range)<span class="ag_range"></span></label>
            <input type="text" name="age" value="" id="ageRange"/>
        </div>
    </div>
    <div class="basicR" id="basicRightSearch">
        <div class="selectBox">
            <label>Ethnicity</label>
            <select id="ethnicity" name="ethnicity">
                <option value="">Please select</option>
                @foreach($ethnicityOptions as $ethnicity)
                <option value="{{ $ethnicity->id }}" @if(isset($param['ethnicity']) && $param['ethnicity']==$ethnicity->id ) selected @endif @if($ethnicity->total==0) disabled @endif>{{ $ethnicity->content ?? '--' }}({{$ethnicity->total}})</option>
                @endforeach
            </select>            
        </div>
        <div class="selectBox">
            <label>Availability</label>
            <select id="service_type" name="service_type">
                <option value="">Please select</option>
                <option value="I" @if(isset($param['service_type']) && $param['service_type']=='I' ) selected @endif @if($total_availability['I']==0) disabled @endif>Incall ({{ $total_availability['I'] ?? 0 }})</option>
                <option value="O" @if(isset($param['service_type']) && $param['service_type']=='O' ) selected @endif @if($total_availability['O']==0) disabled @endif>Outcall ({{ $total_availability['O'] ?? 0 }})</option>
            </select>
        </div>
        <div class="selectBox">
            <label>Validation</label>
            <select id="verification" name="verification">
                <option value="">Please select</option>
                <option value="1" @if(isset($param['verification']) && $param['verification']=='1' ) selected @endif @if($verified==0) disabled @endif>Verified Member ({{$verified}})</option>
                <option value="2" @if(isset($param['verification']) && $param['verification']=='2' ) selected @endif @if($silver==0) disabled @endif>Silver Member ({{$silver}})</option>
                <option value="3" @if(isset($param['verification']) && $param['verification']=='3' ) selected @endif @if($gold==0) disabled @endif>Gold Member ({{$gold}})</option>
            </select>
        </div>
        <div class="twoBtn">
            <input type="reset" id="basicresetbtn" value="Reset" class="resetBtn">
            <a href="#" class="closeBtn">X</a>
        </div>
    </div>
</form>
{{-- End Basic Filter --}}