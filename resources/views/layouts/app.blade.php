<!DOCTYPE html>
<html
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
<head>
  <meta charset="utf-8"/>
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
  />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title') </title>

  <meta name="description" content=""/>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}"/>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet"
  />

  <!-- Include Styles -->
  @include('layouts.sections.styles')

  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('layouts.sections.scriptsIncludes')
  @livewireStyles
</head>

<body>


<!-- Layout Content -->
@yield('layoutContent')
<!--/ Layout Content -->

<!-- Include Scripts -->
@include('layouts/sections/scripts')
</body>
</html>
