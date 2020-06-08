<a href="/home" class="brand-link">
  <span class="brand-text font-weight-light">
    E2Eテスト管理
  </span>
</a>
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
    <li class="nav-item">
      <a href="javascript:void(0)" title="{{$domain}}追加" page_form="dialog" page_title="{{$domain_name}}追加" page_url="/{{$domain}}/create"  class="nav-link" role="button">
        <i class="fa fa-plus"></i>
        {{$domain_name}}追加
      </a>
    </li>
    <li class="nav-item has-treeview menu-open">
      <a href="#" class="nav-link">
        <i class="nav-icon fa fa-list mr-1"></i>
        <p>
          一覧
          <i class="fa fa-angle-left ml-2"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="/organisations"  class="nav-link">
            <i class="fa fa-circle mr-1"></i>
            組織
          </a>
        </li>
        <li class="nav-item" >
          <a href="/projects"  class="nav-link">
            <i class="fa fa-circle mr-1"></i>
            プロジェクト
          </a>
        </li>
        <li class="nav-item">
          <a href="/scenario_groups" class="nav-link">
            <i class="fa fa-circle mr-1"></i>
            シナリオグループ
          </a>
        </li>
        <li class="nav-item">
          <a href="/scenarios" class="nav-link">
            <i class="fa fa-circle mr-1"></i>
            シナリオ
          </a>
        </li>
        <li class="nav-item">
          <a href="/scenario_parameters" class="nav-link">
            <i class="fa fa-circle mr-1"></i>
            シナリオパラメータ
          </a>
        </li>
        <li class="nav-item">
          <a href="/scenario_scripts" class="nav-link">
            <i class="fa fa-circle mr-1"></i>
            シナリオスクリプト
          </a>
        </li>
      </ul>
    </li>
  </ul>
</nav>
