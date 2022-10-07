<div class="yourAddress">
    <div class="escortArea"><i class="fas fa-map-marker-alt"></i>Escorts in <span>Amsterdam, NL</span></div>
    <button class="changeLo">Change</button>
    <div class="changeLocation">
        <form class="default_form">
            <div class="changeLoca">
                <div class="changeBox">
                    <label>Continent</label>
                    <select id="filter_continent">
                        <option value="">Please select</option>
                        @foreach($continents as $cont)
                        <option value="{{ $cont->continent_id }}" @if(isset($param['continent_id']) && $param['continent_id']==$cont->continent_id) selected @endif>{{$cont->continent->name}}({{ $cont->total }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="changeBox">
                    <label>Country</label>
                    <select id="filter_country" {{--@if(!isset($countries)) disabled @endif--}}>
                        <option value="">Please select</option>
                        @if(isset($countries))
                        @foreach($countries as $country)
                        <option value="{{ $country->country_id }}" @if(isset($param['country_id']) && $param['country_id']==$country->country_id) selected @endif >{{ $country->country->name }} ({{ $country->total }})</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="changeLoca">
                <div class="changeBox">
                    <label>State</label>
                    <select id="filter_state" {{--@if(!isset($states)) disabled @endif--}}>
                        <option value="">Please select</option>
                        @if(isset($states))
                        @foreach($states as $state)
                        <option value="{{ $state->state_id }}" @if(isset($param['state_id']) && $param['state_id']==$state->state_id) selected @endif>{{ $state->state->name }} ({{ $state->total }})</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="changeBox">
                    <label>City</label>
                    <select id="filter_city" {{--@if(!isset($cities)) disabled @endif--}}>
                        <option value="">Please select</option>
                        @if(isset($cities))
                        @foreach($cities as $city)
                        <option value="{{ $city->city_id }}" @if(isset($param['city_id']) && $param['city_id']==$city->city_id) selected @endif>{{ $city->city->name }} ({{ $city->total }})</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="twoBtn">
                <input type="reset" value="Reset" id="locationresetbtn" class="resetBtn">
                <a href="#" class="closeBtn">X</a>
            </div>
        </form>
    </div>
    <div class="addRight">
        <div class="eFilters">
            <ul>
                <li><a href="javaScript:void(0)">Male <i class="fas fa-times"></i></a></li>
                <li><a href="javaScript:void(0)">Incall <i class="fas fa-times"></i></a></li>
                <li><a href="javaScript:void(0)">18-25 <i class="fas fa-times"></i></a></li>
            </ul>
        </div>
        <div class="searchSpace">
            <div class="searchID desktopSearch"><i class="fas fa-search"></i></div>
        </div>
    </div>
</div>