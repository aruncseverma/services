@extends('Admin::common.errors.layout')

@section('title', __('Page Expired'))

@section('status.code', $exception->getStatusCode())

@section('message', __('The page has expired due to inactivity. Please refresh and try again.'));
