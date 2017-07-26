<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus" lang="es"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus" lang="es"> <!--<![endif]-->
    @section('htmlheader')
    @include('layouts.partials.htmlheader')
    @show

    <body>
        <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">
        
            @include('layouts.partials.sidebar')

            @include('layouts.partials.mainheader')
            <!-- Main Container -->
            <main id="main-container">
                @if(Session::has('success') || Session::has('warning') || Session::has('danger') || Session::has('info'))
                <div class="row hidden-print">
                    <div class="col-md-12">
                        <div class="text-center alert alert-{{Session::has('success') ? 'success' : ''}}{{Session::has('warning') ? 'warning' : ''}}{{Session::has('danger') ? 'danger' : ''}}{{Session::has('info') ? 'info' : ''}}">
                            {{ Session::get('success') }}{{ Session::get('warning') }}{{ Session::get('danger') }}{{ Session::get('info') }}
                        </div>
                    </div>
                </div>
                @endif
                @if (count($errors) > 0)
                <div class="row hidden-print">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <strong>Se han encontrado los siguientes errores:</strong><br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                @yield('main-content')
            </main>
        </div>
    </body>
</html>