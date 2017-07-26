<div class="modal fade" id="modal-logbook" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-popin">
        <form action="{{ url('/report/logbook') }}" class="form-horizontal push-10-t push-10" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-content">
                <div class="block block-themed block-transparent remove-margin-b">
                    <div class="block-header bg-primary-dark">
                        <ul class="block-options">
                            <li>
                                <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                            </li>
                        </ul>
                        <h3 class="block-title">Libro diario</h3>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="form-material">
                                        <div class="input-daterange input-group" id="daterange" name="daterange">
                                            <input class="form-control" type="text" id="start" name="start" placeholder="Desde" data-date-format="dd-mm-yyyy" required="">
                                            <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                            <input class="form-control" type="text" id="finish" name="finish" placeholder="Hasta" data-date-format="dd-mm-yyyy" required="">
                                        </div>
                                        <label for="daterange">Rango de búsqueda</label>
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
                                    <label class="radio-inline" for="traspaso">
                                        <input type="radio" id="traspaso" name="type" value="ALL"> Todo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-file-excel-o"></i> Descargar</button>
                </div>
            </div>
        </form>
    </div>
</div>


<link rel="stylesheet" href="{{ asset('/assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css') }}">
<script src="{{ asset('/assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>

<script type="text/javascript">
@if($min = \App\Voucherdetail::orderBy('date', 'asc')->first()->date)
    var min = new Date('{{ $min->year . '/' . $min->month . '/' . $min->day }}');
@endif

@if($max = \App\Voucherdetail::orderBy('date', 'desc')->first()->date)
    var max = new Date('{{ $max->year . '/' . $max->month . '/' . $max->day }}');
@endif

    $("#start").datepicker({
        language: 'es',
        todayHighlight: true,
        autoclose: true,
        startDate: min,
        endDate: max
    });
    $("#finish").datepicker({
        language: 'es',
        todayHighlight: true,
        autoclose: true,
        startDate: min,
        endDate: max
    });
</script>