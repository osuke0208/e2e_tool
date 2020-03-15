@extends('layouts.dashBoard')

@section('title','変数一覧')

@section('content_header')
  <h1>変数一覧</h1>
@endsection

@section('content')

<a href="/scenario_parameter/{{$id}}/add">変数追加</a>

<div class="container">
  <table class="table table-condensed">
  <tr>
    <th style="width: 10px">#</th>
    <th>変数名</th>
    <th>値</th>
    <th>説明</th>
  </tr>
  @foreach($items as $item)
    <tr>
      <td>{{$item->id}}</td>
      <td>{{$item->name}}</td>
      <td>{{$item->value}}</td>
      <td>$item->description</td>
    </tr>
  @endforeach

</div>


@endsection
