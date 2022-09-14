@foreach (app('notify')->all() as $notification)
    <div class="alert @if ($notification->type == 'error') alert-danger @else alert-{{ $notification->type }} @endif">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>

        @if ($notification->type == 'success')
            <h3 class="text-success"><i class="fa fa-check-circle"></i> @lang('Success')</h3>
        @elseif ($notification->type == 'warning')
            <h3 class="text-warning"><i class="fa fa-warning"></i> @lang('Warning')</h3>
        @elseif ($notification->type == 'info')
            <h3 class="text-info"><i class="fa fa-info-circle"></i> @lang('Information')</h3>
        @elseif ($notification->type == 'error')
            <h3 class="text-danger"><i class="fa fa-warning"></i> @lang('Ooops!')</h3>
        @endif

        {!! $notification->message !!}
    </div>
@endforeach
