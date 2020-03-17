@extends('layouts.add')
@php
  $add_title = 'プロジェクト追加';
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
        <input type="text" class="form-ctl" id="name" name="name" placeholder="プロジェクト名">
      </div>
    </div>
  </div>
</form>

@endsection
