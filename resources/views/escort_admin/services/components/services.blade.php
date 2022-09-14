@foreach ($categories as $category)
    <div class="col-12">
        <div class="card">
            <div class="card-header" data-toggle="collapse" data-target="#categories_{{ $category->getKey() }}">
                <div class="card-actions">
                    <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
                </div>
                <span>{{ $title = $category->getDescription(app()->getLocale())->content }}</span>
            </div>
            <div class="card-header-sub">
                @lang('Choose :service you offer', ['service' => strtolower($title)])
            </div>
            <div class="card-body collapse show" id="categories_{{ $category->getKey() }}">
                @if (old('notify') === "services.{$category->getKey()}")
                    @include('EscortAdmin::common.notifications')
                @endif

                @if ($category->isEscortAllowed($escort))
                    <form method="POST" action="{{ route('escort_admin.services.update_services', ['category' => $category->getKey()]) }}">

                        {{ csrf_field() }}

                        {{-- services --}}
                        <div class="row">
                            @forelse ($category->services as $service)
                                @php 
                                    $job = $escort->services()->where('service_id', '=', $service->id)->first()
                                @endphp
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="">{{ $service->getDescription(app()->getLocale())->content }}</label>
                                        <select class="selectpicker" data-style="form-drop" name="services[{{ $service->getKey() }}]">
                                            @foreach ($serviceTypesOptions as $value => $description)
                                                <option value="{{ $value }}" @if ($job != null && $job->type === $value) selected="selected" @endif>{{ $description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center"><h2 class="text-uppercase">@lang('No services defined for this category')</h2></div>
                            @endforelse
                        </div>
                        {{-- end services --}}

                        @if ($category->services->count() > 0)
                            <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save text-uppercase">@lang('Save')</button>
                        @endif
                    </form>
                @else
                    <div class="col-12 text-center"><h2 class="text-uppercase">@lang('Not available in your location')</h2></div>
                @endif
            </div>
        </div>
    </div>
@endforeach
