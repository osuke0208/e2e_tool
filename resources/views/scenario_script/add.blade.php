@extends('layouts.add')
@php
  $add_title = 'スクリプト追加';
  $label = '項目';
@endphp

@section('additional_item')
<div class="row">
  <div class="col-4">
    <label>スクリプト名</label>
    <input type="text" name="name" class="form-control" placeholder="スクリプト名" value="">
  </div>
</div>
@include('layouts.scenario_select')
@endsection
