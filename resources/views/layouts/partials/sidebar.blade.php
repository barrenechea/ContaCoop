<nav id="sidebar">
    <div id="sidebar-scroll">
        <div class="sidebar-content">
            <div class="side-header side-content bg-white-op">
                <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times"></i>
                </button>
                <span class="h4 text-white font-w600 sidebar-mini-hide">ContaCoop</span>
            </div>
            <div class="side-content">
                <ul class="nav-main">
                    <li>
                        <a class="{{ Request::is('home') ? 'active' : '' }}" href="{{ url('home') }}"><i class="si si-speedometer"></i><span class="sidebar-mini-hide">Inicio</span></a>
                    </li>
                    @can('add_voucher')
                    <li class="nav-main-heading"><span class="sidebar-mini-hide">Generar Voucher</span></li>
                    <li>
                        <a class="{{ Request::is('new/voucher/income') ? 'active' : '' }}" href="{{ url('/new/voucher/income') }}"><i class="si si-arrow-down"></i><span class="sidebar-mini-hide">Ingreso</span></a>
                    </li>
                    <li>
                        <a class="{{ Request::is('new/voucher/outcome') ? 'active' : '' }}" href="{{ url('/new/voucher/outcome') }}"><i class="si si-arrow-up"></i><span class="sidebar-mini-hide">Egreso</span></a>
                    </li>
                    <li>
                        <a class="{{ Request::is('new/voucher/transfer') ? 'active' : '' }}" href="{{ url('/new/voucher/transfer') }}"><i class="si si-reload"></i><span class="sidebar-mini-hide">Traspaso</span></a>
                    </li>
                    @endcan
                    @can('sync_voucher')
                    <li class="nav-main-heading"><span class="sidebar-mini-hide">Sincronizar</span></li>
                    <li>
                        <a class="{{ Request::is('sync/index') ? 'active' : '' }}" href="{{ url('/sync/index') }}"><i class="si si-share"></i><span class="sidebar-mini-hide">Sincronizar @if($var = \App\Voucher::where('wants_sync', true)->where('synced', false)->count())<span class="badge badge-warning">{{ $var }}</span>@endif</span></a>
                    </li>
                    @endcan
                    @can('view_voucher')
                    <li class="nav-main-heading"><span class="sidebar-mini-hide">Obtener Voucher</span></li>
                    <li>
                        <a class="{{ Request::is('view/voucher/*') ? 'active' : '' }}" href="" data-toggle="modal" data-target="#modal-findvoucher"><i class="si si-magnifier"></i><span class="sidebar-mini-hide">Por código</span></a>
                    </li>
                    @endcan
                    @can('view_reports')
                    <li class="nav-main-heading"><span class="sidebar-mini-hide">Reportería</span></li>
                    <li>
                        <a class="{{ Request::is('report/logbook') ? 'active' : '' }}" href="" data-toggle="modal" data-target="#modal-logbook"><i class="si si-book-open"></i><span class="sidebar-mini-hide">Libro diario</span></a>
                        <!-- <a class="{{ Request::is('report/generalledger') ? 'active' : '' }}" href="{{ url('/report/generalledger') }}"><i class="si si-notebook"></i><span class="sidebar-mini-hide">Libro mayor</span></a> -->
                    </li>
                    @endcan
                    @can('manage_app')
                    <li class="nav-main-heading"><span class="sidebar-mini-hide">Administración</span></li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-layers"></i><span class="sidebar-mini-hide">Sistema</span></a>
                        <ul>
                            <li>
                                <a class="{{ Request::is('list/accounts') ? 'active' : '' }}" href="{{ url('/list/accounts') }}">Plan de cuentas</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('list/banks') ? 'active' : '' }}" href="{{ url('/list/banks') }}">Cuentas bancarias</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('list/identifications') ? 'active' : '' }}" href="{{ url('/list/identifications') }}">Administrar RUT's</a>
                            </li>
                            <li>
                                <a class="{{ Request::is('update/sysconfig') ? 'active' : '' }}" href="{{ url('/update/sysconfig') }}">Actualizar información</a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>
</nav>

@include('layouts.partials.modals.findvoucher')

@include('layouts.partials.modals.reports.logbook')