<div class="modal fade" id="modal-findvoucher" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-popin">
        <form action="{{ url('/find/voucher') }}" class="form-horizontal push-10-t push-10" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-content">
                <div class="block block-themed block-transparent remove-margin-b">
                    <div class="block-header bg-primary-dark">
                        <ul class="block-options">
                            <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                            </li>
                        </ul>
                        <h3 class="block-title">Obtener Voucher</h3>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="code" name="code" placeholder="Ingrese código del voucher. Ej: 1-{{ \Carbon\Carbon::now()->year }}" required="">
                                        <label for="voucher">Código del voucher</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="block-content" style="text-align: center">
                                    <label class="radio-inline" for="ingreso">
                                        <input type="radio" id="ingreso" name="type" value="I" checked=""> Ingreso
                                    </label>
                                    <label class="radio-inline" for="egreso">
                                        <input type="radio" id="egreso" name="type" value="E"> Egreso
                                    </label>
                                    <label class="radio-inline" for="traspaso">
                                        <input type="radio" id="traspaso" name="type" value="T"> Traspaso
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search"></i> Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>