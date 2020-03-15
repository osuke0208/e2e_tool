@extends('layouts.dashBoard')

@section('title', '変数登録')

@section('content_header')
  <h1>変数登録</h1>
@endsection

@section('content')
  <form method="POST" action="/scenario_parameter/{{$id}}/add">
    @csrf
    <div class="form-group">
      <div class="row">
        <div class="col-3">
          <input type="submit" class="btn btn-primary" value="登録">
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          <input type="text" name="scenario[name]" class="form-control" placeholder="シナリオ名">
        </div>
      </div>
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
