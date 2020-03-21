@extends('layouts.add')
@php
  $add_title = 'プロジェクト追加';
  $label = '項目';
@endphp

@section('input_field')
<div class="row">
  <div class="col-3">
    <input type="hidden" name="organisation_id" value="1">
    <input type="text" class="form-control" id="name" name="name" placeholder="プロジェクト名">
  </div>
</div>
@endsection
