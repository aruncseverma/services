@extends('Index::layout')

@section('main.content')
<h2>Member</h2>
<a href="{{ route('index.auth.member.register_form') }}">Sigup Now</a>
<hr />
<h2>Escort</h2>
<a href="{{ route('index.auth.escort.register_form') }}">Sigup Now</a>
<hr />
<h2>Agency</h2>
<a href="{{ route('index.auth.agency.register_form') }}">Sigup Now</a>
<hr />
@endsection