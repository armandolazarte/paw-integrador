<nav class="sidenav">
    <a href="{{url('home')}}" class="sidenav__logo">
        <img src="{{asset('logo.png')}}"></img>
    </a>
    <ul class="sidenav__list">
        @can('articles')
            <li class="sidenav__list-item menu">
                <a href="#" class="dropdown">
                    <i class="fa fa-tags icon-menu"></i>
                    <span class="title">Artículos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right icon-nav"></i>
                    </span>
                </a>
                <ul class="submenu">
                    @can('categories')
                        <li>
                            <a href="{{url('almacen/categoria')}}">Categorías de Artículos</a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{url('almacen/articulo')}}">Listado de Artículos</a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('purchases')
            <li class="sidenav__list-item">
                <a href="#" class="dropdown">
                    <i class="fa fa-money icon-menu"></i>
                    <span class="title">Entradas</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right icon-nav"></i>
                    </span>
                </a>
                <ul class="submenu">
                    @can('incomes')
                        <li>
                            <a href="{{url('compras/ingreso')}}">Ingresos</a>
                        </li>
                    @endcan
                    @can('providers')
                        <li>
                            <a href="{{url('compras/proveedor')}}">Proveedores</a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('sales')
            <li class="sidenav__list-item">
                <a href="{{url('ventas/venta')}}">
                    <i class="fa fa-shopping-cart icon-menu"></i>
                    <span class="title">Ventas</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right icon-nav"></i>
                    </span>
                </a>
            </li>
        @endcan
        @can('clients')
            <li class="sidenav__list-item">
                <a href="#" class="dropdown">
                    <i class="fa fa-user icon-menu"></i>
                    <span class="title">Clientes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right icon-nav"></i>
                    </span>
                </a>
                <ul class="submenu">
                    @can('clientsCategories')
                        <li>
                            <a href="{{url('categoria_persona')}}">Categorias de Clientes</a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{url('ventas/cliente')}}">Listado de Clientes</a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('users')
            <li class="sidenav__list-item">
                <a href="{{url('seguridad/usuario')}}">
                    <i class="fa fa-users icon-menu"></i>
                    <span class="title">Usuarios</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right icon-nav"></i>
                    </span>
                </a>
            </li>
        @endcan
    </ul>
</nav>
