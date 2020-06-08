@extends('layouts.add')
@php
if($action == 'add'){
  $add_title = 'シナリオグループ追加';
}elseif($action == 'edit'){
  $add_title = 'シナリオグループ編集';
}else{
  $add_title = '';
}
@endphp

@section('input_field')
<div class="row">
  <div class="col-3">
    <input type="hidden" name="{{$parent_domain}}_id" value="1">
    @isset($item)
      <input type="hidden" name="{{$domain}}_id" value="{{$item->id}}">
    @endisset
    <input type="text" class="form-control" id="name" name="name" placeholder="名前" value="@isset($item){{$item->name}}@endisset">
  </div>
</div>
@endsection
