@include('layouts.start')
@include('layouts.end')


@yield('start')

<body class='sidebar-mini'>
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand-md navbar-white navbar-light">
      <ul class="navbar-nav ml-auto ">
        <li class="nav-item">
          <a href="/logout">ログアウト</a>
        </li>
      </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="side-bar" >
        <a href="/home" class="brand-link">
          <span class="brand-text font-weight-light">
            E2Eテスト管理
          </span>
        </a>
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" dat-widget="treeview" role="menu" >
            <li class="nav-item">
              <a class="nav-link" href="/scenario/{{$id}}">テストシナリオ管理</a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
             @yield('content_header')
        </div>
      </div>
      <div class="content">
        <div class="row">
          <div class="col-lg-12">
             <section class="content-max-width">
               @yield('content')
             </section>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

@yield('end')
