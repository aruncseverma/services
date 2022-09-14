<div class="yourAddress">
    <div class="escortArea"><i class="fas fa-map-marker-alt"></i>Escorts in <span>Amsterdam, NL</span></div>
    <button class="changeLo">Change</button>
    <div class="changeLocation">
        <form class="default_form">
            <div class="changeLoca">
                <div class="changeBox">
                    <label>Continent</label>
                    <select>
                        <option>Please select</option>
                    </select>
                </div>
                <div class="changeBox">
                    <label>Country</label>
                    <select id="filter_country">
                        <option value="">Please select</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->country_id }}" @if(isset($param['country_id']) && $param['country_id']==$country->country_id) selected @endif >{{ $country->country->name }} ({{ $country->total }})</option>
                        @endforeach
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
                <input type="reset" value="Reset" class="resetBtn">
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

        var $filterContainer = $('.grid');
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

                            // remove all items
                            $filterContainer.find('.grid-item').remove();
                            //$filterContainer.remove();
                            // append new items

                            $filterContainer.append($content).masonry('appended', $content);

                            // find first item container
                            // to calculate max width of image
                            $firstItemContainer = $filterContainer.find('.grid .grid-item:first');
                            $('.grid').masonry('layout');

                            if ($firstItemContainer.length) {
                                // image container width - image container padding
                                // to get max width for image
                                var $imgMaxWidth = $firstItemContainer.width() - $minusWidth; // Max width for the image
                                //$('.grid').masonry('layout');
                                //$('.grid').masonry('layout');
                                // get all images
                                $imgs = $filterContainer.find('.grid-item img.escort-photo');
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
                                    //$('.grid').masonry('layout');

                                    // wait all escort photos to load
                                    // then remove css width and height of images
                                    // so images will be responsive when browser is resize
                                    $imgs.waitForImages(true).done(function() {
                                        $imgs.removeAttr('style');
                                    });
                                }
                            }                            

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
@endPushAssets