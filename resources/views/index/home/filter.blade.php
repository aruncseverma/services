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
                                	<label class="escortG1"><input id="escortG1" type="radio" name="escortG"><img src="{{ asset('assets/theme/index/default/images/index/female.png') }}" alt=""><span>2</span></label>
                                    <label class="escortG2"><input id="escortG2" type="radio" name="escortG"><img src="{{ asset('assets/theme/index/default/images/index/male.png') }}" alt=""><span>25483</span></label>
                                    <label class="escortG3"><input id="escortG3" type="radio" name="escortG"><img src="{{ asset('assets/theme/index/default/images/index/intersex.png') }}" alt=""><span>9142</span></label>
                                    <label class="escortG4"><input id="escortG4" type="radio" name="escortG"><img src="{{ asset('assets/theme/index/default/images/index/hetero.png') }}" alt=""><span>150</span></label>
                                </div>
                            </div>
                            <div class="basicBox">
                            	<label>Client Gender</label>
                                <div class="gender clientG">
                                	<label class="clientG1"><input id="clientG1" type="radio" name="clientG"><img src="{{ asset('assets/theme/index/default/images/index/female.png') }}" alt=""><span>16</span></label>
                                    <label class="clientG2"><input id="clientG2" type="radio" name="clientG"><img src="{{ asset('assets/theme/index/default/images/index/male.png') }}" alt=""><span>8</span></label>
                                    <label class="clientG3"><input id="clientG3" type="radio" name="clientG"><img src="{{ asset('assets/theme/index/default/images/index/intersex.png') }}" alt=""><span>45</span></label>
                                    <label class="clientG4"><input id="clientG4" type="radio" name="clientG"><img src="{{ asset('assets/theme/index/default/images/index/hetero.png') }}" alt=""><span>3</span></label>
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