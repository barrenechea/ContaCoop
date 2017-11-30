@extends('layouts.app')

@section('htmlheader_title', "Editar Voucher Ingreso")

@section('main-content')

<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Editar Voucher - Ingreso <small class="hidden-print">Edita un voucher de ingreso monetario.</small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Editar Voucher</li>
                <li><a class="link-effect" href="">Ingreso</a></li>
            </ol>
        </div>
    </div>
</div>

<div class="content content-narrow">
    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <!-- Form -->
                <form class="form-horizontal" id="formulario" action="{{ url('/update/voucher/income') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="voucher_id" value="{{ $voucher->id }}">
                    <input type="hidden" name="lines" value="{{ $lines }}">
                    <div class="block-content">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <div class="form-material">
                                    <label class="css-input switch switch-sm switch-default">
                                    <input type="checkbox" id="auto_correl" name="auto_correl" checked="" disabled=""><span></span> Correlativo Automático
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-material">
                                    <input class="form-control" type="number" id="correl" name="correl" placeholder="Ingrese correlativo" disabled="" required="">
                                    <label for="correl">Correlativo</label>
                                </div>
                            </div>
                            <div class="col-sm-3 col-sm-offset-3">
                                <div class="form-material">
                                    <label class="css-input switch switch-sm switch-default">
                                    <input type="checkbox" id="sync" name="sync" {{ $voucher->wants_sync ? "checked" : "" }}><span></span> Sincronizar voucher
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <div class="form-material">
                                    <input class="js-datepicker form-control" type="text" id="date" name="date" data-date-format="dd-mm-yyyy" placeholder="Ingrese fecha, formato dd-mm-aaaa" required="">
                                    <label for="date">Fecha</label>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="description" name="description" placeholder="Ingrese glosa de voucher" required="" value="{{ $voucher->description }}">
                                    <label for="description">Glosa</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="block-content border-t">
                        <div class="form-group">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Cuenta contable</th>
                                        <th>RUT</th>
                                        <th>Nombre</th>
                                        <th>Detalle</th>
                                        <th>Tipo Doc.</th>
                                        <th>Nº Doc.</th>
                                        <th>Fecha</th>
                                        <th>Debe</th>
                                        <th>Haber</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 1; $i <= $lines; $i++)
                                    <tr>
                                        <td>
                                            <div class="form-material">
                                                <select class="form-control" id="account{{ $i }}" name="account{{ $i }}" style="width: 100%" placeholder="Cuenta contable">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material">
                                                <input class="form-control" type="text" id="rut{{ $i }}" name="rut{{ $i }}" placeholder="RUT" disabled="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material">
                                                <select class="form-control" id="nombre{{ $i }}" name="nombre{{ $i }}" style="width: 100%" placeholder="Nombre" disabled="">
                                                    <option></option>
                                                </select>
                                                <input type="hidden" id="string_nombre{{ $i }}" name="string_nombre{{ $i }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material">
                                                <input class="form-control" type="text" id="detalle{{ $i }}" name="detalle{{ $i }}" placeholder="Detalle" value="{{ isset($voucher->voucherdetails[$i - 1]) && isset($voucher->voucherdetails[$i - 1]->detail) ? $voucher->voucherdetails[$i - 1]->detail : '' }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material">
                                                <select class="form-control" id="doctype_id{{ $i }}" name="doctype_id{{ $i }}" style="width: 100%" placeholder="Tipo Doc.">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material">
                                                <input class="form-control" type="text" id="doc_number{{ $i }}" name="doc_number{{ $i }}" placeholder="Nº Doc." value="{{ isset($voucher->voucherdetails[$i - 1]) && isset($voucher->voucherdetails[$i - 1]->doc_number) ? $voucher->voucherdetails[$i - 1]->doc_number : '' }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material">
                                                <input class="js-datepicker form-control" type="text" id="fecha{{ $i }}" name="fecha{{ $i }}" data-date-format="dd-mm-yyyy" placeholder="Fecha" required="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material input-group">
                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                <input class="form-control" type="number" onClick="this.select();" id="debe{{ $i }}" name="debe{{ $i }}" placeholder="..." value="{{ isset($voucher->voucherdetails[$i - 1]) ? $voucher->voucherdetails[$i - 1]->debit : 0 }}" min="0">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material input-group">
                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                <input class="form-control" type="number" onClick="this.select();" id="haber{{ $i }}" name="haber{{ $i }}" placeholder="..." value="{{ isset($voucher->voucherdetails[$i - 1]) ? $voucher->voucherdetails[$i - 1]->credit : 0 }}" min="0">
                                            </div>
                                        </td>
                                    </tr>
                                    @endfor

                                    <tr>
                                        <td colspan="7" class="text-right">
                                            Totales
                                        </td>
                                        <td>
                                            <div class="form-material input-group">
                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                <input class="form-control" type="number" id="totaldebe" name="totaldebe"  placeholder="..." value="0" disabled="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material input-group">
                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                <input class="form-control" type="number" id="totalhaber" name="totalhaber"  placeholder="..." value="0" disabled="">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="block-content border-t">
                        <div class="form-group">
                            <label class="col-xs-12" for="voucher-img1">Adjuntar imagen (opcional)</label>
                            <div class="col-xs-12">
                                <input type="file" id="img" name="img" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="block-content block-content-mini block-content-full border-t">
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                <button class="btn btn-default" id="sendButton" type="submit"><i class="fa fa-check-circle-o"></i> Guardar cambios</button>
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
var $lines = {{ $lines }};
var $correlnumber = {{ $voucher->sequence }};

var $accounts = [ @foreach ($accounts as $account) { id: {{ $account->id }}, text: '{{ $account->codigo }}', title: '{{ $account->nombre }}', rut: '{{ $account->ctacte2 }}' }, @endforeach ];
var $identifications = [ @foreach ($identifications as $identification) { id: {{ $identification->id }}, text: '{{ $identification->name }}', title: '{{ $identification->rut }}' }, @endforeach ];

var $doctypes = [ @foreach (\App\Doctype::all() as $doctype) { id: {{ $doctype->id }}, text: '{{ $doctype->code }}', title: '{{ $doctype->description }}' }, @endforeach ];

@for ($i = 1; $i <= $lines; $i++) {
    @if(isset($voucher->voucherdetails[$i - 1]))
    $("#account{{ $i }}").on('change', function() {
        var $value = $(this).find("option:selected").attr("value");
        if($value){
            $("#fecha{{ $i }}").prop("required", true);
            $("#detalle{{ $i }}").prop("required", true);
            var $result = $.grep($accounts, function(e){ return e.id == $value; });
            if($result[0] && $result[0].rut == 'S'){
                $("#nombre{{ $i }}").prop("required", true);
                $("#nombre{{ $i }}").prop("disabled", false);
                $("#rut{{ $i }}").prop("disabled", false);
            }else{
                $("#nombre{{ $i }}").prop("required", false);
                $("#nombre{{ $i }}").prop("disabled", true);
                $("#rut{{ $i }}").prop("disabled", true);
            }
        }else{
            $("#fecha{{ $i }}").prop("required", false);
            $("#detalle{{ $i }}").prop("required", false);
            $("#nombre{{ $i }}").val(null).trigger("change");
            $("#rut{{ $i }}").val(null);
        }
    });
    @endif

    $("#account{{ $i }}").select2({
        data: $accounts,
        placeholder: "Seleccione...",
        allowClear: true,
        templateResult: formatOption,
        selectOnClose: true,
        matcher: customMatcher
    }).val({{ isset($voucher->voucherdetails[$i - 1]) ? $voucher->voucherdetails[$i - 1]->account->id : 0 }}).trigger('change');

    $("#doctype_id{{ $i }}").select2({
        data: $doctypes,
        placeholder: "Tipo Doc.",
        allowClear: true,
        selectOnClose: true,
        templateResult: formatOption
    }).val({{ isset($voucher->voucherdetails[$i - 1]) && isset($voucher->voucherdetails[$i - 1]->doctype) ? $voucher->voucherdetails[$i - 1]->doctype->id : 0 }}).trigger('change');

    @if(isset($voucher->voucherdetails[$i - 1]) && isset($voucher->voucherdetails[$i - 1]->identification))
    $("#nombre{{ $i }}").on("change", function (e) {
        var $title = $(this).find("option:selected").attr("title");
        if($title){
            $("#rut{{ $i }}").prop("disabled", true);
            $("#rut{{ $i }}").val($title);
        }else{
            $("#string_nombre{{ $i }}").val($(this).find("option:selected").val());
            $("#rut{{ $i }}").prop("disabled", false);
            $("#rut{{ $i }}").val("");
            $("#rut{{ $i }}").prop("required", true);
            $("#rut{{ $i }}").focus();
        }
    });
    @endif
    
    $("#nombre{{ $i }}").select2({
        data: $identifications,
        tags: true,
        createTag: function (params) {
            return {
              id: params.term,
              text: params.term,
              newOption: true
            }
          },
        allowClear: true,
        selectOnClose: true,
        placeholder: "Seleccione..."
    }).val({{ isset($voucher->voucherdetails[$i - 1]) && isset($voucher->voucherdetails[$i - 1]->identification) ? $voucher->voucherdetails[$i - 1]->identification->id : 0 }}).trigger('change');

    $("#account{{ $i }}").on("select2:select", function (e) {
        var $id = $(this).find("option:selected").attr("value");
        if($id){
            $("#fecha{{ $i }}").prop("required", true);
            $("#detalle{{ $i }}").prop("required", true);
            var $result = $.grep($accounts, function(e){ return e.id == $id; });
            if($result[0] && $result[0].rut == 'S'){
                $("#nombre{{ $i }}").prop("required", true);
                $("#nombre{{ $i }}").prop("disabled", false);
                $("#rut{{ $i }}").prop("disabled", false);
            }else{
                $("#nombre{{ $i }}").prop("required", false);
                $("#nombre{{ $i }}").prop("disabled", true);
                $("#rut{{ $i }}").prop("disabled", true);
                $("#nombre{{ $i }}").val(null).trigger("change");
                $("#rut{{ $i }}").val(null);
            }
        }else{
            $("#fecha{{ $i }}").prop("required", false);
            $("#detalle{{ $i }}").prop("required", false);
        }
    });

    $("#fecha{{ $i }}").datepicker({language: 'es', todayHighlight: true, autoclose: true}).datepicker("setDate", "{{ isset($voucher->voucherdetails[$i - 1]) ? $voucher->voucherdetails[$i - 1]->date->format('d-m-Y') : 'today' }}");

    $('#debe{{ $i }}').on('focusout', function() { 
        if($('#debe{{ $i }}').val() == '')
            $('#debe{{ $i }}').val(0);
        $('#totaldebe').val( parseInt($('#debe1').val()) + parseInt($('#debe2').val()) + parseInt($('#debe3').val()) + parseInt($('#debe4').val()) + parseInt($('#debe5').val()) + parseInt($('#debe6').val()) + parseInt($('#debe7').val()) + parseInt($('#debe8').val()) + parseInt($('#debe9').val()) + parseInt($('#debe10').val()) );
    });

    $('#haber{{ $i }}').on('focusout', function() { 
        $('#totalhaber').val( parseInt($('#haber1').val()) + parseInt($('#haber2').val()) + parseInt($('#haber3').val()) + parseInt($('#haber4').val()) + parseInt($('#haber5').val()) + parseInt($('#haber6').val()) + parseInt($('#haber7').val()) + parseInt($('#haber8').val()) + parseInt($('#haber9').val()) + parseInt($('#haber10').val()) );
    });
}
@endfor

$("#date").datepicker({language: 'es', todayHighlight: true, autoclose: true}).datepicker("setDate", "{{ $voucher->date->format('d/m/Y') }}");

$('#auto_correl').on('change', function() { 
        $("#correl").prop("disabled", $('#auto_correl').prop("checked"));
        updateCorrel();
    });

function updateCorrel() {
    if($("#auto_correl").prop("checked")){
        $("#correl").val($correlnumber);
    }
}

function formatOption (option) {
    var $option = $(
      '<div><strong>' + option.text + '</strong></div><div>' + option.title + '</div>'
    );
    return $option;
};

function customMatcher(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
          return data;
        }

        if(data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1 || data.title.toUpperCase().indexOf(params.term.toUpperCase()) > -1)
            return data;

        // Return `null` if the term should not be displayed
        return null;
}

$( document ).ready(function() {
    updateCorrel();
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });

    $('#totaldebe').val( parseInt($('#debe1').val()) + parseInt($('#debe2').val()) + parseInt($('#debe3').val()) + parseInt($('#debe4').val()) + parseInt($('#debe5').val()) + parseInt($('#debe6').val()) + parseInt($('#debe7').val()) + parseInt($('#debe8').val()) + parseInt($('#debe9').val()) + parseInt($('#debe10').val()) );
    $('#totalhaber').val( parseInt($('#haber1').val()) + parseInt($('#haber2').val()) + parseInt($('#haber3').val()) + parseInt($('#haber4').val()) + parseInt($('#haber5').val()) + parseInt($('#haber6').val()) + parseInt($('#haber7').val()) + parseInt($('#haber8').val()) + parseInt($('#haber9').val()) + parseInt($('#haber10').val()) );
});

$("#formulario").submit( function (e) {
    $("#sendButton").prop("disabled", true);
});

$("select").on('select2:unselecting', function(e) {
    $(this).data('unselecting', true);
}).on('select2:open', function(e) { // note the open event is important
    if ($(this).data('unselecting')) {    
        $(this).removeData('unselecting'); // you need to unset this before close
        $(this).select2('close');
    }
});

</script>

@endsection