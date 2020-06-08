@extends('layouts.add')

@php
  $add_title = 'パラメータ編集';
@endphp

@section('input_field')
<div class="row">
  <div class="col-3">
    <input type="hidden" name="scenario_id" value="{{$parent_id}}">
    <input type="hidden" name="{{$domain}}_id" value="{{$this_id}}">
    <input type="text" class="form-control" id="name" name="name" placeholder="変数名" value="{{$item->name}}">
  </div>
  <div class="col-3">
    <input type="text" class="form-control" id="name" name="value" placeholder="値" value="{{$item->value}}">
  </div>
</div>
@endsection
