<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-popin">
        <form action="{{ url('/update/account') }}" id="modal-form" name="modal-form" class="form-horizontal push-10-t push-10" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="account_id" id="account_id" value="">
            <div class="modal-content">
                <div class="block block-themed block-transparent remove-margin-b">
                    <div class="block-header bg-primary-dark">
                        <ul class="block-options">
                            <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                            </li>
                        </ul>
                        <h3 id="title_modal" name="title_modal" class="block-title">Modificar cuenta contable</h3>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="form-material">
                                        <select class="form-control" id="father_account_id" name="father_account_id" style="width: 100%" required="">
                                            <option></option>
                                        </select>
                                        <label for="account_id">Cuenta contable padre</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="form-material">
                                        <select class="form-control" id="fecucode_id" name="fecucode_id" style="width: 100%">
                                            <option></option>
                                        </select>
                                        <label for="account_id">Código FECU (opcional)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="name" name="name" placeholder="Ingrese nombre de la cuenta" required="">
                                        <label for="name">Nombre Cuenta Contable</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="row">
                                        <div class="col-xs-3 text-center">
                                            <label for="cc" class="css-input switch switch-sm switch-default">
                                                <input type="checkbox" id="cc" name="cc"><span></span> <br><b>C.C.</b>
                                            </label>
                                        </div>
                                        <div class="col-xs-3 text-center">
                                            <label class="css-input switch switch-sm switch-default">
                                                <input type="checkbox" id="rut" name="rut"><span></span> <br><b>RUT</b>
                                            </label>
                                        </div>
                                        <div class="col-xs-3 text-center">
                                            <label class="css-input switch switch-sm switch-default">
                                                <input type="checkbox" id="flu" name="flu"><span></span> <br><b>Flujo</b>
                                            </label>
                                        </div>
                                        <div class="col-xs-3 text-center">
                                            <label class="css-input switch switch-sm switch-default">
                                                <input type="checkbox" id="patr" name="patr"><span></span> <br><b>Patrimonio</b>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-sm btn-primary" name="button_modal" id="button_modal" type="submit">Modificar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('/assets/js/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/plugins/select2/select2-bootstrap.min.css') }}">

<script src="{{ asset('/assets/js/plugins/select2/select2.full.min.js') }}"></script>

<script type="text/javascript">
var $accounts = [ @foreach ($accounts as $account) { id: {{ $account->id }}, text: '{{ $account->codigo }} - {{ $account->nombre }}', name: '{{ $account->nombre }}', code: '{{ $account->codigo }}', fecucode_id: {{ $account->fecucode_id ? $account->fecucode_id : 0 }}, cc: '{{ $account->ctacte }}', rut: '{{ $account->ctacte2 }}', flu: '{{ $account->ctacte3 }}', patr: '{{ $account->ctacte4 }}' }, @endforeach ];

var $father_accounts = [ @foreach (\App\Account::where('nivel', 3)->get() as $account) { id: {{ $account->id }}, text: '{{ $account->codigo }} - {{ $account->nombre }}', code: '{{ $account->codigo }}' }, @endforeach ];

var $fecucodes = [ @foreach (\App\FECUCode::all() as $fecu) { id: {{ $fecu->id }}, text: '{{ $fecu->code }} - {{ $fecu->name }}', code: '{{ $fecu->code }}' }, @endforeach ];

var $newaction = '{{ url('/new/account') }}';
var $modifyaction = '{{ url('/update/account') }}';

$("#father_account_id").select2({
        data: $father_accounts,
        placeholder: "Seleccione una cuenta contable",
        dropdownParent: $("#modal-edit")
    });

$("#fecucode_id").select2({
        data: $fecucodes,
        placeholder: "Seleccione un código FECU",
        dropdownParent: $("#modal-edit"),
        allowClear: true
    });

function newval() {
    $('#account_id').val('');
    $('#father_account_id').prop('disabled', false);
    $('#father_account_id').val(null).trigger("change");
    $('#fecucode_id').val(null).trigger("change");
    $('#name').val('');
    $('#cc').prop('checked', false);
    $('#rut').prop('checked', false);
    $('#flu').prop('checked', false);
    $('#patr').prop('checked', false);

    $('#title_modal').html('Nueva cuenta contable');
    $('#button_modal').html('Agregar');
    $('#modal-form').prop('action', $newaction);
}

function modifyval(value) {
    var $account = $.grep($accounts, function(e){ return e.id == value; })[0];
    $('#account_id').val($account.id);
    var $splitted = $account.code.split('-');

    var $father_account = $.grep($father_accounts, function(e){ return e.code == $splitted[0].concat('-', $splitted[1], '-000'); })[0];

    if($father_account)
        $('#father_account_id').val($father_account.id).trigger("change");
    else
        $('#father_account_id').val(null).trigger("change");

    $('#father_account_id').prop('disabled', true);

    var $fecu = $.grep($fecucodes, function(e){ return e.id == $account.fecucode_id; })[0];

    if($fecu)
        $('#fecucode_id').val($fecu.id).trigger("change");
    else
        $('#fecucode_id').val(null).trigger("change");

    $('#name').val($account.name);
    $('#cc').prop('checked', $account.cc == 'S');
    $('#rut').prop('checked', $account.rut == 'S');
    $('#flu').prop('checked', $account.flu == 'S');
    $('#patr').prop('checked', $account.patr == 'S');

    $('#title_modal').html('Modificar cuenta contable');
    $('#button_modal').html('Modificar');
    $('#modal-form').prop('action', $modifyaction);
}
</script>