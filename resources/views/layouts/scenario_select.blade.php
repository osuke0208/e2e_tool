<div class="row">
  <div class="col-4">
    <label>シナリオ選択</label>
    <select name="scenario_id" class="form-control">
      @foreach( $scenarios as $scenario)
        <option value="{{$scenario->id}}">{{$scenario->name}}</option>
      @endforeach
    </select>
  </div>
</div>
