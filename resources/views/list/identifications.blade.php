@extends('layouts.app')

@section('htmlheader_title', "Administrar RUT's")

@section('main-content')

<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Administrar RUT's <small class="hidden-print">Agrega, modifica o elimina RUT's involucrados en la creación de Vouchers.</small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Sistema</li>
                <li><a class="link-effect" href="">Administrar RUT's</a></li>
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
                            <button class="btn btn-sm btn-default" type="button" onclick="newval()" data-toggle="modal" data-target="#modal-edit"><i class="fa fa-plus"></i> Nuevo RUT</button>
                            <a href="{{ url('/excel/identifications') }}" class="btn btn-sm btn-default" data-toggle="tooltip" data-original-title="Se exportarán todos los RUT's registrados en el sistema"><i class="fa fa-file-excel-o"></i> Exportar todo como Excel</a>
                        </div>
                        <div class="col-xs-4 col-xs-offset-2">
                            <form class="form-horizontal" action="{{ url('/list/identifications') }}" method="get">
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
                                <th style="width: 200px;">RUT</th>
                                <th>Nombre</th>
                                <th class="text-center hidden-print" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($identifications as $identification)
                                <tr>
                                    <td>
                                    {{ $identification->rut }}
                                    </td>
                                    <td>{{ $identification->name }}</td>
                                    <td class="text-center hidden-print">
                                        <div class="btn-group">
                                            <span data-toggle="modal" data-target="#modal-edit">
                                                <button class="btn btn-xs btn-default" type="button" value=" {{ $identification->id }}" onclick="modifyval(this.value)" data-toggle="tooltip" title="" data-original-title="Editar"><i class="fa fa-pencil"></i></button>
                                            </span>
                                            
                                            <span data-toggle="modal" data-target="#modal-delete">
                                                <button class="btn btn-xs btn-default" type="button" value="{{ $identification->id }}" onclick="deleteval(this.value)" data-toggle="tooltip" title="" data-original-title="Eliminar"><i class="fa fa-times"></i></button>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(method_exists($identifications, 'links'))
                    <div class="hidden-print"> 
                        {{ $identifications->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.partials.modals.identifications.createupdate')

@include('layouts.partials.modals.identifications.delete')

@endsection