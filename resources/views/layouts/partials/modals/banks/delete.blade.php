<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-popin">
        <form action="{{ url('/delete/bank') }}" class="form-horizontal push-10-t push-10" method="post">
            <input type="hidden" name="bank" id="bank" value="0">
            <div class="modal-content">
                <div class="block block-themed block-transparent remove-margin-b">
                    <div class="block-header bg-primary-dark">
                        <ul class="block-options">
                            <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                            </li>
                        </ul>
                        <h3 class="block-title">Confirmar eliminación</h3>
                    </div>
                    <div class="block-content">
                        <p>¿Está seguro que desea realizar la operación de eliminación?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">No, mantener</button>
                    <button class="btn btn-sm btn-danger" type="submit">Si, eliminar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
function deleteval(value) {
    $('#bank').val(value);
}
</script>