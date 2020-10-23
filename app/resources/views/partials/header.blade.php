<header class="header">
  <section class="header__bar" id="header-user" style="text-align: left">Bienvenido, {{Auth::user()->name}}</section>
  <section class="header__bar"  id="header-title" style="text-align: center">StockControl</section>
  <section class="header__bar"  id="header-notification">
    <div id="notification-button">
      <i class="fa fa-bell" aria-hidden="true"></i>
      <span class="badge" id="notification-counter">0</span>
    </div>
    <ul id="notification-list" class="submenu">

    </ul>
    
  </section>
  <section class="header__bar" id="header-sign-out">
    <a  href="{{url('logout')}}">
      <i class="fa fa-sign-out" aria-hidden="true"></i>
    </a>
  </section>

</header>
