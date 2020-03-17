@extends('layouts.index')

@php
  $index_title = '組織一覧';
@endphp

@section('content_table')
  <div class="container">
    <table class="table table-condensed">
    <tr>
      <th>組織名</th>
      <th>概要</th>
    </tr>
    @foreach($items as $item)
      <tr>
        <td>{{$item->name}}</td>
        <td>{{$item->description}}</td>
      </tr>
    @endforeach
  </div>
@endsection
