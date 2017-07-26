<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-popin">
        <form action="{{ url('/modify/identification') }}" id="modal-form" name="modal-form" class="form-horizontal push-10-t push-10" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="identification_id" id="identification_id" value="">
            <div class="modal-content">
                <div class="block block-themed block-transparent remove-margin-b">
                    <div class="block-header bg-primary-dark">
                        <ul class="block-options">
                            <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                            </li>
                        </ul>
                        <h3 id="title_modal" name="title_modal" class="block-title">Modificar RUT</h3>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="rut" name="rut" placeholder="Ingrese RUT" required="">
                                        <label for="rut">RUT</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="block-content">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="name" name="name" placeholder="Ingrese nombre" required="">
                                        <label for="name">Nombre</label>
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

<script type="text/javascript">
var $identifications = [ @foreach ($identifications as $identification) { id: {{ $identification->id }}, name: '{{ $identification->name }}', rut: '{{ $identification->rut }}' }, @endforeach ];

var $newaction = '{{ url('/new/identification') }}';
var $modifyaction = '{{ url('/update/identification') }}';

function newval() {
    $('#identification_id').val('');
    $('#rut').val('');
    $('#name').val('');
    $('#title_modal').html('Nuevo RUT');
    $('#button_modal').html('Agregar');
    $('#modal-form').prop('action', $newaction);
}

function modifyval(value) {
    var $result = $.grep($identifications, function(e){ return e.id == value; });
    $('#identification_id').val($result[0].id);
    $('#rut').val($result[0].rut);
    $('#name').val($result[0].name);
    $('#title_modal').html('Modificar RUT');
    $('#button_modal').html('Modificar');
    $('#modal-form').prop('action', $modifyaction);
}
</script>