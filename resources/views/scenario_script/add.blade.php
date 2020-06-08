@extends('layouts.add')
@section('add_title')
@php
if($action == 'add'){
  $add_title = 'スクリプト追加';
}elseif($action == 'edit'){
  $add_title = 'スクリプト編集';
}else{
  $add_title = '';
}
@endphp
@endsection

@section('input_field')
<div class="row">
  <div class="col-4">
    <label>スクリプト名</label>
    <input type="hidden" name="scenario_id" id="scenario_id" value="{{$parent_id}}">
    @isset($item)
    <input type="hidden" name="scenario_script_id" id="scenario_script_id" value="{{$item->id}}">
    @endisset
    <input type="text" name="name" class="form-control" placeholder="スクリプト名" value="@isset($item){{$item->name}}@endisset">
  </div>
</div>
@endsection
