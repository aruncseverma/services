@if ($photo && $mimeType)
    <div class="text-center">
        <img class="img-thumbnail" src="data:{{ $mimeType }};base64,{{ base64_encode($photo) }}" width="360">
    </div>
@endif
