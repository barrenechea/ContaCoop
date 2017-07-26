@extends('layouts.app')

@section('htmlheader_title', 'Inicio')

@section('main-content')
    <!-- Page Header -->
    <div class="overflow-hidden">
        <div class="bg-black-op" style="background-color: #646464">
            <div class="content content-narrow">
                <div class="block block-transparent">
                    <div class="block-content block-content-full">
                        <h1 class="h1 font-w300 text-white animated fadeInDown push-5">Inicio</h1>
                        <h2 class="h4 font-w300 text-white-op animated fadeInUp">Bienvenido(a), {{ Auth::user()->name }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Header -->
    <!-- Page Content -->
    <div class="content content-narrow">
        <!-- Dashboard Cards -->
        <div class="row">
            <div class="col-lg-6">
                <a href="#" data-toggle="modal" data-target="#modal-createvoucher">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full bg-default text-center">
                            <div class="push-10-t push-10">
                                <i class="fa fa-4x si si-arrow-down text-white-op push-10"></i>
                                <h3 class="h4 text-white">Generar voucher</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6">
                <a href="" data-toggle="modal" data-target="#modal-findvoucher">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full bg-default text-center" style="background-color: #444">
                            <div class="push-10-t push-10">
                                <i class="fa fa-4x si si-magnifier text-white-op push-10"></i>
                                <h3 class="h4 text-white">Obtener voucher</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Dashboard Cards -->
    </div>
    <!-- END Page Content -->

    <!-- Modals -->
    <div class="modal fade" id="modal-createvoucher" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-popin">
    <div class="modal-content">
    <div class="block block-themed block-transparent remove-margin-b">
    <div class="block-header bg-primary-dark">
    <ul class="block-options">
    <li>
    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
    </li>
    </ul>
    <h3 class="block-title">Generar voucher</h3>
    </div>
    <div class="block-content">
    <p>Favor seleccione el tipo de voucher que desea generar:</p>
    </div>
    </div>
    <div class="modal-footer">
    <a href="{{ url('/new/voucher/income') }}" class="btn btn-sm btn-default">Ingreso</a>
    <a href="{{ url('/new/voucher/outcome') }}" class="btn btn-sm btn-default">Egreso</a>
    <a href="{{ url('/new/voucher/transfer') }}" class="btn btn-sm btn-default">Traspaso</a>
    </div>
    </div>
    </div>
    </div>
    <!-- END Page Container -->
@endsection