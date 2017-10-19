@extends('layouts.app')

@section('htmlheader_title', 'Voucher')

@section('main-content')
<style type="text/css">
    .pagebreak { page-break-before: always; }
</style>
<div class="content content-boxed">
    <div class="block">
        <div class="block-header hidden-print">
            <ul class="block-options">
                <li>
                    <button type="button" onclick="App.initHelper('print-page');"><i class="si si-printer"></i> Imprimir</button>
                </li>
                @can('modify_voucher')
                <li>
                    <button type="button" onclick="#"><i class="fa fa-pencil"></i> Editar</button>
                </li>
                @endcan
                @can('delete_voucher')
                <li>
                    <button type="button" onclick="swalDelete();"><i class="fa fa-close"></i> Eliminar</button>
                </li>
                @endcan
            </ul>
        </div>
        <div class="block-content block-content-narrow">
            <div class="row">
                <div class="col-xs-12" style="font-size: xx-small;">
                        <b>{{ \App\Config::where('name', 'company_name')->first()->value }}</b><br>
                        <b>RUT </b> {{ \App\Config::where('name', 'company_rut')->first()->value }}<br>
                        <b>GIRO</b> {{ \App\Config::where('name', 'company_business_field')->first()->value }}<br>
                        <b>DIR.</b> {{ \App\Config::where('name', 'company_address')->first()->value }}<br>
                        <b>REP.</b> {{ \App\Config::where('name', 'company_legal_representative_name')->first()->value }}, RUT {{ \App\Config::where('name', 'company_legal_representative_rut')->first()->value }}<br>
                </div>
                <div class="col-xs-12">
                    <div class="h4 text-center push-30-t push-30">COMPROBANTE CONTABLE</div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-4">
                    <div class="h5" style="font-size: small">
                        @if( $voucher->type == 'I' )
                        <b>TIPO: </b> Ingreso<br>
                        @elseif ( $voucher->type == 'E' )
                        <b>TIPO: </b> Egreso<br>
                        @elseif ( $voucher->type == 'T' )
                        <b>TIPO: </b> Traspaso<br>
                        @endif
                        <b>Nº: </b> {{ $voucher->sequence }}-{{ $voucher->date->year }}<br>
                        <b>GLOSA:</b> {{ $voucher->description }}<br>
                    </div>
                </div>

                <div class="col-xs-5">
                    <div class="h5" style="font-size: small">
                        <b>FECHA: </b> {{ $voucher->date->format('d-m-Y') }}<br>
                        <b>BEN/REF: </b> @if( $voucher->bank ){{ $voucher->beneficiary }} @endif<br>
                        <b>CHEQUE: </b> @if( $voucher->bank ){{ $voucher->check_number }} @endif<br>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="h5" style="font-size: small">
                        <b>BANCO: </b> @if( $voucher->bank ){{ $voucher->bank->name }} @endif<br>
                        <b>C.C: </b> @if( $voucher->bank ){{ $voucher->bank->checking_account }} @endif<br>
                        <b>FECHA CH.: </b> @if( $voucher->bank ){{ $voucher->check_date->format('d-m-Y') }} @endif<br>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <table class="table table-condensed table-bordered" style="font-size: xx-small;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px; font-size: x-small;">Cuenta</th>
                            <th class="text-center" style="width: 100px; font-size: x-small;">Nom. Cuenta</th>
                            <th class="text-center" style="width: 70px; font-size: x-small;">RUT</th>
                            <th class="text-center" style="width: 100px; font-size: x-small;">Nombre</th>
                            <th class="text-center" style="width: 100px; font-size: x-small;">Detalle</th>
                            <th class="text-center" style="width: 70px; font-size: x-small;">Doc.</th>
                            <th class="text-center" style="width: 60px; font-size: x-small;">Fecha</th>
                            <th class="text-center" style="width: 70px; font-size: x-small;">Debe</th>
                            <th class="text-center" style="width: 70px; font-size: x-small;">Haber</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($voucher->voucherdetails()->get() as $voucherdetail)
                        <tr>
                            <td>{{ $voucherdetail->account->codigo }}</td>
                            <td>{{ $voucherdetail->account->nombre }}</td>
                            <td>@if($voucherdetail->identification){{ $voucherdetail->identification->rut }}@endif</td>
                            <td>@if($voucherdetail->identification){{ $voucherdetail->identification->name }}@endif</td>
                            <td>{{ $voucherdetail->detail }}</td>
                            <td>@if($voucherdetail->doctype) {{ $voucherdetail->doctype->code . ' ' }}@endif{{ $voucherdetail->doc_number }}</td>
                            <td>{{ $voucherdetail->date->format('d-m-Y') }}</td>
                            <td class="text-right">{{ number_format($voucherdetail->debit, 2, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($voucherdetail->credit, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="7" class="font-w700 text-uppercase text-right">Totales</td>
                            <td class="font-w700 text-right">$ {{ number_format($voucher->voucherdetails()->sum('debit'), 2, ',', '.') }}</td>
                            <td class="font-w700 text-right">$ {{ number_format($voucher->voucherdetails()->sum('credit'), 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="col-xs-8 col-xs-offset-2" style="margin-top: 50px;">
                        <table class="table table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td class="text-center" style="width: 33%; font-size: small;"><b>CERTIFICACIÓN EMPRESA</b></td>
                                </tr>
                                <tr>
                                    <td><br><br><br><br></td>
                                </tr>
                                @if( $voucher->type == 'E' )
                                <tr>
                                    <td class="text-center" style="width: 33%; font-size: small;"><b>FIRMA 1ª REVISIÓN</b></td>
                                </tr>
                                <tr>
                                    <td><br><br><br><br></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if( $voucher->type == 'E' )
                <div class="col-xs-6" style="margin-top: 100px;">
                    <div class="col-xs-9 col-xs-offset-2">
                        <hr style="border-color: black;">
                        <p class="text-uppercase text-center" style="font-size: small;"><b>Recibí conforme</b></p>
                    </div>
                    <div class="col-xs-2">
                        <p class="text-uppercase text-right" style="font-size: small;"><b>Nombre:</b></p>
                    </div>
                    <div class="col-xs-9">
                        <hr style="border-color: black;">
                    </div>
                    <div class="col-xs-2">
                        <p class="text-uppercase text-right" style="font-size: small;"><b>C.I. :</b></p>
                    </div>
                    <div class="col-xs-9">
                        <hr style="border-color: black;">
                    </div>
                </div>
                @endif
            </div>
            @if($voucher->img)
            <div class="pagebreak"></div>
            
            <div class="row">
                <div class="col-xs-12">
                    <br/>
                    <div class="h4 text-center push-30-t push-30">IMAGEN ADJUNTA</div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <img style="max-width: 100%" src="/uploads/imgs/{{ $voucher->img }}" alt="Imagen adjunta" />
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.min.js"></script>
<script>
function swalDelete () {
    swal({
        title: 'Confirmación',
        text: "¿Confirma la eliminación del voucher?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar',
        cancelButtonText: 'No'
        }).then(function () {
            swal({
                allowOutsideClick: false,
                onOpen: function () {
                    swal.showLoading()
                }
            });
            $(location).attr('href','{{ url("/delete/voucher") }}/{{ $voucher->id }}');
    });
}
</script>
@endsection