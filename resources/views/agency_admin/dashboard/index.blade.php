@extends('AgencyAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-gauge"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    @include('AgencyAdmin::dashboard.components.statistics')
    @include('AgencyAdmin::dashboard.components.visitors_graph')
    @include('AgencyAdmin::dashboard.components.site_news')
    @include('AgencyAdmin::dashboard.components.latest_reviews', ['reviews' => $latestReviews])
    @include('AgencyAdmin::dashboard.components.escorts_latest_reviews', ['reviews' => $escortsLatestReviews])
@endsection
