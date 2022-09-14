{{-- Basic Filter --}}

<div class="centerwrap clear">
        <div class="searchDrop">
            <div id="searchFilter">
                <ul class="resp-tabs-list hor_1">
                    <li>Basic</li>
                    <li class="onlyMobile">Advanced</li>
                    <li class="mobileN">Physical</li>
                    <li class="mobileN">Extra</li>
                    <li class="mobileN">Languages</li>
                    <li>Services</li>
                </ul>
                <div class="resp-tabs-container hor_1">
                	<span class="totalRecords">1560 available records</span>
                    <div class="basicSearch">
                    	<div class="lookingFor">
                            <input type="text" class="lookingBox" placeholder="Who are you looking for?">
                            <button class="searchOne"><i class="fas fa-search"></i></button>
                        </div>
                    	<div class="basicL">
                        	<div class="basicBox">
                            	<label>Escort Gender</label>
                                <div class="gender escortG">
                                	<label class="escortG1"><input id="escortG1" type="radio" name="escortG"><img src="images/female.png" alt=""><span>2</span></label>
                                    <label class="escortG2"><input id="escortG2" type="radio" name="escortG"><img src="images/male.png" alt=""><span>25483</span></label>
                                    <label class="escortG3"><input id="escortG3" type="radio" name="escortG"><img src="images/intersex.png" alt=""><span>9142</span></label>
                                    <label class="escortG4"><input id="escortG4" type="radio" name="escortG"><img src="images/hetero.png" alt=""><span>150</span></label>
                                </div>
                            </div>
                            <div class="basicBox">
                            	<label>Client Gender</label>
                                <div class="gender clientG">
                                	<label class="clientG1"><input id="clientG1" type="radio" name="clientG"><img src="images/female.png" alt=""><span>16</span></label>
                                    <label class="clientG2"><input id="clientG2" type="radio" name="clientG"><img src="images/male.png" alt=""><span>8</span></label>
                                    <label class="clientG3"><input id="clientG3" type="radio" name="clientG"><img src="images/intersex.png" alt=""><span>45</span></label>
                                    <label class="clientG4"><input id="clientG4" type="radio" name="clientG"><img src="images/hetero.png" alt=""><span>3</span></label>
                                </div>
                            </div>
                            <div class="pRange">
                            	<div class="rangeArea">
                                    <label>Price (Range)<span>23</span></label>
                                    <div class="selectBox">
                                        <select>
                                            <option>Dollar</option>
                                            <option>Euro</option>
                                        </select>
                                    </div>
                                </div>
                            	<input type="text" name="rangeName" value="200;1500" id="priceRange"/>
                                <script>
									$("#priceRange").ionRangeSlider({
										min: 100,
										max: 2000,
										from: 200,
										to: 1500,
										type: "double",
										step: 10,
										prefix: "$",
										onChange: function(obj){
											console.log(obj);
										},
										onFinish: function(obj){
											console.log(obj);
										}
									});
								</script>
                            </div>
                            <div class="aRange">
                            	<label>Age (Range)<span>23</span></label>
                            	<input type="text" name="rangeName" value="200;1500" id="ageRange"/>
                                <script>
									$("#ageRange").ionRangeSlider({
										min: 18,
										max: 40,
										from: 20,
										to: 36,
										type: "double",
										step: 1,
										postfix: " yrs old",
										onChange: function(obj){
											console.log(obj);
										},
										onFinish: function(obj){
											console.log(obj);
										}
									});
								</script>
                            </div>
                        </div>
                        <div class="basicR">
	                        <div class="selectBox">
                            	<label>Origin / Ethnicity</label>
                                <select>
                                	<option>Please select</option>
                                </select>
                                <span class="fNumber">2843</span>
                            </div>
                            <div class="selectBox">
                            	<label>Availability</label>
                                <select>
                                	<option>Please select</option>
                                </select>
                                <span class="fNumber">23</span>
                            </div>
                            <div class="selectBox">
                            	<label>Validation</label>
                                <select>
                                	<option>Please select</option>
                                </select>
                                <span class="fNumber">69823</span>
                            </div>
                            <div class="twoBtn">
                            	<input type="reset" value="Reset" class="resetBtn">
                                <a href="#" class="closeBtn">X</a>
                            </div>
                        </div>
                    </div>
                    <div class="advancedSearch">
                    	<div id="advancedSearch">
                            <ul class="resp-tabs-list hor_2">
                                <li>Physical</li>
                                <li>Extra</li>
                                <li>Languages</li>
                            </ul>
                            <div class="resp-tabs-container hor_2">
                            	<div class="physicalF">
                                	<div class="basicL">
                                    	<div class="pRange">
                                        	<div class="rangeArea">
                                                <label>Height (Range)<span>16</span></label>
                                                <div class="selectBox">
                                                    <select>
                                                        <option>Dollar</option>
                                                        <option selected>Euro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--<div class="dollarOption">
                                                <input type="text" name="rangeName" value="200;1500" id="heightRangeM"/>
                                                <script>
                                                    $("#heightRangeM").ionRangeSlider({
                                                        min: 60,
                                                        max: 84,
                                                        from: 62,
                                                        to: 73,
                                                        type: "double",
                                                        prettify: function(num) {
                                                            var feet = Math.floor(num / 12);
                                                            var inches = num % 12;
                                                            return feet + "'" + inches + '"'; // output something like 6"7'
                                                        }
                                                    });
                                                </script>
                                            </div>-->
                                            <div class="euroOption">
                                                <input type="text" name="rangeName" value="200;1500" id="heightRangeEM"/>
                                                <script>
                                                    $("#heightRangeEM").ionRangeSlider({
                                                        min: 150,
                                                        max: 220,
                                                        from: 160,
                                                        to: 200,
														postfix: " cm",
                                                        type: "double"
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="selectBox">
                                            <label>Origin / Ethnicity</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Breast Size</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Build</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                    </div>
                                    <div class="basicR">
                                    	<div class="selectBox">
                                            <label>Hair Length</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Eye Color</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Pubic Hair</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="twoBtn">
                                            <input type="reset" value="Reset" class="resetBtn">
                                            <a href="#" class="closeBtn">X</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="extraF">
                                	<div class="basicL">
                                    	<div class="selectBox">
                                            <label>Escort Type</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Nationality</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Travels</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Smokes</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                    </div>
                                    <div class="basicR">
                                    	<div class="selectBox">
                                            <label>Drinks</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Has Videos</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Has Reviews</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="twoBtn">
                                            <input type="reset" value="Reset" class="resetBtn">
                                            <a href="#" class="closeBtn">X</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="languagesF">
                                	<div class="addLanguage">
                                    	<div class="addLangL">
                                        	<label>Has Reviews</label>
                                            <div class="pleaseSelect">
                                            	<div class="oSelect">
                                                    <select>
                                                        <option>Please select</option>
                                                    </select>
                                                    <span class="fNumber">23</span>
                                                </div>
                                                <button class="addLang">+</button>
                                                
                                            </div>
                                        </div>
                                        <div class="addLangR">
                                        	<ul class="clear">
                                            	<li><a href="#">Japanese<span>X</span></a></li>
                                                <li><a href="#">Spanish<span>X</span></a></li>
                                                <li><a href="#">English<span>X</span></a></li>
                                                <li><a href="#">Korean<span>X</span></a></li>
                                                <li><a href="#">English<span>X</span></a></li>
                                                <li><a href="#">Korean<span>X</span></a></li>
                                                <li><a href="#">Japanese<span>X</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="twoBtn">
                                        <input type="reset" value="Reset" class="resetBtn">
                                        <a href="#" class="closeBtn">X</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="physicalF mobileN">
                                	<div class="basicL">
                                    	<div class="pRange">
                                            <div class="rangeArea">
                                                <label>Height (Range)<span>23</span></label>
                                                <div class="selectBox">
                                                    <select>
                                                        <option>Dollar</option>
                                                        <option selected>Euro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--<div class="dollarOption">
                                                <input type="text" name="rangeName" value="200;1500" id="heightRange"/>
                                                <script>
                                                    $("#heightRange").ionRangeSlider({
                                                        min: 60,
                                                        max: 84,
                                                        from: 62,
                                                        to: 73,
                                                        type: "double",
                                                        prettify: function(num) {
                                                            var feet = Math.floor(num / 12);
                                                            var inches = num % 12;
                                                            return feet + "'" + inches + '"'; // output something like 6"7'
                                                        }
                                                    });
                                                </script>
                                            </div>-->
                                            <div class="euroOption">
                                                <input type="text" name="rangeName" value="200;1500" id="heightRangeE"/>
                                                <script>
                                                    $("#heightRangeE").ionRangeSlider({
                                                        min: 150,
                                                        max: 220,
                                                        from: 160,
                                                        to: 200,
														postfix: " cm",
                                                        type: "double"
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="selectBox">
                                            <label>Origin / Ethnicity</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Breast Size</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Build</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                    </div>
                                    <div class="basicR">
                                    	<div class="selectBox">
                                            <label>Hair Length</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Eye Color</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Pubic Hair</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="twoBtn">
                                            <input type="reset" value="Reset" class="resetBtn">
                                            <a href="#" class="closeBtn">X</a>
                                        </div>
                                    </div>
                                </div>
                    <div class="extraF mobileN">
                                	<div class="basicL">
                                    	<div class="selectBox">
                                            <label>Escort Type</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Nationality</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Travels</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Smokes</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                    </div>
                                    <div class="basicR">
                                    	<div class="selectBox">
                                            <label>Drinks</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Has Videos</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="selectBox">
                                            <label>Has Reviews</label>
                                            <select>
                                                <option>Please select</option>
                                            </select>
                                            <span class="fNumber">23</span>
                                        </div>
                                        <div class="twoBtn">
                                            <input type="reset" value="Reset" class="resetBtn">
                                            <a href="#" class="closeBtn">X</a>
                                        </div>
                                    </div>
                                </div>
                    <div class="languagesF mobileN">
                        <div class="addLanguage">
                            <div class="addLangL">
                                <label>Languages</label>
                                <div class="pleaseSelect">
                                	<div class="oSelect">
                                        <select>
                                            <option>Please select</option>
                                        </select>
                                    	<span class="fNumber">23</span>
                                    </div>
                                    <button class="addLang">+</button>
                                </div>
                            </div>
                            <div class="addLangR">
                                <ul class="clear">
                                    <li><a href="#">Japanese<span>X</span></a></li>
                                    <li><a href="#">Spanish<span>X</span></a></li>
                                    <li><a href="#">English<span>X</span></a></li>
                                    <li><a href="#">Korean<span>X</span></a></li>
                                    <li><a href="#">English<span>X</span></a></li>
                                    <li><a href="#">Korean<span>X</span></a></li>
                                    <li><a href="#">Japanese<span>X</span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="twoBtn">
                            <input type="reset" value="Reset" class="resetBtn">
                            <a href="#" class="closeBtn">X</a>
                        </div>
                    </div>
                    <div class="ServicesSearch">
                    	<div class="addLanguage">
                            <div class="addLangL">
                                <label>Escort Services</label>
                                <div class="pleaseSelect">
                                	<div class="oSelect">
                                        <select>
                                            <option>Blowjob</option>
                                        </select>
                                        <span class="fNumber">23</span>
                                    </div>
                                    <button class="addLang">+</button>
                                </div>
                            </div>
                            <div class="addLangR">
                                <ul class="clear">
                                    <li><a href="#">Anal<span>X</span></a></li>
                                    <li><a href="#">69<span>X</span></a></li>
                                    <li><a href="#">Blowjob<span>X</span></a></li>
                                    <li><a href="#">Sensual<span>X</span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="addLanguage">
                            <div class="addLangL">
                                <label>Erotic Services</label>
                                <div class="pleaseSelect">
                                	<div class="oSelect">
                                        <select>
                                            <option>Sensual Massage</option>
                                        </select>
                                        <span class="fNumber">23</span>
                                    </div>
                                    <button class="addLang">+</button>
                                </div>
                            </div>
                            <div class="addLangR">
                                <ul class="clear">
                                    <li><a href="#">Sensual BJ<span>X</span></a></li>
                                    <li><a href="#">The GF Experience<span>X</span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="addLanguage">
                            <div class="addLangL">
                                <label>Fetish</label>
                                <div class="pleaseSelect">
                                	<div class="oSelect">
                                        <select>
                                            <option>Toe Licking</option>
                                        </select>
                                        <span class="fNumber">23</span>
                                    </div>
                                    <button class="addLang">+</button>
                                </div>
                            </div>
                            <div class="addLangR">
                                <ul class="clear">
                                    <li><a href="#">Leather<span>X</span></a></li>
                                    <li><a href="#">Foot Fetish<span>X</span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="addLanguage">
                            <div class="addLangL">
                                <label>Extra Services</label>
                                <div class="pleaseSelect">
                                	<div class="oSelect">
                                        <select>
                                            <option>Ass Then Mouth</option>
                                        </select>
                                        <span class="fNumber">23</span>
                                    </div>
                                    <button class="addLang">+</button>
                                </div>
                            </div>
                            <div class="addLangR">
                                <ul class="clear">
                                    <li><a href="#">Ass then Mouth<span>X</span></a></li>
                                    <li><a href="#">Handcuffs<span>X</span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="twoBtn">
                            <input type="reset" value="Reset" class="resetBtn">
                            <a href="#" class="closeBtn">X</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @pushAssets('post.scripts')
    <script>
    $(document).ready(function () {		
		$('#searchFilter').easyResponsiveTabs({
            type: 'default',
            width: 'auto',
            fit: true,
            tabidentify: 'hor_1', 
            activate: function(event) {
                var $tab = $(this);
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });

        $('#advancedSearch').easyResponsiveTabs({
            type: 'default',
            width: 'auto',
            fit: true,
            tabidentify: 'hor_2',
            activetab_bg: '#fff',
            inactive_bg: '#F5F5F5',
            active_border_color: '#c1c1c1',
            active_content_border_color: '#5AB1D0'
        });
    });
    </script>

    @endPushAssets


<!--<div class="col-xs-10 col-md-5 col-lg-16 stamp masonryme">
    <div class="user_filter">
        <div class="filter-area" style="margin-bottom: 24px">
            <div id="filtermain" class="filter-switch">
                <div class="dropdown" id="filtermain_age">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">AGE</a>
                    <b class="caret"></b>
                    <ul class="dropdown-menu">
                        <li @if(isset($param['age']) && $param['age']=='18-20' ) class="active" @endif>
                            <a href="{{ route('index.filter', ['age' => '18-20']) }}" class="filter-ajax" data-filter-data="age=18-20">18 ~ 20</a>
                        </li>
                        <li @if(isset($param['age']) && $param['age']=='21-24' ) class="active" @endif>
                            <a href="{{ route('index.filter', ['age' => '21-24']) }}" class="filter-ajax" data-filter-data="age=21-24">21 ~ 24</a>
                        </li>
                        <li @if(isset($param['age']) && $param['age']=='25-27' ) class="active" @endif>
                            <a href="{{ route('index.filter', ['age' => '25-27']) }}" class="filter-ajax" data-filter-data="age=25-27">25 ~ 27</a>
                        </li>
                        <li @if(isset($param['age']) && $param['age']=='28-30' ) class="active" @endif>
                            <a href="{{ route('index.filter', ['age' => '28-30']) }}" class="filter-ajax" data-filter-data="age=28-30">28 ~ 30</a>
                        </li>
                    </ul>
                </div>
                <div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">RATE</a>
                    <b class="caret"></b>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                    </ul>
                </div>
                <div class="dropdown" id="filtermain_ethnicity">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">ETHNICITY</a>
                    <b class="caret"></b>
                    <ul class="dropdown-menu" width="auto">
                        @foreach($ethnicityOptions as $ethnicity)
                        <li @if(isset($param['ethnicity']) && $param['ethnicity']==$ethnicity->id ) class="active" @endif><a href="{{ route('index.filter', ['ethnicity' => $ethnicity->id]) }}" class="filter-ajax" data-filter-data="ethnicity={{$ethnicity->id}}">{{ $ethnicity->description->content }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="dropdown" id="filtermain_height">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">HEIGHT</a>
                    <b class="caret"></b>
                    <ul class="dropdown-menu">
                        @foreach($heightOptions as $k => $v)
                        <li @if(isset($param['height']) && $param['height']==$k ) class="active" @endif><a href="{{ route('index.filter', ['height' => $k]) }}" class="filter-ajax" data-filter-data="height={{$k}}">{{ $v }} ({{ $k }} cm)</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">VALIDATION</a>
                    <b class="caret"></b>
                    <ul class="dropdown-menu">
                        <li @if(isset($param['verification']) && $param['verification']==1 ) class="active" @endif><a href="{{ route('index.filter', ['verification' => 1]) }}" class="filter-ajax" data-filter-data="verification=1">Verified Member</a></li>
                        <li @if(isset($param['verification']) && $param['verification']==2 ) class="active" @endif><a href="{{ route('index.filter', ['verification' => 2]) }}" class="filter-ajax" data-filter-data="verification=2">Silver Member</a></li>
                        <li @if(isset($param['verification']) && $param['verification']==3 ) class="active" @endif><a href="{{ route('index.filter', ['verification' => 3]) }}" class="filter-ajax" data-filter-data="verification=3">Gold Member</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" id="reviews_filter">REVIEWS</a>
                    <b class="caret"></b>
                    <ul aria-labelledby="reviews_filter" class="dropdown-menu">
                        <li @if(isset($param['reviews']) && $param['reviews']==5 ) class="active" @endif><a href="{{ route('index.filter', ['reviews' => 5]) }}" class="filter-ajax" data-filter-data="reviews=5">5 *</a></li>
                        <li @if(isset($param['reviews']) && $param['reviews']==4 ) class="active" @endif><a href="{{ route('index.filter', ['reviews' => 4]) }}" class="filter-ajax" data-filter-data="reviews=4">4 *</a></li>
                        <li @if(isset($param['reviews']) && $param['reviews']==3 ) class="active" @endif><a href="{{ route('index.filter', ['reviews' => 3]) }}" class="filter-ajax" data-filter-data="reviews=3">3 *</a></li>
                        <li @if(isset($param['reviews']) && $param['reviews']==2 ) class="active" @endif><a href="{{ route('index.filter', ['reviews' => 2]) }}" class="filter-ajax" data-filter-data="reviews=2">2 *</a></li>
                        <li @if(isset($param['reviews']) && $param['reviews']==1 ) class="active" @endif><a href="{{ route('index.filter', ['reviews' => 1]) }}" class="filter-ajax" data-filter-data="reviews=1">1 *</a></li>
                    </ul>
                </div>
                <div class="dropdown" id="filtermain_video">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">VIDEO</a>
                    <b class="caret"></b>
                    <ul class="dropdown-menu">
                        <li @if(isset($param['with_video']) && $param['with_video']==1 ) class="active" @endif><a href="#" class="filter-ajax" data-filter-data="with_video=1">with Video</a></li>
                        <li @if(isset($param['with_video']) && $param['with_video']==0 ) class="active" @endif><a href="#" class="filter-ajax" data-filter-data="with_video=0">without Video</a></li>
                    </ul>
                </div>
            </div>
            <div class="dropdown plus plusminus" style="display: block">
                <a class="defualt_btn plusicon stamp-button" data-toggle="collapse" href="#advFilter" aria-controls="advFilter" style="border: none; text-decoration: none;">
                    <span>+</span>
                </a>
            </div>
            <div class="dropdown plus minus plusminus" style="display: none">
                <a class="defualt_btn plusicon stamp-button" data-toggle="collapse" href="#advFilter" aria-controls="advFilter" style="border: none; text-decoration: none;">
                    <span>-</span>
                </a>
            </div>
            <div class="dropdown-menu col-xs-20" id="advFilter">

                <div id="parentHorizontalTab">
                    <ul class="resp-tabs-list hor_1">
                        <li class="tab-toggle"><span>BASIC</span></li>
                        <li class="tab-toggle"><span>PHYSICAL</span></li>
                        <li class="tab-toggle"><span>LANGUAGES</span></li>
                        <li class="tab-toggle"><span>ESCORT SERVICES</span></li>
                        <li class="tab-toggle"><span>EROTIC SERVICES</span></li>
                        <li class="tab-toggle"><span>EXTRA SERVICES</span></li>
                        <li class="tab-toggle"><span>FETISH</span></li>
                    </ul>
                    <div class="resp-tabs-container hor_1">
                        @include('Index::common.filters.basic')
                        @include('Index::common.filters.physical')
                        @include('Index::common.filters.languages')
                        @include('Index::common.filters.escort_services')
                        @include('Index::common.filters.erotic_services')
                        @include('Index::common.filters.extra_services')
                        @include('Index::common.filters.fetish')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End Basic Filter --}}

@pushAssets('post.scripts')

<script src="{{ asset('assets/theme/index/default/plugins/waitForImages-master/dist/jquery.waitforimages.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var $filterUrl = '{{route("index.filter")}}';

        var $filterParams = {};
        window.location.search
            .replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) {
                $filterParams[key] = value;
            });

        var $filterContainer = $('#filter-container');
        var $filterNav = $('#filter-nav');
        var $links = $('.filter-ajax');

        function fnResetFilter() {

            // reset search box
            $('#filter-search-text').val('');
            // remove active in gender area
            $('.gender-area a').removeClass('active');
            // remove active in sidebar
            $('#filter-nav a').removeClass('active');

            // Main Location
            // reset country
            $('#filter_country').val('').selectric('refresh');
            // reset state
            $stateHtml = '<option value="">State</option>';
            $('#filter_state').prop('disabled', true);
            $('#filter_state').html($stateHtml).selectric('refresh');
            // reset city
            $cityHtml = '<option value="">City</option>';
            $('#filter_city').prop('disabled', true);
            $('#filter_city').html($cityHtml).selectric('refresh');

            // Basic
            $('#filter_basic').find('select').val('').selectric('refresh');
            // Physical
            $('#filter_physical').find('select').val('').selectric('refresh');
            // Languages
            $('#filter_languages').find(':checkbox').prop('checked', false);
            // Escort Services
            $('#filter_escort_services').find(':checkbox').prop('checked', false);
            // Erotic Services
            $('#filter_erotic_services').find(':checkbox').prop('checked', false);
            // Extra Services
            $('#filter_extra_services').find(':checkbox').prop('checked', false);
            // Fetish Services
            $('#filter_fetish_services').find(':checkbox').prop('checked', false);
        }

        function fnAutoSetValue() {
            // gender
            if (typeof $filterParams['gender'] != 'undefined' &&
                $filterParams['gender'] != '') {

                // basic > gender
                $basicGender = $('#filter_basic').find('#gender');
                if ($basicGender.val() != $filterParams['gender']) {
                    console.log('basic > gender > value : ' + $filterParams['gender']);
                    $basicGender.val($filterParams['gender']).selectric('refresh');
                }

                // gender area
                if ($('.gender-area a.active').data('filter-data') != 'gender=' + $filterParams['gender']) {
                    console.log('gender area > value : ' + $filterParams['gender']);
                    $('.gender-area a').removeClass('active');
                    $('.gender-area a[data-filter-data="gender=' + $filterParams['gender'] + '"]').addClass('active');
                }
            }

            // age
            if (typeof $filterParams['age'] != 'undefined' &&
                $filterParams['age'] != '') {

                // basic > gender
                $basicAge = $('#filter_basic').find('#age');
                if ($basicAge.val() != $filterParams['age']) {
                    console.log('basic > age > value : ' + $filterParams['age']);
                    $basicAge.val($filterParams['age']).selectric('refresh');
                }

                // main filter > age
                if ($('#filtermain_age li.active a').data('filter-data') != 'age=' + $filterParams['age']) {
                    console.log('main filter > age : ' + $filterParams['age']);
                    $('#filtermain_age li').removeClass('active');
                    $('#filtermain_age li a[data-filter-data="age=' + $filterParams['age'] + '"]').closest('li').addClass('active');
                }
            }

            // ethnicity
            if (typeof $filterParams['age'] != 'undefined' &&
                $filterParams['age'] != '') {

                // basic > ethnicity
                $basicEthnicity = $('#filter_basic').find('#ethnicity');
                if ($basicEthnicity.val() != $filterParams['ethnicity']) {
                    console.log('basic > ethnicity > value : ' + $filterParams['ethnicity']);
                    $basicEthnicity.val($filterParams['ethnicity']).selectric('refresh');
                }

                // main filter > ethnicity
                if ($('#filtermain_ethnicity li.active a').data('filter-data') != 'ethnicity=' + $filterParams['ethnicity']) {
                    console.log('main filter > ethnicity : ' + $filterParams['ethnicity']);
                    $('#filtermain_ethnicity li').removeClass('active');
                    $('#filtermain_ethnicity li a[data-filter-data="ethnicity=' + $filterParams['ethnicity'] + '"]').closest('li').addClass('active');
                }
            }

            // video
            if (typeof $filterParams['with_video'] != 'undefined' &&
                $filterParams['with_video'] != '') {

                // basic > with_video
                $basicVideo = $('#filter_basic').find('#with_video');
                if ($basicVideo.val() != $filterParams['with_video']) {
                    console.log('basic > with_video > value : ' + $filterParams['with_video']);
                    $basicVideo.val($filterParams['with_video']).selectric('refresh');
                }

                // main filter > with_video
                if ($('#filtermain_video li.active a').data('filter-data') != 'with_video=' + $filterParams['with_video']) {
                    console.log('main filter > with_video : ' + $filterParams['with_video']);
                    $('#filtermain_video li').removeClass('active');
                    $('#filtermain_video li a[data-filter-data="with_video=' + $filterParams['with_video'] + '"]').closest('li').addClass('active');
                }
            }

            // height
            if (typeof $filterParams['height'] != 'undefined' &&
                $filterParams['height'] != '') {

                // basic > height
                $basicVideo = $('#filter_physical').find('#height');
                if ($basicVideo.val() != $filterParams['height']) {
                    console.log('basic > height > value : ' + $filterParams['height']);
                    $basicVideo.val($filterParams['height']).selectric('refresh');
                }

                // main filter > height
                if ($('#filtermain_height li.active a').data('filter-data') != 'height=' + $filterParams['height']) {
                    console.log('main filter > height : ' + $filterParams['height']);
                    $('#filtermain_height li').removeClass('active');
                    $('#filtermain_height li a[data-filter-data="height=' + $filterParams['height'] + '"]').closest('li').addClass('active');
                }
            }

        }

        var $grid = $('.masonrow');

        // minus 4px to escort photo because container has padding
        $minusWidth = 4;


        function fnFilterEscorts(isAll) {
            isAll = typeof isAll !== 'undefined' && isAll != '' ? isAll : false;
            if (isAll) {
                $filterParams = {}; // reset
            }
            fnAjax({
                url: $filterUrl,
                data: $filterParams,
                success: function(data) {
                    if (isAll) {
                        var $filterFullUrl = $('#all_escort').attr('href');
                        fnResetFilter();
                        // set active
                        $('#all_escort').addClass('active');
                    } else {
                        var $filterFullUrl = $filterUrl + '?' + $.param($filterParams);
                        $filterFullUrl = decodeURIComponent($filterFullUrl);
                        $('#all_escort').removeClass('active');
                        fnAutoSetValue();
                    }
                    window.history.pushState("", "", $filterFullUrl);
                    console.log(data);
                    if (typeof data.status !== 'undefined') {
                        if (data.status == 1) {

                            // $grid.masonry('remove', $('.filter-items'));
                            // layout remaining item elements
                            //$grid.masonry('layout');

                            var $content = $(data.html);
                            var $images = $content.find('img');

                            /*
                            // show loading 
                            fnShowLoader();
                            $images.waitForImages(true).done(function() {
                                console.log('loaded');
                                // remove all items
                                $filterContainer.find('.filter-items').remove();
                                // append new items
                                $grid.append($content).masonry('appended', $content);
                                // relayout masonry
                                $grid.masonry('layout');
                                // hide loading
                                fnHideLoader();
                            });*/

                            // remove all items
                            $filterContainer.find('.filter-items').remove();
                            // append new items

                            $grid.append($content).masonry('appended', $content);

                            // find first item container
                            // to calculate max width of image
                            $firstItemContainer = $grid.find('.filter-items .masonryme:first');

                            if ($firstItemContainer.length) {
                                // image container width - image container padding
                                // to get max width for image
                                var $imgMaxWidth = $firstItemContainer.width() - $minusWidth; // Max width for the image

                                // get all images
                                $imgs = $grid.find('.filter-items .masonryme img.escort-photo');
                                if ($imgs.length) {
                                    // loop each item
                                    // then set image size based on their original size
                                    $imgs.each(function(i, e) {
                                        var $img = $(this);
                                        // set image max width if its not set yet
                                        if ($imgMaxWidth === null) {
                                            $imgMaxWidth = $elm.width() - $minusWidth; // Max width for the image
                                            console.log('imgMaxWidth : ' + $imgMaxWidth);
                                        }
                                        console.log('INDEX : ' + i);
                                        var $imgWidth = $img.data('width'); // original image width
                                        var $imgHeight = $img.data('height'); // original image height

                                        var $ratio = $imgMaxWidth / $imgWidth; // get ratio for scaling image
                                        $img.css("width", $imgMaxWidth); // Set new width
                                        $img.css("height", $imgHeight * $ratio); // Scale height based on ratio

                                    });

                                    // relayout masonry
                                    $grid.masonry('layout');

                                    // wait all escort photos to load
                                    // then remove css width and height of images
                                    // so images will be responsive when browser is resize
                                    $imgs.waitForImages(true).done(function() {
                                        $imgs.removeAttr('style');
                                    });
                                }
                            }

                            /*
                            // find all items
                            $items = $grid.find('.filter-items .masonryme');
                            console.log($items);
                            // image container width - image container padding
                            // to get max width for image
                            var $imgMaxWidth = null;

                            // loop each item
                            // then set image size based on their original size
                            $items.each(function(i, e) {
                                var $elm = $(this);
                                var $img = $elm.find('img.escort-photo');

                                // check if image is exists
                                if ($img.length) {
                                    // set image max width if its not set yet
                                    if ($imgMaxWidth === null) {
                                        $imgMaxWidth = $elm.width() - $minusWidth; // Max width for the image
                                        console.log('imgMaxWidth : ' + $imgMaxWidth);
                                    }
                                    console.log('INDEX : ' + i);
                                    var $imgWidth = $img.data('width'); // original image width
                                    var $imgHeight = $img.data('height'); // original image height

                                    var $ratio = $imgMaxWidth / $imgWidth; // get ratio for scaling image
                                    $img.css("width", $imgMaxWidth); // Set new width
                                    $img.css("height", $imgHeight * $ratio); // Scale height based on ratio
                                }
                            });

                            // relayout masonry
                            $grid.masonry('layout');

                            // wait all escort photos to load
                            // then remove css width and height of images
                            // so images will be responsive when browser is resize
                            $images.waitForImages(true).done(function() {
                                $items.find('img.escort-photo').removeAttr('style');
                            });
                            */

                            // replace state option
                            if (typeof data.states !== 'undefined') {
                                $stateHtml = '<option value="">State</option>';
                                if (data.states.length) {
                                    for (var i in data.states) {
                                        $stateHtml += '<option value="' + data.states[i].state_id + '">' + data.states[i]['state']['name'] + ' (' + data.states[i].total + ')</option>';
                                    }
                                    $('#filter_state').html($stateHtml);
                                    $('#filter_state').prop("disabled", false);
                                    $('#filter_state').selectric('refresh');
                                } else {
                                    $('#filter_state').html($stateHtml);
                                    $('#filter_state').prop("disabled", true);
                                    $('#filter_state').selectric('refresh');
                                }

                                // reset city
                                $cityHtml = '<option value="">City</option>';
                                $('#filter_city').prop('disabled', true);
                                $('#filter_city').html($cityHtml).selectric('refresh');
                            }
                            // replace city option
                            else if (typeof data.cities !== 'undefined') {
                                $cityHtml = '<option value="">City</option>';
                                if (data.cities.length) {
                                    for (var i in data.cities) {
                                        $cityHtml += '<option value="' + data.cities[i].city_id + '">' + data.cities[i]['city']['name'] + ' (' + data.cities[i].total + ')</option>';
                                    }
                                    $('#filter_city').prop('disabled', false);
                                    $('#filter_city').html($cityHtml).selectric('refresh');
                                } else {
                                    $('#filter_city').prop('disabled', true);
                                    $('#filter_city').html($cityHtml).selectric('refresh');
                                }
                            }

                        }
                    }
                }
            });
            return true;
        }
        $links.on('click', function() {
            event.preventDefault();

            //$('#all_escort').removeClass('active');

            $elm = $(this);
            var $data = $elm.attr('data-filter-data');

            var $splitData = $data.split('=');
            //$filterParams[$splitData[0]] = $splitData[1];


            if ($splitData[0] == 'gender') {
                // gender area filter - active/inactive state or toggle effects
                if ($splitData[0] in $filterParams &&
                    $filterParams[$splitData[0]] == $splitData[1]
                ) {
                    $elm.removeClass('active');
                    delete $filterParams[$splitData[0]];
                } else {
                    $filterParams[$splitData[0]] = $splitData[1];
                }
            } else {
                $filterParams[$splitData[0]] = $splitData[1];
            }

            fnFilterEscorts();
        });

        // search box
        var $filterSearchText = $('#filter-search-text');
        var $filterSearchBtn = $('#filter-search-btn');
        $filterSearchBtn.click(function() {
            event.preventDefault();
            $filterParams['search'] = $filterSearchText.val();
            fnFilterEscorts();
        });

        // location
        $('#filter_country').selectric({
            onChange: function() {
                $filterParams['country_id'] = $(this).val();
                $filterParams['state_id'] = ''; // reset
                $filterParams['city_id'] = ''; // reset
                fnFilterEscorts();
            }
        })

        if ($('#filter_state').find('option').length == 1) {
            $('#filter_state').prop('disabled', true);
        }
        $('#filter_state').selectric({
            onChange: function() {
                $filterParams['state_id'] = $(this).val();
                $filterParams['city_id'] = ''; // reset
                fnFilterEscorts();
            }
        })

        if ($('#filter_city').find('option').length == 1) {
            $('#filter_city').prop('disabled', true);
        }
        $('#filter_city').selectric({
            onChange: function() {
                $filterParams['city_id'] = $(this).val();
                fnFilterEscorts();
            }
        })

        // sidebar filter
        $('#all_escort').click(function() {
            event.preventDefault();
            fnFilterEscorts(true);
        });
        $('#filter_pornstar').click(function() {
            event.preventDefault();
            // remove active in sidebar
            $('#filter-nav a').removeClass('active');
            // set active/inactive
            if ('pornstar' in $filterParams) { // to inactive
                delete $filterParams['pornstar'];
            } else { // to active
                $('#filter_pornstar').addClass('active');
                $filterParams['pornstar'] = 'Y';
            }

            if (typeof $filterParams['today'] !== 'undefined' &&
                $filterParams['today'] == 1
            ) {
                // set active
                $('#today_escort').addClass('active');
            }
            if (typeof $filterParams['new'] !== 'undefined' &&
                $filterParams['new'] == 'Y'
            ) {
                // set active
                $('#new_escort').addClass('active');
            }
            fnFilterEscorts();
        });
        $('#today_escort').click(function() {
            event.preventDefault();
            // remove active in sidebar
            $('#filter-nav a').removeClass('active');
            // set active/inactive
            if ('today' in $filterParams) { // to inactive
                delete $filterParams['today'];
            } else { // to active
                $('#today_escort').addClass('active');
                $filterParams['today'] = 1;
            }

            delete $filterParams['new'];
            if (typeof $filterParams['pornstar'] !== 'undefined' &&
                $filterParams['pornstar'] == 'Y'
            ) {
                // set active
                $('#filter_pornstar').addClass('active');
            }
            fnFilterEscorts();
        });
        $('#new_escort').click(function() {
            event.preventDefault();
            // remove active in sidebar
            $('#filter-nav a').removeClass('active');
            // set active/inactive
            if ('new' in $filterParams) { // to inactive
                delete $filterParams['new'];
            } else { // to active
                $('#new_escort').addClass('active');
                $filterParams['new'] = 'Y';
            }

            delete $filterParams['today'];
            if (typeof $filterParams['pornstar'] !== 'undefined' &&
                $filterParams['pornstar'] == 'Y'
            ) {
                // set active
                $('#filter_pornstar').addClass('active');
            }
            fnFilterEscorts();
        });

        // Basic
        $('#filter_basic').on('change', 'select', function() {
            var $elm = $(this);
            var $filterName = $elm.attr('name');
            console.log($filterName);
            console.log($elm.val());
            if (typeof $filterName !== 'undefined' &&
                $filterName != ''
            ) {
                $filterParams[$filterName] = $elm.val();
                fnFilterEscorts();
            }
        });

        // Physical
        $('#filter_physical').on('change', 'select', function() {
            var $elm = $(this);
            var $filterName = $elm.attr('name');
            console.log($filterName);
            console.log($elm.val());
            if (typeof $filterName !== 'undefined' &&
                $filterName != ''
            ) {
                $filterParams[$filterName] = $elm.val();
                fnFilterEscorts();
            }
        });

        // Languages
        //var $languagesItems = $('#filter_languages').find(':checkbox');
        $('#filter_languages').on('change', ':checkbox', function() {
            var $elm = $(this);
            var $filterName = 'lang_ids';
            var $langSelected = [];
            $("#filter_languages :checkbox:checked").each(function() {
                $langSelected.push($(this).val());
            });
            $filterParams[$filterName] = $langSelected.join(',');
            fnFilterEscorts();
        });

        // Escort Services
        $('#filter_escort_services').on('change', ':checkbox', function() {
            var $elm = $(this);
            var $filterName = 'escort_service_ids';
            var $optSelected = [];
            $("#filter_escort_services :checkbox:checked").each(function() {
                $optSelected.push($(this).val());
            });
            $filterParams[$filterName] = $optSelected.join(',');
            fnFilterEscorts();
        });

        // Erotic Services
        $('#filter_erotic_services').on('change', ':checkbox', function() {
            var $elm = $(this);
            var $filterName = 'erotic_service_ids';
            var $optSelected = [];
            $("#filter_erotic_services :checkbox:checked").each(function() {
                $optSelected.push($(this).val());
            });
            $filterParams[$filterName] = $optSelected.join(',');
            fnFilterEscorts();
        });

        // Extra Services
        $('#filter_extra_services').on('change', ':checkbox', function() {
            var $elm = $(this);
            var $filterName = 'extra_service_ids';
            var $optSelected = [];
            $("#filter_extra_services :checkbox:checked").each(function() {
                $optSelected.push($(this).val());
            });
            $filterParams[$filterName] = $optSelected.join(',');
            fnFilterEscorts();
        });

        // Fetish Services
        $('#filter_fetish_services').on('change', ':checkbox', function() {
            var $elm = $(this);
            var $filterName = 'fetish_service_ids';
            var $optSelected = [];
            $("#filter_fetish_services :checkbox:checked").each(function() {
                $optSelected.push($(this).val());
            });
            $filterParams[$filterName] = $optSelected.join(',');
            fnFilterEscorts();
        });

        // main filter - set active design
        $('#filtermain .dropdown ul').on('click', 'li', function() {
            var $elm = $(this);
            console.log($elm);
            $elm.closest('ul').find('li').removeClass('active');
            $elm.addClass('active');
        });

    });
</script>
@endPushAssets-->