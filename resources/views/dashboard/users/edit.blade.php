@extends('layouts.contentNavbarLayout')
@section('title', 'Usuario '. $user->name)

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
  {!! Form::model($user, ['route' => ['dashboard.users.update', $user], 'method' => 'put']) !!}
  @foreach($roles as $role)
    <div>
      <label>
        {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'form-check-input me-1']) !!}
        {{ $role->name }}
      </label>
    </div>
  @endforeach
    {!! Form::submit('Asignar rol', ['class' =>'btn btn-primary']) !!}
  {!! Form::close() !!}
  @livewire('dashboard-user-edit')
@endsection