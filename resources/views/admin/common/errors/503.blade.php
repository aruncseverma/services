@extends('Admin::common.errors.layout')

@section('title', __('Under Maintenance'))

@section('status.code', $exception->getStatusCode())

@section('message', __('Site is current under maintenance. Please try again sometime.'))
