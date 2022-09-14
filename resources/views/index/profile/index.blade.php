@extends('Index::layout')

@pushAssets('header.additional')
@endPushAssets

@section('main.content.title')
    {{ $title }}
@endsection

@section('main.content')

<div class="centerwrap clear">
    	<div class="profileTRight">
        	<div class="topArrows">
                <a href="#"><i class="fas fa-angle-left"></i> Previous Escort</a>
                <a href="#">Next Escort <i class="fas fa-angle-right"></i></a>
            </div>
            <div class="searchSpace"><div class="searchID desktopSearch"><i class="fas fa-search"></i></div></div>
        </div>
    	
        <div class="profileArea clear">
        	<div class="profileLeft">
            	<div class="profilePic">
                	<div class="topNVip">
                    	<div class="new">NEW</div>
                        <div class="vip">VIP</div>
                        <a href="javaScript:void(0)" class="likeModel"><i class="far fa-heart"></i></a>
                    </div>
                    <a href="#">@if ($photos['public'])
                    <img src="{{ route('common.photo', ['photo' => $photos['public'], 'path'=> $photos['public']->path]) }}" style="width:100%">
                @else
                    <img src="{{ asset('assets/theme/index/default/images/index/user_image.png') }}" alt="user_image" title="user_image">
                @endif</a>
                    <div class="contactAgencyB">
                        <div class="cAgency">
                        	<a href="#" class="leftA"><i class="fas fa-angle-left"></i></a>
                            <span class="contactAgency">BOOK THIS ESCORT NOW</span>
                            <a href="#" class="rightA"><i class="fas fa-angle-right"></i></a>
                        </div>
                        <div class="caInfo">
                            <div class="closeContact">X</div>
                            <div class="caILeft">
	                            <div class="pPic">
                                    @if ($photos['public'])
                                    <img src="{{ route('common.photo', ['photo' => $photos['public'], 'path'=> $photos['public']->path]) }}">
                                    @else
                                        <img src="{{ asset('assets/theme/index/default/images/index/user_image.png') }}" alt="user_image" title="user_image">
                                    @endif</div>
                                <div class="modelPName"><a href="#">{{ $user->name ?? '' }}</a></div>
                    			<div class="modelPAge">Age: <span>23</span></div>
                            </div>
                            <div class="agencyContact">
                                <h4>CONTACT US</h4>
                                <ul>
                                    <li><label class="option1 mobile"><input type="radio" name="contact" id="option1"><i class="fas fa-mobile-alt"></i><span>+44 777 888 9999</span></label></li>
                                    <li><label class="option2 whatsapp active"><input type="radio" name="contact" id="option2"><i class="fab fa-whatsapp"></i><span>+44 757 616 6876</span></label></li>
                                    <li><label class="option3 telegram"><input type="radio" name="contact" id="option3"><i class="fab fa-telegram"></i><span>+44 111 222 3333</span></label></li>
                                    <li><label class="option4 viber"><input type="radio" name="contact" id="option4"><i class="fab fa-viber"></i><span>+44 444 555 6666</span></label></li>
                                    <li><label class="option5 envelope"><input type="radio" name="contact" id="option5"><i class="fas fa-envelope"></i><span>abcd@gmail.com</span></label></li>
                                </ul>
                            </div>
                            <div class="followUs">
                                <h4>FOLLOW US</h4>
                                <ul>
                                    <li><label class="follow1 siteUrl active"><input type="radio" name="follow" id="follow1"><i class="fas fa-globe"></i><span>www.agencywebsite.com</span></label></li>
                                    <li><label class="follow2 instagram"><input type="radio" name="follow" id="follow2"><i class="fab fa-instagram"></i><span>https://instagram.com</span></label></li>
                                    <li><label class="follow3 twitter"><input type="radio" name="follow" id="follow3"><i class="fab fa-twitter"></i><span>https://twitter.com</span></label></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profileData">
                	<div class="modelPName"><a href="#">{{ $user->name ?? '' }}</a></div>
                    <div class="modelPAge">Age: <span>23</span></div>
                    <div class="modelPCheck goldCheck"><i class="far fa-check-square"></i></div>
                    <div class="pData">
                    	<p data-expandlink="Read More" data-collapselink="Less" class="vText">{{ $user->description->content ?? '' }}</p>
                    </div>
                </div>
                <div class="profilePV">
                	<div id="profilePV">
                        <ul class="resp-tabs-list mypv">
                            <li>My Photos</li>
                            <li>My Videos</li>
                        </ul>
                        <div class="resp-tabs-container mypv">
                            <div class="myPhotoArea">
                            	<div class="pvPopup"><a href="{{ asset('assets/theme/index/default/images/index/modelPPicBig.png') }}" data-fancybox="gallery"><img src="{{ asset('assets/theme/index/default/images/index/modelPPic.jpg') }}" alt=""/></a></div>
                                <div class="pvPopup"><a href="{{ asset('assets/theme/index/default/images/index/modelPPicBig.png') }}" data-fancybox="gallery"><img src="{{ asset('assets/theme/index/default/images/index/modelPPic2.jpg') }}" alt=""/></a></div>
                                <div class="pvPopup"><a href="{{ asset('assets/theme/index/default/images/index/modelPPicBig.png') }}" data-fancybox="gallery"><img src="{{ asset('assets/theme/index/default/images/index/modelPPic3.jpg') }}" alt=""/></a></div>
                          	</div>
                            <div class="myVideoArea">
                            	<div class="pvPopup"><a href="images/sample.mp4" data-fancybox="myvideo"><img src="{{ asset('assets/theme/index/default/images/index/modelPPic2.jpg') }}" alt=""/></a></div>
                                <div class="pvPopup"><a href="images/sample.mp4" data-fancybox="myvideo"><img src="{{ asset('assets/theme/index/default/images/index/modelPPic3.jpg') }}" alt=""/></a></div>
                                <div class="pvPopup"><a href="images/sample.mp4" data-fancybox="myvideo"><img src="{{ asset('assets/theme/index/default/images/index/modelPPic.jpg') }}" alt=""/></a></div>
                          	</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profileRight">
            	<div class="profileFWidth clear">
                	<div class="pPrices">
                    	<div class="pTitle">PRICES<i class="fas fa-chevron-up"></i></div>
                        <div class="pDetails">
                        	<div class="inOutCall" id="inOutCall">
                                <ul class="resp-tabs-list ioCall">
                                    <li>Incall</li>
                                    <li>Outcall</li>
                                </ul>
                                <div class="resp-tabs-container ioCall">
                                	<div class="inCall">
                                    	<ul class="callRate">
                                        @forelse ($durations as $duration)
                                            <li>{{ $duration->description->content ?? '' }}<span>{{ $duration->escortRate->incall ?? '--' }}</span></li>                                            
                                        @empty
                                            <li><span>@lang('No data')</span></li>
                                        @endforelse
                                        </ul>
                                    </div>
                                    <div class="OutCall">
                                    	<ul class="callRate">
                                        @forelse ($durations as $duration)
                                            <li>{{ $duration->description->content ?? '' }}<span>{{ $duration->escortRate->outcall ?? '--' }}</span></li>                                            
                                        @empty
                                            <li><span>@lang('No data')</span></li>
                                        @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="allServicesArea forMobile">
                    	<div class="pTitle">SERVICES<i class="fas fa-chevron-up"></i></div>
                        <div class="pDetails">
                        	<div class="allServices" id="allServicesM">
                                <ul class="resp-tabs-list efServicesM">
                                    <li>Escort<span> Services</span></li>
                                    <li>Erotic<span> Services</span></li>
                                    <li>Fetish</li>
                                    <li>Extra<span> Services</span></li>
                                </ul>
                                <div class="resp-tabs-container efServicesM">
                                	<div class="escortS">
                                    	<ul class="escortSList">
                                        @forelse ($services['standard'] as $service)
                                            <li>{{ $service ?? '' }}</li>
                                        @empty
                                            <li>@lang('No data')</li>
                                        @endforelse
                                        </ul>
                                    </div>
                                    <div class="eroticS">
                                    	<ul class="escortSList">
                                            @forelse ($services['erotic'] as $service)
                                                <li>{{ $service ?? '' }}</li>
                                            @empty
                                                <li>@lang('No data')</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="fetish">
                                    	<ul class="escortSList">
                                            @forelse ($services['fetish'] as $service)
                                                <li>{{ $service ?? '' }}</li>
                                            @empty
                                                <li>@lang('No data')</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="extraS">
                                    	<ul class="escortSList">
                                        @forelse ($services['extra'] as $service)
                                            <li>{{ $service ?? '' }}</li>
                                        @empty
                                            <li>@lang('No data')</li>
                                        @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="availability">
                    	<div class="pTitle">AVAILABILITY<i class="fas fa-chevron-up"></i></div>
                        <div class="pDetails">
                        	<div class="avaTitle">
                            	<div class="avaDays"></div>
                                <div class="avaFrom">From</div>
                                <div class="avaTill">Till</div>
                            </div>
                            <div class="days">
                            	<div class="avaDays">Monday</div>
                                <div class="avaFrom">{{ $schedules['M']->from ?? '00:00' }}</div>
                                <div class="avaTill">{{ $schedules['M']->till ?? '00:00' }}</div>
                            </div>
                            <div class="days">
                            	<div class="avaDays">Tuesday</div>
                                <div class="avaFrom">{{ $schedules['T']->from ?? '00:00' }}</div>
                                <div class="avaTill">{{ $schedules['T']->till ?? '00:00' }}</div>
                            </div>
                            <div class="days">
                            	<div class="avaDays">Wednesday</div>
                                <div class="avaFrom">{{ $schedules['W']->from ?? '00:00' }}</div>
                                <div class="avaTill">{{ $schedules['W']->till ?? '00:00' }}</div>
                            </div>
                            <div class="days">
                            	<div class="avaDays">Thursday</div>
                                <div class="avaFrom">{{ $schedules['TH']->from ?? '00:00' }}</div>
                                <div class="avaTill">{{ $schedules['TH']->till ?? '00:00' }}</div>
                            </div>
                            <div class="days">
                            	<div class="avaDays">Friday</div>
                                <div class="avaFrom">{{ $schedules['F']->from ?? '00:00' }}</div>
                                <div class="avaTill">{{ $schedules['F']->till ?? '00:00' }}</div>
                            </div>
                            <div class="days">
                            	<div class="avaDays">Saturday</div>
                                <div class="avaFrom">{{ $schedules['ST']->from ?? '00:00' }}</div>
                                <div class="avaTill">{{ $schedules['ST']->till ?? '00:00' }}</div>
                            </div>
                            <div class="days">
                            	<div class="avaDays">Sunday</div>
                                <div class="avaFrom">{{ $schedules['SN']->from ?? '00:00' }}</div>
                                <div class="avaTill">{{ $schedules['SN']->till ?? '00:00' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="allServicesArea forDesktop">
                    	<div class="pTitle">SERVICES<i class="fas fa-chevron-up"></i></div>
                        <div class="pDetails">
                        	<div class="allServices" id="allServices">
                                <ul class="resp-tabs-list efServices">
                                    <li>Escort Services</li>
                                    <li>Erotic Services</li>
                                    <li>Fetish</li>
                                    <li>Extra Services</li>
                                </ul>
                                <div class="resp-tabs-container efServices">
                                	<div class="escortS">
                                    	<ul class="escortSList">
                                            @forelse ($services['standard'] as $service)
                                                <li>{{ $service ?? '' }}</li>
                                            @empty
                                                <li>@lang('No data')</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="eroticS">
                                    	<ul class="escortSList">
                                            @forelse ($services['erotic'] as $service)
                                                <li>{{ $service ?? '' }}</li>
                                            @empty
                                                <li>@lang('No data')</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="fetish">
                                    	<ul class="escortSList">
                                            @forelse ($services['fetish'] as $service)
                                                <li>{{ $service ?? '' }}</li>
                                            @empty
                                                <li>@lang('No data')</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="extraS">
                                    	<ul class="escortSList">
                                        @forelse ($services['extra'] as $service)
                                            <li>{{ $service ?? '' }}</li>
                                        @empty
                                            <li>@lang('No data')</li>
                                        @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profileFWidth">
                    <div class="perInfo forDesktop">
	                    <div class="pTitle">PERSONAL INFO<i class="fas fa-chevron-up"></i></div>
                    	<div class="pDetails pInfo">
                            <div class="personalInfo">
                                <h4>Biography</h4>
                                <ul>
                                    <li>Home City<span>{{ $user->homeCity  ?? '' }}</span></li>
                                    <li>Drinker<span>Yes</span></li>
                                    <li>Length<span>{{ $user->hairLength ?? '--' }}</span></li>
                                    <li>Orientation<span>{{ $user->orientation ?? '--' }}</span></li>
                                    <li>Eyes<span>{{ $user->eyeColor ?? '--' }}</span></li>
                                    <li>Hair<span>{{ $user->hairColor ?? '--' }}</span></li>
                                </ul>
                            </div>
                            <div class="personalInfo">
                                <h4>Statistics</h4>
                                <ul>
                                    <li>Bust Size<span>{{$user->bust}}</span></li>
                                    <li>Bust Type<span>1.75m</span></li>
                                    <li>Weight<span>{{$user->weight}}</span></li>
                                    <li>Height<span>{{$user->height}}</span></li>
                                    <li>Build<span>Curvy</span></li>
                                    <li>Hair Length<span>{{ $user->hairLength }}</span></li>
                                </ul>
                            </div>
                            <div class="personalInfo">
                                <h4>Tours</h4>
                                <ul>
                                    @forelse ($user->tourPlans as $tourPlan)
                                        <li>{{ $tourPlan->date_start ?? '' }}</li>                 
                                        <li>{{ $tourPlan->date_end ?? '' }}</li>
                                        <li>{{ $tourPlan->country->name ?? '' }}</li>
                                        <li>{{ $tourPlan->state->name ?? '' }}</li>
                                        <li>{{ $tourPlan->city->name ?? '' }}</li>
                                        <li>{{ $tourPlan->telephone ?? '' }}</li>
                                    @empty
                                        <li>@lang('No data')</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="perInfo forMobile">
                    	<div class="pTitle">PERSONAL INFO<i class="fas fa-chevron-up"></i></div>
                    	<div class="pDetails pInfo">
                        	<div id="pInfo">
                                <ul class="resp-tabs-list personalI">
                                    <li>Biography</li>
                                    <li>Statistics</li>
                                    <li>Tours</li>
                                </ul>
                                <div class="resp-tabs-container personalI">
                                	<div class="bstInfo">
                                        <ul>
                                            <li>Home City<span>{{ $user->homeCity  ?? '' }}</span></li>
                                            <li>Drinker<span>Yes</span></li>
                                            <li>Length<span>{{ $user->hairLength ?? '--' }}</span></li>
                                            <li>Orientation<span>{{ $user->orientation ?? '--' }}</span></li>
                                            <li>Eyes<span>{{ $user->eyeColor ?? '--' }}</span></li>
                                            <li>Hair<span>{{ $user->hairColor ?? '--' }}</span></li>
                                        </ul>
                                    </div>
                                    <div class="bstInfo">
                                        <ul>
                                        <li>Bust Size<span>{{$user->bust}}</span></li>
                                        <li>Bust Type<span>1.75m</span></li>
                                        <li>Weight<span>{{$user->weight}}</span></li>
                                        <li>Height<span>{{$user->height}}</span></li>
                                        <li>Build<span>Curvy</span></li>
                                        <li>Hair Length<span>{{ $user->hairLength }}</span></li>
                                        </ul>
                                    </div>
                                    <div class="bstInfo">
                                    	<ul>
                                            @forelse ($user->tourPlans as $tourPlan)
                                                <li>{{ $tourPlan->date_start ?? '' }}</li>                 
                                                <li>{{ $tourPlan->date_end ?? '' }}</li>
                                                <li>{{ $tourPlan->country->name ?? '' }}</li>
                                                <li>{{ $tourPlan->state->name ?? '' }}</li>
                                                <li>{{ $tourPlan->city->name ?? '' }}</li>
                                                <li>{{ $tourPlan->telephone ?? '' }}</li>
                                            @empty
                                                <li>@lang('No data')</li>
                                            @endforelse
                                        </ul>
                                	</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profileFWidth">
                    <div class="reviews">
	                    <div class="pTitle">REVIEWS
                        	<button class="addReview">Add review</button>
                            <div class="reviewPopup">
                            	<!--<div class="alreadyMember">
                                    <div class="reviewRight">ALREADY A MEMBER?</div>
                                    <div class="reviewBox">
                                        <label>Email</label>
                                        <input type="email" class="reviewPBox">
                                    </div>
                                    <div class="reviewBox">
                                        <label>Password</label>
                                        <input type="password" class="reviewPBox">
                                    </div>
                                    <div class="reviewFinal">
                                        <div class="reviewCaptcha"><img src="images/recaptcha.png" alt=""/></div>
                                        <div class="reviewTBtn">
                                            <button class="reviewSubmit">Submit</button>
                                            <button class="reviewClose">X</button>
                                        </div>
                                    </div>
                                    <div class="notMem">Not a member yet?<a href="#">SIGNUP NOW</a></div>
                                </div>-->
                                <div class="addReviewB">
                                	<div class="reviewRight">ADD REVIEW</div>
                                    <div class="reviewBox">
                                        <label>Add Rating</label>
                                        <div class="dropdown">
                                            <div class="dropdownBox">
                                            	Please select
                                            </div>
                                            <ul>
                                                <li class="clear">
                                                	<img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starHalf.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starHalf.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starHalf.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starHalf.png') }}" alt="">
                                                </li>
                                                <li class="clear">
                                                	<img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starHalf.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starHalf.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starHalf.png') }}" alt="">
                                                </li>
                                                <li class="clear">
                                                	<img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starHalf.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starHalf.png') }}" alt="">
                                                </li>
                                                <li class="clear">
                                                	<img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starHalf.png') }}" alt="">
                                                </li>
                                                <li class="clear">
                                                	<img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                    <img src="{{ asset('assets/theme/index/default/images/index/starFull.png') }}" alt="">
                                                </li>
                                           	</ul>
                                        </div>
                                    </div>
                                    <div class="reviewBox">
                                        <label>Your Message</label>
                                        <textarea></textarea>
                                    </div>
                                    <div class="reviewFinal">
                                        <div class="reviewCaptcha"><img src="{{ asset('assets/theme/index/default/images/index/recaptcha.png') }}" alt=""/></div>
                                        <div class="reviewTBtn">
                                            <button class="reviewSubmit">Submit</button>
                                            <button class="reviewClose">X</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <i class="fas fa-chevron-up"></i>
                        </div>
                    	<div class="pDetails">
                        	<div class="reviewBlock">
                            	<div class="reviewTitle">
                                	<h4>John Doe</h4>
                                    <div class="reviewDate">06/05/2020</div>
                                    <div class="reviewRating">
                                    	<a href="#"><i class="fas fa-star"></i></a>
                                        <a href="#"><i class="fas fa-star"></i></a>
                                        <a href="#"><i class="fas fa-star"></i></a>
                                        <a href="#"><i class="far fa-star"></i></a>
                                        <a href="#"><i class="far fa-star"></i></a>
                                    </div>
                                </div>
                                <div class="reviewText">You are so hot! I would love to go out with you again! I really enjoyed our time and you really rock my world! Til our next meet!</div>
                                <div class="reviewReply">Hi John, thanks for dropping by and thank you<br>
for the 3 stars! xoxo</div>
                            </div>
                            <div class="reviewBlock">
                            	<div class="reviewTitle">
                                	<h4>Jaden</h4>
                                    <div class="reviewDate">06/05/2020</div>
                                    <div class="reviewRating">
                                    	<a href="#"><i class="fas fa-star"></i></a>
                                        <a href="#"><i class="fas fa-star"></i></a>
                                        <a href="#"><i class="fas fa-star"></i></a>
                                        <a href="#"><i class="far fa-star"></i></a>
                                        <a href="#"><i class="far fa-star"></i></a>
                                    </div>
                                </div>
                                <div class="reviewText">I really love those photos of you, in fact I saved them all! Wish i could meet you soon.</div>
                            </div>
                            <div class="pagination">
                                <a href="#"><i class="fas fa-angle-left"></i></a>
                                <a href="#" class="active">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#">4</a>
                                <a href="#"><i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="report"><a href="#">Something wrong? Report this person</a></div>
        </div>
    </div>
@endsection