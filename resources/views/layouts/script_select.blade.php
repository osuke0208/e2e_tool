<div class="row">
  <div class="col-4">
    <label>スクリプト選択</label>
    <select name="scenario_script_id" class="form-control">
      @foreach( $scenario_scripts as $scenario_script)
        <option value="{{$scenario_script->id}}">{{$scenario_script->name}}</option>
      @endforeach
    </select>
  </div>
</div>
