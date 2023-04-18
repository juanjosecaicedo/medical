@extends('layouts.contentNavbarLayout')
@section('title', 'Usuarios')

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-calendar.css')}}">
@endsection

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/calendar/toastui-calendar.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/calendar/tui-time-picker.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/calendar/tui-date-picker.min.css')}}">
@endsection


@section('content')
    @livewire('dashboard-user-index')
@endsection