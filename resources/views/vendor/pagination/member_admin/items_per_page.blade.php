<div class="pull-right currency-drop">
    <select class="selectpicker" data-style="btn-info" onchange="javascript:location.href = this.value;">
        <option style="display:none">@lang(':limit Per page', ['limit' => $selectedLimit])</option>
        @foreach ($limitOptions as $option)
            <option value="{{ $option['link'] }}" class="dropdown-item">@lang(':limit Per page', ['limit' => $option['text']])</a>
        @endforeach
    </select>
</div>
