@extends('layouts.dashBoard')

@section('title', 'シナリオ登録')

@section('content_header')
  <h1>シナリオ登録</h1>
@endsection

@section('content')
  <form method="POST" action="/scenario/{{$id}}/add">
    @csrf
    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="登録">
      <input type="hidden" id="user_id" name="scenario[user_id]" value="{{$id}}">
      <input type="hidden" id="user_id" name="scenario[project_id]" value="999999">
      <input type="text" id="name" name="scenario[name]">
      <input type="textarea" id="description" name="scenario[description]" >
      変数入力
      <div id="input_pluralBox">
        <div id="input_plural">
          <div class="row">
            <div class="col-2">
              <input type="text" name="parameter[name][]" class="form-control" placeholder="変数名" value="">
            </div>
            <div class="col-7">
              <input type="text" name="parameter[value][]" class="form-control" placeholder="値" value="">
            </div>
            <input type="button" value="＋" class="add pluralBtn">
            <input type="button" value="－" class="del pluralBtn">
          </div>
        </div>
      </div>
    </div>
  </form>


@endsection
