{{-- Basic Filter --}}
<h2 class="resp-accordion hor_1" role="tab"></h2>
<div class="item-content row" id="filter_basic">
    <div class="col-lg-10">
        <form class="default_form">

            {{-- Gender Filter --}}
            <div style="margin-bottom: 6px; height: 34px;">
                <span class="advFilter-label">@lang('Gender')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="gender" name="gender">
                        <option value="">Select Option</option>
                        @forelse ($genderOptions as $value => $label)
                        <option value="{{ $value }}" @if(isset($param['gender']) && $param['gender']==$value ) selected @endif>{{ $label }}</option>
                        @empty
                        <option selected="">@lang('No data')</option>
                        @endforelse
                    </select>
                </div>
            </div>
            {{-- End Gender Filter --}}

            {{-- Orientation Filter --}}
            <div style="margin-bottom: 6px; height: 34px;">
                <span class="advFilter-label">@lang('Orientation')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="orientation" name="orientation">
                        <!-- Set this dynamically -->
                        <option value="">Select Option</option>
                        <option value="S" @if(isset($param['orientation']) && $param['orientation']=='S' ) selected @endif>Straight</option>
                        <option value="B" @if(isset($param['orientation']) && $param['orientation']=='B' ) selected @endif>Bisexual</option>
                    </select>
                </div>
            </div>
            {{-- End Orientation Filter --}}

            {{-- Origin Filter --}}
            <div style="margin-bottom: 6px; height: 34px;">
                <span class="advFilter-label">@lang('Origin')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="country2" name="origin">
                        <!-- Set this dynamically -->
                        <option value="">Select Option</option>

                        <!-- Format value="{country_id}" {country_name} ({count}) -->
                        @foreach($originOptions as $origin)
                        <option value="{{ $origin->id }}" @if(isset($param['origin']) && $param['origin']==$origin->id ) selected @endif>{{ $origin->name }} ({{ $origin->total }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- End Origin Filter --}}

            {{-- Ethnicity Filter --}}
            <div style="margin-bottom: 6px; height: 34px;">
                <span class="advFilter-label">@lang('Ethnicity')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="ethnicity" name="ethnicity">
                        <!-- Set this dynamically -->
                        <option value="">Select Option</option>
                        @foreach($ethnicityOptions as $ethnicity)
                        <option value="{{ $ethnicity->id }}" @if(isset($param['ethnicity']) && $param['ethnicity']==$ethnicity->id ) selected @endif>{{ $ethnicity->description->content ?? '--' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- End Ethnicity Filter --}}

            {{-- Age Filter --}}
            <div style="margin-bottom: 6px; height: 34px;">
                <span class="advFilter-label">@lang('Age')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="age" name="age">
                        <!-- Set this dynamically -->
                        <option value="">Select Option</option>

                        <!-- Format value="{min}" {min}-{max} ({count}) -->
                        <option value="18-20" @if(isset($param['age']) && $param['age']=='18-20' ) selected @endif>18-20</option>
                        <option value="21-24" @if(isset($param['age']) && $param['age']=='21-24' ) selected @endif>21-24</option>
                        <option value="25-27" @if(isset($param['age']) && $param['age']=='25-27' ) selected @endif>25-27</option>
                        <option value="28-30" @if(isset($param['age']) && $param['age']=='28-30' ) selected @endif>28-30</option>
                    </select>
                </div>
            </div>
            {{-- End Age Filter --}}

            {{-- Education Filter --}}
            <div style="margin-bottom: 6px; height: 34px;">
                <span class="advFilter-label">@lang('Education')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="education" name="education">
                        <!-- Set this dynamically -->
                        <option value="">Select Option</option>

                        <!-- Format value="{attrib}" {attrib} ({count}) -->
                        <option value="Graduate">Graduate (1)</option>
                        <option value="Post-Graduate">Post-Grad (4)</option>
                    </select>
                </div>
            </div>
            {{-- End Education Filter --}}
        </form>
    </div>

    <div class="col-lg-10">
        <form class="default_form">
            {{-- Price Filter --}}
            <div style="margin-bottom: 6px; height: 34px;">
                <span class="advFilter-label">@lang('Price')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="price" name="price">
                        <!-- Set this dynamically -->
                        <option value="">Select Option</option>

                        <!-- Format value="{price-range}" {price-range} ({count}) -->
                        <option value="0-100">0-100 (1)</option>
                        <option value="101-200">101-200 (4)</option>
                    </select>
                </div>
            </div>
            {{-- End Price Filter --}}

            {{-- Availability Filter --}}
            <div style="margin-bottom: 6px; height: 34px;">
                <span class="advFilter-label">@lang('Availability')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="availability" name="service_type">
                        <!-- Set this dynamically -->
                        <option value="">Select Option</option>

                        <!-- Format value="{attrib}" {attrib} ({count}) -->
                        <option value="I" @if(isset($param['service_type']) && $param['service_type']=='I' ) selected @endif>Incall ({{ $total_availability['I'] ?? 0 }})</option>
                        <option value="O" @if(isset($param['service_type']) && $param['service_type']=='O' ) selected @endif>Outcall ({{ $total_availability['I'] ?? 0 }})</option>
                    </select>
                </div>
            </div>
            {{-- End Availability Filter --}}

            {{-- Smoker Filter --}}
            <div style="margin-bottom: 6px; height: 34px;">
                <span class="advFilter-label">@lang('Smoker')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="smoker" name="smoker">
                        <!-- Set this dynamically -->
                        <option value="">Select Option</option>

                        <!-- Format value="{attrib}" {attrib} ({count}) -->
                        <option value="Yes">Yes (163)</option>
                        <option value="No">No (45)</option>
                    </select>
                </div>
            </div>
            {{-- End Smoker Filter --}}

            {{-- Has Reviews Filter --}}
            <div style="margin-bottom: 6px; height: 34px;">
                <span class="advFilter-label">@lang('Has Reviews')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="has_reviews" name="with_review">
                        <!-- Set this dynamically -->
                        <option value="">Select Option</option>

                        <!-- Format value="{attrib}" {attrib} ({count}) -->
                        <option value="1" @if(isset($param['with_review']) && $param['with_review']==1 ) selected @endif>Yes ({{ $total_with_review ?? 0 }})</option>
                        <option value="0" @if(isset($param['with_review']) && $param['with_review']==0 ) selected @endif>No ({{ $total_without_review ?? 0 }})</option>
                    </select>
                </div>
            </div>
            {{-- End Has Reviews Filter --}}

            {{-- Has Videos Filter --}}
            <div style="margin-bottom: 6px; height: 34px;">
                <span class="advFilter-label">@lang('Has Videos')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="with_video" name="with_video">
                        <!-- Set this dynamically -->
                        <option value="">Select Option</option>

                        <!-- Format value="{attrib}" {attrib} ({count}) -->
                        <option value="1" @if(isset($param['with_video']) && $param['with_video']==1 ) selected @endif>Yes ({{ $total_with_video ?? 0 }})</option>
                        <option value="0" @if(isset($param['with_video']) && $param['with_video']==0 ) selected @endif>No ({{ $total_without_video ?? 0 }})</option>
                    </select>
                </div>
            </div>
            {{-- End Has Videos Filter --}}
        </form>
    </div>
    <div class="clearfix"></div>
</div>
{{-- End Basic Filter --}}