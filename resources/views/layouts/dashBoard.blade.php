@include('layouts.start')
@include('layouts.end')
@include('layouts.modal')

@yield('start')

<body class="sidebar-mini">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand-md navbar-white navbar-light">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="/logout">ログアウト</a>
        </li>
      </ul>
    </nav>
    <aside id="side-bar" class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="side-bar" >
        @component('layouts.menu',$list_param)
        @endcomponent
      </div>
    </aside>
    <div class="content-wrapper">
      <div class="content">
        <div class="row">
          <div class="col-12">
             <section class="content-max-width">
               @component('layouts.components.list',$list_param)
               @endcomponent
             </section>
          </div>
        </div>
      </div>
    </div>
  </div>
@yield('modal')
@yield('end')
