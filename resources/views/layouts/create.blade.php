<div id="{{$domain}}_create">
  @if($_edit)
  <form method="POST" id="create_{{$domain}}_form" action="/{{$domain}}/{{$item->id}}">
    @method('PUT')
  @else
  <form method="POST" id="create_{{$domain}}_form" action="/{{$domain}}">
  @endif
    @csrf
    @foreach($forms as $form)
      <div class="row">
        <div class="col-12">
          <label>{{$form['label']}}</label>
          <span class="right badge badge-{{$form['required'] ? 'danger' : 'secondary'}} ml-1">{{$form['required'] ? '必須' : '任意' }}</span>
          @if($form['type'] == 'text')
            <input type="{{$form['type']}}" class="form-control" name="{{$form['name']}}" value="{{$_edit || $_copy ? $item[$form['name']] : ''}}" {{$form['required'] ? 'required' : ''}}>
          @elseif($form['type'] == 'textarea')
            <textarea name="{{$form['name']}}" class="form-control" {{$form['required'] ? 'required' : ''}}>{{$_edit || $_copy ? $item[$form['name']] : ''}}</textarea>
          @endif
        </div>
      </div>
    @endforeach
    <button type="button" class="btn btn-submit btn-primary btn-block mt-2" accesskey="{{$domain}}_create">
      <i class="fa fa-plus mr-1" ></i>
      登録する
    </button>
  </form>
</div>
