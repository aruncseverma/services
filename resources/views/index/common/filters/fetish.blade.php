{{-- Fetish --}}
<h2 class="resp-accordion hor_1" role="tab"></h2>
<div class="item-content row" id="filter_fetish_services">
    @php
    $fetishServiceIds = isset($param['fetish_service_ids']) && !empty($param['fetish_service_ids']) ? explode(',', $param['fetish_service_ids']) : [];
    @endphp
    @forelse($fetishServices as $service)
    <div class="col-lg-5">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="{{ $service->id }}" value="{{ $service->id }}" @if(in_array($service->id, $fetishServiceIds)) checked @endif>
            <label class="custom-control-label" for="{{ $service->content }}">{{ $service->content }} ({{ $service->total }})</label>
        </div>
    </div>
    @empty
    <div class="col-lg-20">
        <center>
            <h2>No Services Available</h2>
        </center>
    </div>
    @endforelse
    <div class="clearfix"></div>
</div>
{{-- End Fetish --}}