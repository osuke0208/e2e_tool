@extends('layouts.add')
@php
  $add_title = '組織追加';
  $label = '項目';
@endphp

@section('content')
<form method="POST" action="/{{$domain}}/{{$id}}/add">
  @csrf
  <div class="form-group">
    <div class="row">
      <div class="col-3">
        <input type="submit" class="btn btn-primary" value="登録">
      </div>
    </div>
    <div class="row">
      <div class="col-3">
        <input type="text" id="name" name="name" placeholder="組織名">
      </div>
      <div class="col-5">
        <input type="text" id="description" name="description" placeholder="概要">
      </div>
    </div>
  </div>
</form>

@endsection
