<div class="row">
  <div class="col-4">
    <label>プロジェクト選択</label>
    <select name="project_id" class="form-control">
      @foreach( $projects as $project)
        <option value="{{$project->id}}">{{$project->name}}</option>
      @endforeach
    </select>
  </div>
</div>
