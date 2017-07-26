@extends('layouts.app')

@section('htmlheader_title', "Cuentas bancarias")

@section('main-content')

<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Cuentas bancarias <small class="hidden-print">Visualiza, agrega, modifica o elimina las cuentas bancarias de la empresa.</small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Sistema</li>
                <li><a class="link-effect" href="">Cuentas bancarias</a></li>
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
                            <button class="btn btn-sm btn-default" type="button" onclick="newval()" data-toggle="modal" data-target="#modal-edit"><i class="fa fa-plus"></i> Nuevo Banco</button>
                            <a href="{{ url('/excel/banks') }}" class="btn btn-sm btn-default" data-toggle="tooltip" data-original-title="Se exportarán todas las cuentas bancarias de la empresa"><i class="fa fa-file-excel-o"></i> Exportar todo como Excel</a>
                        </div>
                        <div class="col-xs-4 col-xs-offset-2">
                            <form class="form-horizontal" action="{{ url('/list/banks') }}" method="get">
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
                                <th>Banco</th>
                                <th>Cuenta Corriente</th>
                                <th>Cuenta Contable</th>
                                <th class="text-center hidden-print" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banks as $bank)
                                <tr>
                                    <td>{{ $bank->name }}</td>
                                    <td>{{ $bank->checking_account }}</td>
                                    <td>
                                    @if($bank->account)
                                        <a href="{{ url('/list/accounts?find=' . $bank->account->codigo ) }}"> {{ $bank->account->codigo }} - {{ $bank->account->nombre }}</a>
                                    @else
                                        <i>No posee / no vinculada</i>
                                    @endif
                                    </td>
                                    <td class="text-center hidden-print">
                                        <div class="btn-group">
                                            <span data-toggle="modal" data-target="#modal-edit">
                                                <button class="btn btn-xs btn-default" type="button" value="{{ $bank->id }}" onclick="modifyval(this.value)"  data-toggle="tooltip" title="" data-original-title="Editar"><i class="fa fa-pencil"></i></button>
                                            </span>
                                            <span data-toggle="modal" data-target="#modal-delete">
                                                <button class="btn btn-xs btn-default" type="button" value="{{ $bank->id }}" onclick="deleteval(this.value)" data-toggle="tooltip" title="" data-original-title="Eliminar"><i class="fa fa-times"></i></button>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(method_exists($banks, 'links'))
                    <div class="hidden-print"> 
                        {{ $banks->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.partials.modals.banks.createupdate')

@include('layouts.partials.modals.banks.delete')

@endsection