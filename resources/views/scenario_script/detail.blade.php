@extends('layouts.index')

@php
  $index_title = 'スクリプト「'.$item->name.'」';
@endphp

@section('content_table')
<div class="col-3">
  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal_script">
    Script JSON表示
  </button>
</div>
<br/>
<div class="container">
  <div class="card card-outline card-primary">
    <div class="card-header">
      <div class="card-title">
        <h3>
          操作一覧
          <a href="/scenario_operation/{{$id}}/add/{{$this_id}}" class="btn btn-primary">操作追加</a>
        </h3>
      </div>
    </div>
    <div class="card-body">

      @foreach($item->scenario_operation as $scenario_operation)
      <div class="card card-default collapsed-card">
        <div class="card-header with-border">
          <h3 class="card-title">
            <a href="" data-card-widget="collapse">{{$scenario_operation->name}}</a>
          </h3>
          <div class="card-tools">
            <div class="row">
              <div class="col-6 text-right">
                <a href="/scenario_operation/{{$id}}/edit/{{$this_id}}/{{$scenario_operation->id}}"><i class="fa fa-edit"></i></a>
              </div>
              <div class="col-6">
                <a href="#modal_scenario_operation_{{$scenario_operation->id}}" data-toggle="modal"><i class="fas fa-trash-alt"></i></a>
                @component('layouts.modal')
                  @slot('modal_id','modal_scenario_operation_'.$scenario_operation->id)
                  @slot('modal_title',$scenario_operation->name.'を削除しますか?')
                  @slot('modal_body')
                    @include('scenario_operation.delete')
                  @endslot
                @endcomponent
              </div>
            </div>
          </div>
            <!-- /.card-tools -->
        </div>
          <!-- /.card-header -->
        <div class="card-body">
          {{$scenario_operation->make_json()}}
        </div>
          <!-- /.card-body -->
      </div>
      @endforeach
    </div>
  </div>
</div>
  @component('layouts.modal')
    @slot('modal_id','modal_script')
    @slot('modal_title','Script Json')
    @slot('modal_body')
      <pre>{{$item->make_json()}}</pre>
    @endslot
  @endcomponent
@endsection
