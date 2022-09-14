@extends('Admin::common.errors.layout')

@section('title', __('Unauthorized Access'))

@section('status.code', $exception->getStatusCode())

@section('message', __('You don\'t have permission to access this server.'))
