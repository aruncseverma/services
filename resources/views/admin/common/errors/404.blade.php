@extends('Admin::common.errors.layout')

@section('title', __('Page not found'))

@section('status.code', $exception->getStatusCode())

@section('message', __('Oh! You seems to be lost.'))
