@extends('layouts.index')

@php
  $index_title = 'プロジェクト一覧';
@endphp

@section('content_table')
  <div class="container">
    <table class="table table-condensed">
    <tr>
      <th>プロジェクト名</th>
      <th>シナリオ</th>
    </tr>
    @foreach($items as $item)
      <tr>
        <td>{{$item->name}}</td>
        <td>
        @foreach($item->scenario as $scenario)
        {{$scenario->name}}
        @endforeach
        </td>
      </tr>
    @endforeach
  </div>
@endsection
