<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="{{ asset('./img/logomini.png') }}">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Admin | Nueva Inglaterra</title>

  <!-- Menu Toggle Script -->
  <script> function toogle(){ var x = document.getElementById("wrapper"); x.classList.toggle("toggled"); } </script>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{ asset('css/simple-sidebar.css') }}" rel="stylesheet">

</head>

<body>
  <div id="app">
    <div class="d-flex" id="wrapper">

      <!-- Sidebar -->
      <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading"> <div class="list-group-item list-group-item-action bg-light"> <img width="25" style="margin-top: -5px; " src="{{ asset('./img/logomini.png') }}" /> <a style="text-decoration: none;" href="{{ asset('./home') }}"> <small style="color: DarkBlue;">Nueva Inglaterra</small></a></div></div>
        <div class="list-group list-group-flush">
          <a class="list-group-item list-group-item-action bg-dark" style="color: white;">CATÁLOGOS</a>
          <a href="{{ asset('./almacenes') }}" class="list-group-item list-group-item-action bg-light">Almacenes</a>
          <a href="{{ asset('./proveedores') }}" class="list-group-item list-group-item-action bg-light">Proveedores</a>
          <a href="{{ asset('./productos') }}" class="list-group-item list-group-item-action bg-light">Productos</a>
          <a href="{{ asset('./compradores') }}" class="list-group-item list-group-item-action bg-light">Compradores</a>
          <a href="{{ asset('./vendedores') }}" class="list-group-item list-group-item-action bg-light">Vendedores</a>
          <a href="{{ asset('./clientes') }}" class="list-group-item list-group-item-action bg-light">Clientes</a>
          <a href="{{ asset('./tipoPagos') }}" class="list-group-item list-group-item-action bg-light">Tipos de Pago</a>
          <a class="list-group-item list-group-item-action bg-dark" style="color: white;">TRANSACCIONES</a>
          <a href="{{ asset('./inventarios') }}" class="list-group-item list-group-item-action bg-light">Inventario</a>
          <a href="{{ asset('./compras') }}" class="list-group-item list-group-item-action bg-light">Compras</a>
          <a href="{{ asset('./comprasdevolucion') }}" class="list-group-item list-group-item-action bg-light">Devoluciones de Compras</a>
          <a href="{{ asset('./pedidos') }}" class="list-group-item list-group-item-action bg-light">Pedidos</a>
          <a href="{{ asset('./ventas') }}" class="list-group-item list-group-item-action bg-light">Ventas</a>
          <a href="{{ asset('./ventasdevolucion') }}" class="list-group-item list-group-item-action bg-light">Devoluciones de Ventas</a>
          <a class="list-group-item list-group-item-action bg-dark" style="color: white;">REPORTERÍA</a>
          <a href="{{ asset('./informes') }}" class="list-group-item list-group-item-action bg-light">Panel de Informes</a>
        </div>
      </div>
      <!-- /#sidebar-wrapper -->

      <!-- Page Content -->
      <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
          <a title='Menu Lateral' style='cursor: pointer;' id="toggleButton" onClick="toogle();">🔁</a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
              <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      {{ Auth::user()->name }} <span class="caret"></span>
                  </a>

                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                          {{ __('Salir') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                  </div>
              </li>
            </ul>
          </div>
        </nav>

        <div class="container-fluid">
          @yield('content')
        </div>
      </div>
      <!-- /#page-content-wrapper -->

    </div>
  </div>
</body>

</html>
