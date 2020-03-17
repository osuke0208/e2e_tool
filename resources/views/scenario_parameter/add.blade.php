@extends('layouts.add')
@php
  $add_title = '変数追加';
  $label = '変数名';
@endphp

@section('input_field')
@include('layouts.scenario_select')
<div id="input_pluralBox">
  <div id="input_plural">
    <div class="row">
      <div class="col-2">
        <input type="text" name="{{$domain}}[name][]" class="form-control" placeholder="{{$label}}" value="">
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
