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

                <form class="form es es-validation" method="POST" action="{{ route('admin.permissions.save') }}">

                    <h4>@lang('Role')</h4>

                    <hr/>

                    {{-- role --}}
                    <div class="form-group row @if ($errors->has('id')) has-danger @endif">
                        <label class="control-label col-3 text-right" for="id">
                            @lang('Role')
                        </label>
                        <div class="col-9">
                            @include('Admin::common.form.roles', ['name' => 'id', 'baseRedirectRoute' => 'admin.permissions.manage', 'showNewOption' => true, 'value' => $role->getKey()])
                            @include('Admin::common.form.error', ['key' => 'id'])
                        </div>
                    </div>
                    {{-- end role --}}

                    {{-- role group name --}}
                    <div class="form-group row @if ($errors->has('group')) has-danger @endif">
                        <label class="control-label col-3 text-right es-required" for="role">
                            @lang('Role Name')
                        </label>
                        <div class="col-9">
                            <input type="text" id="role" name="group" placeholder="@lang('New Role Name')" class="form-control" value="{{ $role->group }}">

                            @include('Admin::common.form.error', ['key' => 'group'])
                        </div>
                    </div>
                    {{-- end role group name --}}

                    <div class="form-group row" style="margin-bottom:0;">
                        <label class="control-label col-3 text-left" for="" style="margin-bottom:0;"><h4>@lang('Permissions') </h4></label>
                        <div class="col-9">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input es es-check-items" data-check-items-selector=".groups">
                                <span class="custom-control-label">
                                    @lang('All')
                                </span>
                            </label>
                        </div>
                    </div>
                    <hr/>

                    @foreach ($permissions as $group => $commands)
                        <div class="form-group row">
                            <label class="control-label col-3 text-right" for="{{ $group }}">
                                @lang(ucwords(str_replace('_', ' ', $group)))
                            </label>
                            <div class="col-9">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input es es-check-items groups" data-check-items-selector=".{{ $group }}-ids">
                                    <span class="custom-control-label">
                                        @lang('All')
                                    </span>
                                    <hr />
                                </label>
                                @foreach ($commands as $command)
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" name="permissions[{{ $command->getGroup() }}][]" value="{{ $command->getName() }}" class="custom-control-input {{ $group }}-ids" @if ($command->hasPermission()) checked="" @endif>

                                        <span class="custom-control-label">
                                            @lang(ucwords(str_replace('_', ' ', $command->getName())))
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

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

@pushAssets('scripts.post')
    <script type="text/javascript">
        $(function () {
            $('#id').on('change', function() {
                var $clicked = $(this).find(':selected');
                if ($clicked.length > 0) {
                    var href = $clicked.data('href');
                    if (href != 'undefined') {
                        location.href = href;
                    }
                }
            });
        });
    </script>
@endPushAssets
