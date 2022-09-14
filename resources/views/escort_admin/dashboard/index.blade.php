@extends('EscortAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-gauge"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    @include('EscortAdmin::dashboard.components.notifications')
    @include('EscortAdmin::dashboard.components.statistics')
    @include('EscortAdmin::dashboard.components.visitors_graph')
    @include('EscortAdmin::dashboard.components.site_news')
    @include('EscortAdmin::dashboard.components.vip_status')
    @include('EscortAdmin::dashboard.components.latest_reviews', ['reviews' => $latestReviews])
@endsection
