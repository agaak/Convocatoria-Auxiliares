<div class="form-row my-2">
    <label class="col-3" for="merit-descripcion">Descripción:</label>
    <textarea class="form-control col-sm" name="merit-descripcion" id="merit-descripcion"
        rows="3" placeholder="Ingrese la descripción del mérito" required minlength="10">{{ old('merit-descripcion') }}</textarea>
</div>
{!! $errors->first('merit-descripcion', '<strong class="message-error text-danger">:message</strong>') !!}
<div class="form-row my-2">
    <label class="col-3 col-form-label" for="merit-porcentaje">Porcentaje:</label>
    <input type="number" class="form-control col-sm-3" name="merit-porcentaje"
        id="merit-porcentaje" placeholder="%" value="{{ old('merit-porcentaje') }}" min="1" max="100" required>
</div>
{!! $errors->first('merit-porcentaje', '<strong class="message-error text-danger">:message</strong>') !!}

@if ($errors->has('merit-descripcion') || $errors->has('merit-porcentaje'))
<script>
    window.onload = () => {
        $('#meritModal').modal('show');
    }
</script>
@endif