@extends('layouts.add')
@php
  $add_title = '変数追加';
@endphp

@section('input_field')
<div id="input_pluralBox">
  <div id="input_plural">
    <div class="row">
      <div class="col-2">
        <input type="hidden" name="scenario_id" value="{{$parent_id}}">
        <input type="text" name="{{$domain}}[name][]" class="form-control" placeholder="変数名" value="">
      </div>
      <div class="col-7">
        <input type="text" name="{{$domain}}[value][]" class="form-control" placeholder="値" value="">
      </div>
      <input type="button" value="＋" class="add pluralBtn">
      <input type="button" value="－" class="del pluralBtn">
    </div>
  </div>
</div>
@endsection
