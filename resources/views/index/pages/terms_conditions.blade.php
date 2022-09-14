@extends('Index::layout')

{{-- title --}}
@section('main.content.title')
{{ $title ?? '' }}
@endsection
{{-- end title --}}

@section('main.content')
<h1>Terms & Conditions</h1>
<h2>Sample website usage terms and conditions</h2>
@endsection