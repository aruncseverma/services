<div class="col-xs-20 boxpanel">
    <div>
        {{ $agency->name ?? '' }}
    </div>
    <small>
        <b>Escorts: </b> {{ $agency->getTotalEscorts() }}<br />
        <p class="text-danger">{{ $agency->mainLocation->country->name }} / {{ $agency->mainLocation->city->name }}</p>
    </small>
</div>
