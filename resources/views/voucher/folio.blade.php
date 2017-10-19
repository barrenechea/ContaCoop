@extends('layouts.app')

@section('htmlheader_title', 'Foliación')

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
            </ul>
        </div>
        @for ($i = $start; $i <= $finish; $i++)
        <div class="block-content block-content-narrow">
            <div class="row">
                <div class="col-xs-10" style="font-size: xx-small;">
                    <b>{{ \App\Config::where('name', 'company_name')->first()->value }}</b><br>
                    <b>RUT </b> {{ \App\Config::where('name', 'company_rut')->first()->value }}<br>
                    <b>GIRO</b> {{ \App\Config::where('name', 'company_business_field')->first()->value }}<br>
                    <b>DIR.</b> {{ \App\Config::where('name', 'company_address')->first()->value }}<br>
                    <b>REP.</b> {{ \App\Config::where('name', 'company_legal_representative_name')->first()->value }}, RUT {{ \App\Config::where('name', 'company_legal_representative_rut')->first()->value }}<br>
                </div>
                <div class="col-xs-1" style="font-size: xx-small;">
                    <b>Folio. </b>
                </div>
                <div class="col-xs-1" style="font-size: xx-small;">
                    {{ $i }}
                </div>
            </div>
        </div>
        @if($i != $finish)
        <div class="pagebreak"></div>
        @endif
        @endfor
    </div>
</div>

@endsection