<div class="card">
    <div class="card-header" data-toggle="collapse" data-target="#{{ $cardId }}">
        <div class="card-actions">
            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
        </div>
        <span>{{ $cardTitle }}</span>
    </div>
    <div class="card-body collapse show" id="{{ $cardId }}">
        <div class="message-box">
            <div class="message-widget">
                {{ $cardContent }}
            </div>
        </div>
    </div>
</div>