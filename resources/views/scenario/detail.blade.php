@extends('layouts.index')

@php
  $index_title = 'シナリオ「'.$item->name.'」';
@endphp

@section('content_table')
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          {{$item->name}}<a href="/{{$domain}}/{{$id}}/edit/{{$parent_id}}/{{$item->id}}"><i class="fa fa-edit"></i></a>
        </h3>
        <div class="card-tools">
          <div class="col-12">
            <button type="button" class="btn-sm btn-primary btn-lg" data-toggle="modal" data-target="#modal_scenario">
              Scenario JSON表示
            </button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-xs-6">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">
                スクリプト一覧
                <a href="/scenario_script/{{$id}}/add/{{$item->id}}" class="btn btn-primary">追加</a>
              </h3>

            </div>
            <div class="card-body">
              <table class="table table-condensed">
                <tr>
                  <th>スクリプト名</th>
                  <th>操作一覧</th>
                  <th></th>
                </tr>
                @foreach($item->scenario_script as $scenario_script)
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col-8 ">
                          {{$scenario_script->name}}
                        </div>
                        <div class="col-3 text-right">
                          <a href="/scenario_script/{{$id}}/edit/{{$item->id}}/{{$scenario_script->id}}"><i class="fa fa-edit"></i></a>
                        </div>
                      </div>
                    </td>
                    <td>
                      @foreach($scenario_script->scenario_operation as $scenario_oparation)
                        <div>
                          {{$scenario_oparation->name}}
                        </div>
                      @endforeach
                    </td>
                    <td>
                      <a href="/scenario_script/{{$id}}/detail/{{$scenario_script->id}}" class="btn btn-primary">
                        詳細
                      </a>
                    </td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xs-6">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">
                シナリオ変数
                <a href="/scenario_parameter/{{$id}}/add/{{$item->id}}" class="btn btn-primary">追加</a>
              </h3>
            </div>
            <div class="card-body">
              <table class="table table-condensed">
                <tr>
                  <th>変数名</th>
                  <th>値</th>
                </tr>
                @foreach($item->scenario_parameter as $scenario_parameter)
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col-6">
                          {{$scenario_parameter->name}}
                        </div>
                        <div class="col-3 text-right">
                          <a href="/scenario_parameter/{{$id}}/edit/{{$item->id}}/{{$scenario_parameter->id}}"><i class="fa fa-edit"></i></a>
                        </div>
                      </div>
                    </td>
                    <td>{{$scenario_parameter->value}}</td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @component('layouts.modal')
    @slot('modal_id','modal_scenario')
    @slot('modal_title','Scenario Json')
    @slot('modal_body')
      <pre>{{$item->make_json()}}</pre>
    @endslot
  @endcomponent
@endsection
