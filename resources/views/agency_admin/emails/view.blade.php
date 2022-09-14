@extends('AgencyAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-email"></i>&nbsp;{{ $title }}: {{ $email->title }}
@endsection

@section('main.content')
    <div class="col-lg-2 col-md-4">
        <div class="card-body inbox-panel"><a href="{{ route('agency_admin.emails.compose') }}" class="btn btn-primary m-b-20 p-10 btn-block waves-effect waves-light">Compose</a>
            <ul class="list-group list-group-full">
                <li class="list-group-item active"> <a href="{{ route('agency_admin.emails.manage') }}"><i class="mdi mdi-gmail"></i> Inbox </a><span class="badge badge-success ml-auto">{{ $email_count }}</span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-10 col-md-8">
        <form method="post" action="{{ route('agency_admin.emails.delete') }}">
        @csrf
            <div class="card-body text-right">
                <div class="btn-group m-b-10 m-r-10" role="group" aria-label="Button group with nested dropdown">
                    <input type="hidden" name="email_id" value="{{ $email->id }}" />
                    <button type="submit" class="btn btn-secondary font-18 text-dark es es-confirm"><i class="mdi mdi-delete"></i></button>
                    <a href="{{ route('agency_admin.emails.view', $email->id) }}" class="btn btn-secondary font-18 text-dark"><i class="mdi mdi-reload"></i></a>
                </div>

            </div>
            <div class="card-body p-t-0">
                <div class="card b-all shadow-none">
                    <div class="card-body">
                        <h3 class="card-title m-b-0">{{ $email->title }}</h3>
                    </div>
                    <div>
                        <hr class="m-t-0">
                    </div>
                    <div class="card-body">
                        <div class="d-flex m-b-40">
                            <div>
                                <a href="javascript:void(0)"><img src="{{ $email->sender->profilePhotoUrl ?? $noImageUrl }}" alt="user" width="40" class="img-circle" /></a>
                            </div>
                            <div class="p-l-10">
                                <h4 class="m-b-0">{{ $email->sender->name }}</h4>
                                <small class="text-muted">{{ $email->sender->email }}</small>
                            </div>
                        </div>
                        {!! $email->getContentAttribute() !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
