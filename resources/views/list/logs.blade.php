@extends('layouts.app')

@section('htmlheader_title', "Registro de actividad")

@section('main-content')

<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Registro de actividad <small class="hidden-print">Monitoreo de las acciones en el sistema contable.</small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Sistema</li>
                <li><a class="link-effect" href="">Registro de actividad</a></li>
            </ol>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-content">
                    <div class="hidden-print">
                        <div class="col-xs-4 col-xs-offset-8">
                            <form class="form-horizontal" action="{{ url('/view/logs') }}" method="get">
                                <div class="form-material form-material-primary input-group remove-margin-t remove-margin-b">
                                    <input class="form-control" type="text" id="find" name="find" placeholder="Buscar..." value="{{ $find }}">
                                    <span class="input-group-addon"><i class="si si-magnifier"></i></span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">Cuenta</th>
                                <th class="text-center" style="width: 300px;">Nombre</th>
                                <th>Acción</th>
                                <th class="text-center" style="width: 200px;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td class="text-center">{{ $log->user->username }}</td>
                                    <td class="text-center">{{ $log->user->name }}</td>
                                    <td>{{ $log->message }}</td>
                                    <td class="text-center">{{ $log->created_at->format('d-m-Y H:i') }}hrs.</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(method_exists($logs, 'links'))
                    <div class="hidden-print"> 
                        {{ $logs->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection