@extends('Admin::common.errors.layout')

@section('title', __('Error'))

@section('status.code', $exception->getStatusCode())

@section('message', __('Oooooh!. Stop spamming requests....'));
