@extends('layouts.add')
@php
  $add_title = 'シナリオ追加';
  $label = 'シナリオ名';
@endphp

@section('input_field')
  <input type="hidden" id="project_id" name="project_id" value="{{$parent_id}}">
  <div class="row">
    <div class="col-3">
      <input type="hidden" id="user_id" name="user_id" value="{{$id}}">
      <input  type="text" class="form-control" id="name" placeholder="シナリオ名" name="name" >
    </div>
    <div class="col-6">
      <input  type="text" class="form-control" id="description" placeholder="概要" name="description" >
    </div>
  </div>
@endsection
