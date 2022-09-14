<!-- Biography -->
<div class="col-xs-20 panel-biography">
    
        <div class="panel panel-primary"> 
            <div class="panel-heading widget_header widget_accordian_title"> 
                <a class="btn-minimize"><i class="fa fa-window-minimize"></i></a>
                <h3 class="panel-title">Biography</h3> 
            </div>
            <div class="panel-body widget_accordian_content">
                <div class="row">
                    <ul class="col-xs-20 col-sm-5">
                        <li><span>Home City:</span> <span>{{ $user->homeCity  ?? '' }}</span></li>
                        <li><span>Destinations:</span> <span>{{ $destinations ?? '' }}</span></li>
                    </ul>
                    <ul class="col-xs-20 col-sm-5">
                        <li><span>Drinker:</span> <span>Yes</span></li>
                        <li><span>Ethnic:</span> <span>{{ $user->ethnic ?? '--' }}</span></li>
                        <li><span>Length:</span> <span>{{ $user->hairLength ?? '--' }}</span></li>
                        <li><span>Orientation:</span> <span>{{ $user->orientation ?? '--' }}</span></li>
                    </ul>
                    <ul class="col-xs-20 col-sm-5">
                        <li><span>Education:</span> <span>College</span></li>
                        <li><span>Eyes:</span> <span>{{ $user->eyeColor ?? '--' }}</span></li>
                        <li><span>Hair:</span> <span>{{ $user->hairColor ?? '--' }}</span></li>
                        <li><span>Look:</span> <span>Athletic</span></li>
                        <li><span>Smoker:</span> <span>Yes</span></li>
                    </ul>
                    <ul class="col-xs-20 col-sm-5">
                        @forelse ($user->escortLanguages as $lang)
                            <li>
                                <span>{{ $lang->attribute->description->content ?? '' }}:</span> <span>{{ $languageProficiencyOptions[$lang->proficiency] ?? $lang->proficiency }}</span>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
                <div class="row">
                        <a href="#" class="urlbutton-web"><span class="websiteurl-button"><i class="fa fa-globe" style="margin-right: 6px"></i>www.thisisaverylongwebsiteoflumia.com</span></a>
                </div>
            </div>
        </div> 
</div>
