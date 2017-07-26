<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-popin">
        <form action="{{ url('/update/bank') }}" id="modal-form" name="modal-form" class="form-horizontal push-10-t push-10" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="bank_id" id="bank_id" value="">
            <div class="modal-content">
                <div class="block block-themed block-transparent remove-margin-b">
                    <div class="block-header bg-primary-dark">
                        <ul class="block-options">
                            <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                            </li>
                        </ul>
                        <h3 id="title_modal" name="title_modal" class="block-title">Modificar Banco</h3>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="name" name="name" placeholder="Ingrese nombre del banco" required="">
                                        <label for="name">Nombre Banco</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="checking_account" name="checking_account" placeholder="Ingrese cuenta corriente" required="">
                                        <label for="checking_account">Cuenta Corriente</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="form-material">
                                        <select class="form-control" id="account_id" name="account_id" style="width: 100%">
                                            <option></option>
                                        </select>
                                        <label for="account_id">Cuenta contable (opcional)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="form-material">
                                        <input class="form-control" type="number" id="checkact" min="0" name="checkact" placeholder="Ingrese el último número de cheque emitido" required="">
                                        <label for="checkact">Correlativo Último Cheque</label>
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
var $accounts = [ @foreach (\App\Account::where('codigo', 'LIKE', '%' . '11-02-' . '%')->where('nivel', 4)->get() as $account) { id: {{ $account->id }}, text: '{{ $account->codigo }} - {{ $account->nombre }}', name: '{{ $account->nombre }}', code: '{{ $account->codigo }}' }, @endforeach ];

var $banks = [ @foreach ($banks as $bank) { id: {{ $bank->id }}, name: '{{ $bank->name }}', checking_account: '{{ $bank->checking_account }}', checkact: '{{ $bank->checkact }}', account_id: {{ $bank->account_id ? $bank->account_id : 0 }} }, @endforeach ];

var $newaction = '{{ url('/new/bank') }}';
var $modifyaction = '{{ url('/update/bank') }}';

$("#account_id").select2({
        data: $accounts,
        placeholder: "Seleccione una cuenta contable",
        allowClear: true,
        dropdownParent: $("#modal-edit")
    });

function newval() {
    $('#bank_id').val('');
    $('#name').val('');
    $('#checking_account').val('');
    $('#account_id').val(null).trigger("change");
    $('#checkact').val('');
    $('#title_modal').html('Nuevo Banco');
    $('#button_modal').html('Agregar');
    $('#modal-form').prop('action', $newaction);
}

function modifyval(value) {
    var $result = $.grep($banks, function(e){ return e.id == value; })[0];
    var $account = $.grep($accounts, function(e){ return e.id == $result.account_id; })[0];
    $('#bank_id').val($result.id);
    $('#name').val($result.name);
    $('#checking_account').val($result.checking_account);
    if($account)
        $('#account_id').val($account.id).trigger("change");
    else
        $('#account_id').val(null).trigger("change");
    $('#checkact').val($result.checkact);

    $('#title_modal').html('Modificar Banco');
    $('#button_modal').html('Modificar');
    $('#modal-form').prop('action', $modifyaction);
}
</script>