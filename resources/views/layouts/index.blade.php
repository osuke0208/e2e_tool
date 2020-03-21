@extends('layouts.dashBoard')

@section('title')
  {{$index_title}}
@endsection

@section('content_header')
  <h1>{{ $index_title }}</h1>
@endsection

@section('content')

@yield('content_table')

@endsection
