{{-- Physical Filter --}}
<h2 class="resp-accordion hor_1" role="tab"></h2>
<div class="item-content row" id="filter_physical">
    <div class="col-lg-10">
        <form class="default_form">

            {{-- Height --}}
            <div style="margin-bottom: 6px; height: 34px">
                <span class="advFilter-label">@lang('Height')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="height" name="height">
                        <option value="">Select Option</option>
                        @foreach($heightOptions as $k => $v)
                        <option value="{{ $k }}" @if(isset($param['height']) && $param['height']==$k ) selected @endif>{{ $v }} ({{ $k }} cm)</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- End Height --}}

            {{-- Hair Color --}}
            <div style="margin-bottom: 6px; height: 34px">
                <span class="advFilter-label">@lang('Hair Color')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="hair_color" name="hair_color_id">
                        <option value="">Select Option</option>
                        @forelse($hairColors as $k)
                        <option value="{{ $k->id }}" @if(isset($param['hair_color_id']) && $param['hair_color_id']==$k->id ) selected @endif>{{ $k->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            {{-- End Hair Color --}}

            {{-- Hair Length --}}
            <div style="margin-bottom: 6px; height: 34px">
                <span class="advFilter-label">@lang('Hair Length')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="hair_length" name="hair_length">
                        <option value="">Select Option</option>
                        @forelse($hairLengthOptions as $val => $lbl)
                        <option value="{{ $val }}" @if(isset($param['hair_length']) && $param['hair_length']==$val ) selected @endif>{{ $lbl }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            {{-- End Hair Length --}}

            {{-- Pubic Hair --}}
            <div style="margin-bottom: 6px; height: 34px">
                <span class="advFilter-label">@lang('Pubic Hair')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="Ethnicity">
                        <option value="">Select Option</option>
                    </select>
                </div>
            </div>
            {{-- End Pubic Hair --}}
        </form>
    </div>

    <div class="col-lg-10">
        <form class="default_form">

            {{-- Breast Size --}}
            <div style="margin-bottom: 6px; height: 34px">
                <span class="advFilter-label">@lang('Breast Size')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="Country">
                        <option value="">Select Option</option>
                    </select>
                </div>
            </div>
            {{-- End Breast Size --}}

            {{-- Dress Size --}}
            <div style="margin-bottom: 6px; height: 34px">
                <span class="advFilter-label">@lang('Dress Size')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="Country">
                        <option value="">Select Option</option>
                    </select>
                </div>
            </div>
            {{-- End Dress Size --}}

            {{-- Eye Color --}}
            <div style="margin-bottom: 6px; height: 34px">
                <span class="advFilter-label">@lang('Eye Color')</span>
                <div class="select_parent selectTwo advFilter-drop">
                    <select id="eye_color" name="eye_color_id">
                        <option value="">Select Option</option>
                        @forelse($eyeColors as $k)
                        <option value="{{ $k->id }}" @if(isset($param['eye_color_id']) && $param['eye_color_id']==$k->id ) selected @endif>{{ $k->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            {{-- End Eye Color --}}
        </form>
    </div>
</div>