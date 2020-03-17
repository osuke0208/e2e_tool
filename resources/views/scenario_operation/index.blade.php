@extends('layouts.index')

@php
  $index_title = '操作一覧';
@endphp

@section('content_table')
  <div class="container">
    <table class="table table-condensed">
    <tr>
      <th style="width: 10px">#</th>
      <th>操作名</th>
      <th>json</th>
    </tr>
    @foreach($items as $item)
      <tr>
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td><pre>{{--$item->make_json()--}}</pre></td>
      </tr>
    @endforeach
  </div>
@endsection
