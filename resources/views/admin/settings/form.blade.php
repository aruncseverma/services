@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
    {{ $title }}
@endsection
{{-- end title --}}

@section('main.content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                {{-- notification --}}
                @include('Admin::common.notifications')
                {{-- end notification --}}

                <form class="form es es-validation" method="POST" action="{{ route('admin.settings.save') }}">
                    {{-- input group --}}
                    <input type="hidden" name="group" value="{{ $group }}">
                    {{-- end input --}}

                    @yield('settings.form_input')

                    <hr/>

                    {{ csrf_field() }}
                    <div class="form-actions pull-right">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
