<div class="form-row my-2">
    <label class="col-3" for="submerit-descripcion">Descripción:</label>
    <textarea class="form-control col-sm" name="submerit-descripcion" id="submerit-descripcion"
        rows="3" placeholder="Ingrese la descripción del mérito" required minlength="10">{{ old('submerit-descripcion') }}</textarea>
</div>
{!! $errors->first('submerit-descripcion', '<strong class="message-error text-danger">:message</strong>') !!}
<div class="form-row my-2">
    <label class="col-3 col-form-label" for="submerit-porcentaje">Porcentaje:</label>
    <input type="number" class="form-control col-sm-3" name="submerit-porcentaje"
        id="submerit-porcentaje" placeholder="%" value="{{ old('submerit-porcentaje') }}" min="1" max="100" required>
</div>
{!! $errors->first('submerit-porcentaje', '<strong class="message-error text-danger">:message</strong>') !!}

@if ($errors->has('submerit-descripcion') || $errors->has('submerit-porcentaje'))
<script>
    window.onload = () => {
        $('#subMeritModal').modal('show');
    }
</script>
@endif