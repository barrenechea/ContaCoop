@extends('layouts.app')

@section('htmlheader_title', "Actualizar información")

@section('main-content')

<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Actualizar información <small class="hidden-print">Actualiza lo mostrado en la zona superior de los vouchers.</small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Sistema</li>
                <li><a class="link-effect" href="">Actualizar información</a></li>
            </ol>
        </div>
    </div>
</div>

<div class="content content-narrow">
    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <!-- Form -->
                <form class="form-horizontal" id="formulario" action="{{ url('/update/sysconfig') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="block-content">
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="company_name" name="company_name" value="{{ $config->where('name', 'company_name')->first()->value }}" placeholder="Ingrese nombre de la empresa" required>
                                    <label for="company_name">Nombre de la empresa</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="company_rut" name="company_rut" value="{{ $config->where('name', 'company_rut')->first()->value }}" placeholder="Ingrese RUT de la empresa" required>
                                    <label for="company_rut">RUT de la empresa (con puntos y guión)</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="company_business_field" name="company_business_field" value="{{ $config->where('name', 'company_business_field')->first()->value }}" placeholder="Ingrese rubro de la empresa" required>
                                    <label for="company_business_field">Rubro de la empresa</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="company_address" name="company_address" value="{{ $config->where('name', 'company_address')->first()->value }}" placeholder="Ingrese dirección de la empresa" required>
                                    <label for="company_address">Dirección de la empresa</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="company_legal_representative_name" name="company_legal_representative_name" value="{{ $config->where('name', 'company_legal_representative_name')->first()->value }}" placeholder="Ingrese nombre del representante legal de la empresa" required>
                                    <label for="company_legal_representative_name">Nombre representante legal de la empresa</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="company_legal_representative_rut" name="company_legal_representative_rut" value="{{ $config->where('name', 'company_legal_representative_rut')->first()->value }}" placeholder="Ingrese RUT del representante legal de la empresa" required>
                                    <label for="company_legal_representative_rut">RUT representante legal de la empresa</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="block-content block-content-mini block-content-full border-t">
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                <button class="btn btn-default" id="sendButton" type="submit"><i class="fa fa-check-circle-o"></i> Actualizar</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END Form -->
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('/assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/plugins/select2/select2-bootstrap.min.css') }}">

<script src="{{ asset('/assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/select2/select2.full.min.js') }}"></script>

<script type="text/javascript">
$("#formulario").submit( function (e) {
    $("#sendButton").prop("disabled", true);
});
</script>

@endsection