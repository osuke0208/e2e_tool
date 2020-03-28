@extends('layouts.add')
@php
if( $action == 'add'){
  $add_title = '操作追加';
}elseif( $action == 'edit'){
  $add_title = '操作編集';
}

@endphp


@section('input_field')
<div class="container">
  <div class="col-4">
    <label>操作名</label>
    <input type="text" name="scenario_script[name]" class="form-control" placeholder="操作名" value="@isset($item){{$item->name}}@endisset">
    <input type="hidden" name="scenario_script_id" id="scenario_script_id" value="{{$parent_id}}">
    @isset($item)
    <input type="hidden" name="scenario_operation_id" id="scenario_operation_id" value="{{$item->id}}">
    <input type="hidden" name="scenario_script_order" id="scenario_script_order" value="{{$item->scenario_script_order}}">
    @endisset
  </div>
  <div class="col-4">
    <label>event</label>
    <select name="scenario_script_parameter[event]" class="form-control">
      @foreach( $events as $event )
        @isset($item)
          @if($event->name == $item->scenario_script_parameter->where('name','event')->first()->value)
          <option value="{{$event->name}}" selected>{{$event->name}}</option>
          @else
          <option value="{{$event->name}}">{{$event->name}}</option>
          @endif
        @else
          <option value="{{$event->name}}">{{$event->name}}</option>
        @endisset
      @endforeach
    </select>
  </div>
  <div class="col-3">
    <label>capture</label>
    <select class="form-control" name="scenario_script_parameter[capture]">
      @isset($item)
        @if($item->scenario_script_parameter->where('name','capture')->first()->value == 'false')
          <option value="true">true</option>
          <option value="false" selected>false</option>
        @else
          <option value="true" selected>true</option>
          <option value="false">false</option>
        @endif
      @else
        <option value="true">true</option>
        <option value="false">false</option>
      @endisset
    </select>
  </div>
  <div class="col-12">
    <input type="text" class="form-control" id="key" name="scenario_script_parameter[key]" placeholder="key" value="@isset($item){{$item->scenario_script_parameter->where('name','key')->first()->value}}@endisset">
  </div>
  <div class="col-12">
    <input type="text" class="form-control" id="attribute" name="scenario_script_parameter[attribute]" placeholder="attribute" value="@isset($item){{$item->scenario_script_parameter->where('name','attribute')->first()->value}}@endisset">
  </div>
  <div class="col-3">
    <input type="text" class="form-control" id="comment" name="scenario_script_parameter[comment]" placeholder="comment" value="@isset($item){{$item->scenario_script_parameter->where('name','comment')->first()->value}}@endisset">
  </div>
  <div class="col-3">
    <input type="text" class="form-control" id="wait" name="scenario_script_parameter[wait]" placeholder="wait" value="@isset($item){{$item->scenario_script_parameter->where('name','wait')->first()->value}}@endisset">
  </div>
  <div class="col-3">
    <input type="text" class="form-control" id="value" name="scenario_script_parameter[value]" placeholder="value" value="@isset($item){{$item->scenario_script_parameter->where('name','value')->first()->value}}@endisset">
  </div>
</div>
@endsection
