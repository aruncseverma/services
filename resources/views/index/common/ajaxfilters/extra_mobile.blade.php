
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