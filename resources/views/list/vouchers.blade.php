@extends('layouts.app')

@section('htmlheader_title', "Listado de vouchers")

@section('main-content')

<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Listado de vouchers <small class="hidden-print">Visualiza todos los vouchers en sistema.</small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Listar</li>
                <li><a class="link-effect" href="">Vouchers</a></li>
            </ol>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-content">
                    <div class="hidden hidden-print">
                        <div class="col-xs-4 col-xs-offset-8">
                            <form class="form-horizontal" action="{{ url('/list/vouchers') }}" method="get">
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
                                <th class="text-center" style="width: 50px;">Tipo</th>
                                <th class="text-center" style="width: 120px;">Código</th>
                                <th class="text-center">Glosa</th>
                                <th class="text-center" style="width: 200px;">Fecha</th>
                                <th class="text-center hidden-print" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vouchers as $voucher)
                                <tr>
                                    <td class="text-center">
                                    @if( $voucher->type == 'I' )
                                        Ingreso
                                    @elseif ( $voucher->type == 'E' )
                                        Egreso
                                    @elseif ( $voucher->type == 'T' )
                                        Traspaso
                                    @endif</td>
                                    <td class="text-center">{{ $voucher->sequence }}-{{ $voucher->date->year }}</td>
                                    <td class="text-center">{{ $voucher->description }}</td>
                                    <td class="text-center">{{ $voucher->date->format('d-m-Y') }}</td>
                                    <td class="text-center hidden-print">
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-default" href="{{ url('/view/voucher') . '/' . $voucher->type . '/' . $voucher->sequence . '-' . $voucher->date->year }}" data-toggle="tooltip" title="" data-original-title="Ver voucher"><i class="fa fa-arrow-right"></i></a>                                    
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(method_exists($vouchers, 'links'))
                    <div class="hidden-print"> 
                        {{ $vouchers->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection