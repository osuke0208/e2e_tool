@extends('layouts.index')

@php
  $index_title = 'スクリプト一覧';
@endphp

@section('content_table')
  <div class="container">
    <table class="table table-condensed">
    <tr>
      <th style="width: 10px">#</th>
      <th>スクリプト名</th>
      <th>json</th>
    </tr>
    @foreach($items as $item)
      <tr>
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td><pre>
          @foreach($item->make_json() as $json)
            {{$json}}
          @endforeach
        </pre></td>
      </tr>
    @endforeach
  </div>
@endsection
