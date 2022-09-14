<div id="user_place">
    <div class="nav-drop">
        <form class="default_form">
            <div class="row">
                <div class="col-lg-5 col-xs-20 drop-country">
                    <div class="select_parent selectTwo">
                        <select id="country">
                            <option>Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->country->name }}" @if(isset($param['country_id']) && $param['country_id'] == $country->country_id) selected @endif >{{ $country->country->name }} ({{ $country->total }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-5 col-xs-20 drop-city">
                    <div class="select_parent selectTwo">
                        <select id="state" @if(!isset($states)) disabled @endif>
                            <option>State</option>
                            @if(isset($states))
                                @foreach($states as $state)
                                    <option value="{{ $state->state->name }}" @if(isset($param['state_id']) && $param['state_id'] == $state->state_id) selected @endif>{{ $state->state->name }} ({{ $state->total }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-lg-5 col-xs-20 drop-city">
                    <div class="select_parent selectTwo">
                        <select id="city" @if(!isset($cities)) disabled @endif>
                            <option>City</option>
                            @if(isset($cities))
                                @foreach($cities as $city)
                                    <option value="{{ $city->city->name }}">{{ $city->city->name }} ({{ $city->total }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <form method="POST" action="{{ route('index.home') }}">
                <div class="col-lg-5 col-xs-20 drop-search">
                    <input class="input_field" name="search">
                    <button class="btn btn-lumia-search" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                </form>
            </div>
        </form>
    </div>
</div>