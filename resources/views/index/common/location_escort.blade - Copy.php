<div id="user_place2">
    <div class="nav-drop">
        <form class="default_form">
            <div class="row">
                <div class="col-lg-5 col-xs-20 drop-country">
                    <div class="select_parent selectTwo">
                        <select id="filter_country">
                            <option value="">Country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->country_id }}" @if(isset($param['country_id']) && $param['country_id']==$country->country_id) selected @endif >{{ $country->country->name }} ({{ $country->total }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-5 col-xs-20 drop-city">
                    <div class="select_parent selectTwo">
                        <select id="filter_state" {{--@if(!isset($states)) disabled @endif--}}>
                            <option value="">State</option>
                            @if(isset($states))
                            @foreach($states as $state)
                            <option value="{{ $state->state_id }}" @if(isset($param['state_id']) && $param['state_id']==$state->state_id) selected @endif>{{ $state->state->name }} ({{ $state->total }})</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-lg-5 col-xs-20 drop-city">
                    <div class="select_parent selectTwo">
                        <select id="filter_city" {{--@if(!isset($cities)) disabled @endif--}}>
                            <option value="">City</option>
                            @if(isset($cities))
                            @foreach($cities as $city)
                            <option value="{{ $city->city_id }}" @if(isset($param['city_id']) && $param['city_id']==$city->city_id) selected @endif>{{ $city->city->name }} ({{ $city->total }})</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <form method="POST" action="{{ route('index.home') }}">
                    <div class="col-lg-5 col-xs-20 drop-search">
                        <input class="input_field" name="search" id="filter-search-text">
                        <button class="btn btn-lumia-search" type="submit" id="filter-search-btn">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>