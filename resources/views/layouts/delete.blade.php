<div class="container">
  <form method="POST" action="/{{$domain}}/{{$id}}/delete">
    @csrf
    <input type="hidden" name="{{$target_name}}" value="{{$target_id}}">
    <div class="row">
      <div class="col-3 text-left">
        <input type="submit" class="btn btn-primary" value="削除する">
      </div>
    </div>
  </form>
</div>
