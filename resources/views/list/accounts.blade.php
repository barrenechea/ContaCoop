@extends('layouts.app')

@section('htmlheader_title', "Plan de cuentas")

@section('main-content')

<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Plan de cuentas <small class="hidden-print">Visualiza, agrega o modifica las cuentas contables de la empresa.</small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Sistema</li>
                <li><a class="link-effect" href="">Plan de cuentas</a></li>
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
                        <div class="col-xs-6">
                            <button class="btn btn-sm btn-default" type="button" onclick="newval()" data-toggle="modal" data-target="#modal-edit"><i class="fa fa-plus"></i> Nueva cuenta</button>
                            <a href="{{ url('/excel/accounts') }}" class="btn btn-sm btn-default" data-toggle="tooltip" data-original-title="Se exportará todo el plan de cuentas de la empresa"><i class="fa fa-file-excel-o"></i> Exportar todo como Excel</a>
                        </div>
                        <div class="col-xs-4 col-xs-offset-2">
                            <form class="form-horizontal" action="{{ url('/list/accounts') }}" method="get">
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
                                <th class="text-center" style="width: 50px;">Clas.</th>
                                <th class="text-center" style="width: 50px;">Nivel</th>
                                <th class="text-center" style="width: 120px;">Código</th>
                                <th>Nombre</th>
                                <th class="text-center" style="width: 50px;">C.C.</th>
                                <th class="text-center" style="width: 50px;">RUT</th>
                                <th class="text-center" style="width: 50px;">Flujo</th>
                                <th class="text-center" style="width: 50px;">Patrimonio</th>
                                <th class="text-center hidden-print" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $account)
                                <tr>
                                    <td class="text-center">{{ $account->clase }}</td>
                                    <td class="text-center">{{ $account->nivel }}</td>
                                    <td class="text-center">
                                    @if($account->nivel != 1)
                                    @for($i = 1; $i < $account->nivel; $i++)
                                    &nbsp;&nbsp;
                                    @endfor
                                    @endif
                                    {{ $account->codigo }}
                                    </td>
                                    @if($account->nivel === 4)
                                    <td style="font-weight: bold;">{{ $account->nombre }}</td>
                                    @else
                                    <td>{{ $account->nombre }}</td>
                                    @endif
                                    <td class="text-center">{{ $account->ctacte }}</td>
                                    <td class="text-center">{{ $account->ctacte2 }}</td>
                                    <td class="text-center">{{ $account->ctacte3 }}</td>
                                    <td class="text-center">{{ $account->ctacte4 }}</td>
                                    <td class="text-center hidden-print">
                                        @if($account->nivel == 4)
                                            <div class="btn-group">
                                                <span data-toggle="modal" data-target="#modal-edit">
                                                    <button class="btn btn-xs btn-default" type="button" value="{{ $account->id }}" onclick="modifyval(this.value)"  data-toggle="tooltip" title="" data-original-title="Editar"><i class="fa fa-pencil"></i></button>
                                                </span>
                                                <span data-toggle="modal" data-target="#modal-delete">
                                                    <button class="btn btn-xs btn-default" type="button" value="{{ $account->id }}" onclick="deleteval(this.value)" data-toggle="tooltip" title="" data-original-title="Eliminar"><i class="fa fa-times"></i></button>
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(method_exists($accounts, 'links'))
                    <div class="hidden-print"> 
                        {{ $accounts->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.partials.modals.accounts.createupdate')

@include('layouts.partials.modals.accounts.delete')

@endsection