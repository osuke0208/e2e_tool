@extends('layouts.add')
@php
  $add_title = '操作追加';
  $label = '項目';
@endphp

@section('additional_item')
<div class="col-4">
  <label>操作名</label>
  <input type="text" name="scenario_script[name]" class="form-control" placeholder"操作名" value="">
</div>
@include('layouts.script_select')
@endsection

@section('input_field')
<div class="col-4">
  <label>event</label>
  <select name="scenario_script_parameter[event]" class="form-control">
    @foreach( $events as $event )
      <option value="{{$event->name}}">{{$event->name}}</option>
    @endforeach
  </select>
</div>
<div class="col-3">
  <label>capture</label>
  <select class="form-control" name="scenario_script_parameter[capture]">
    <option value="true">true</option>
    <option value="false">false</option>
  </select>
</div>
<div class="col-12">
  <input type="text" class="form-control" id="key" name="scenario_script_parameter[key]" placeholder="key">
</div>
<div class="col-12">
  <input type="text" class="form-control" id="attribute" name="scenario_script_parameter[attribute]" placeholder="attribute">
</div>
<div class="col-3">
  <input type="text" class="form-control" id="comment" name="scenario_script_parameter[comment]" placeholder="comment">
</div>
<div class="col-3">
  <input type="text" class="form-control" id="wait" name="scenario_script_parameter[wait]" placeholder="wait">
</div>
<div class="col-3">
  <input type="text" class="form-control" id="value" name="scenario_script_parameter[value]" placeholder="value">
</div>

@endsection
