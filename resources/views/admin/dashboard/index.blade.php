@extends('Admin::layout')

@section('main.content')

@php
    $total_sales = 0.00;
    $recent_sales = 0.00;
    $recent = $sales['recent'];
    $overall = $sales['total'];

    foreach($overall as $k) {
        $total_sales += $k;
    }

    foreach($recent as $v) {
        $recent_sales += $v;
    }
@endphp

<div class="col-lg-12">
    <div class="row">
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <div class="box bg-info text-center">
                    <h1 class="font-light text-white">{{ number_format($new['escort']) }}</h1>
                    <h6 class="text-white">@lang('New Escorts')</h6>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <div class="box bg-success text-center">
                    <h1 class="font-light text-white">{{ number_format($new['agency']) }}</h1>
                    <h6 class="text-white">@lang('New Agency')</h6>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <div class="box bg-danger text-center">
                    <h1 class="font-light text-white">N/A</h1>
                    <h6 class="text-white">@lang('New Users')</h6>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <div class="box bg-primary text-center">
                    <h1 class="font-light text-white">{{ $recent_sales }}</h1>
                    <h6 class="text-white">@lang('New Sales')</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <div class="box bg-info text-center">
                    <h1 class="font-light text-white">{{ number_format($total['escort']) }}</h1>
                    <h6 class="text-white">@lang('Total Escorts')</h6>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <div class="box bg-success text-center">
                    <h1 class="font-light text-white">{{ number_format($total['agency']) }}</h1>
                    <h6 class="text-white">@lang('Total Agency')</h6>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <div class="box bg-danger text-center">
                    <h1 class="font-light text-white">N/A</h1>
                    <h6 class="text-white">@lang('Total Users')</h6>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <div class="box bg-primary text-center">
                    <h1 class="font-light text-white">{{ $total_sales }}</h1>
                    <h6 class="text-white">@lang('Total Sales')</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
