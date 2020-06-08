<div class="float-right">
  @if($item_buttons_param['_update'])
  <a href="javascript:void(0)" title="編集" page_form="dialog" page_title="{{$item->name}}編集" page_url="/{{$domain}}/{{$item->id}}/edit"  class="btn btn-sm btn-secondary" role="button">
    <i class="fa fa-edit"></i>
  </a>
  @endif
  @if($item_buttons_param['_copy'])
  <a href="javascript:void(0)" title="コピー" page_form="dialog" page_title="{{$item->name}}コピー" page_url="/{{$domain}}/{{$item->id}}/copy"  class="btn btn-sm btn-success" role="button">
    <i class="fa fa-copy"></i>
  </a>
  @endif
  @if($item_buttons_param['_delete'])
  <a href="javascript:void(0)" title="削除" page_form="dialog" page_title="{{$item->name}}削除" page_url="/{{$domain}}/{{$item->id}}/delete"  class="btn btn-sm btn-danger" role="button">
    <i class="fa fa-trash"></i>
  </a>
  @endif
</div>
