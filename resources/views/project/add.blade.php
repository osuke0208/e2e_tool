@extends('layouts.add')
@php
if($action == 'add'){
  $add_title = 'プロジェクト追加';
}elseif($action == 'edit'){
  $add_title = 'プロジェクト編集';
}else{
  $add_title = '';
}
@endphp

@section('input_field')
<div class="row">
  <div class="col-3">
    <input type="hidden" name="organisation_id" value="1">
    @isset($item)
      <input type="hidden" name="project_id" value="{{$item->id}}">
    @endisset
    <input type="text" class="form-control" id="name" name="name" placeholder="プロジェクト名" value="@isset($item){{$item->name}}@endisset">
  </div>
</div>
@endsection
