@extends('layouts.index')

@php
  $index_title = '変数一覧';
@endphp

@section('content_table')
  <div class="container">
    <table class="table table-condensed">
    <tr>
      <th style="width: 10px">#</th>
      <th>変数名</th>
      <th>値</th>
      <th>所属シナリオ</th>
    </tr>
    @foreach($items as $item)
      <tr>
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->value}}</td>
        <td>{{$item->scenario->name}}</td>
      </tr>
    @endforeach
  </div>
@endsection
