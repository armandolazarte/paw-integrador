<header class="header">
  <label class="header__bar" style="text-align: left">Bienvenido, {{Auth::user()->name}}</label>
  <label class="header__bar"  style="text-align: center">Sistema de Control</label>
  <section class="header__bar">
    <a  href="{{url('logout')}}">
      Salir
    </a>
  </section>

</header>
