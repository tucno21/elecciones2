<div class="col-md-6">
    <label for="producto" class="form-label">Producto</label>
    <input name="producto" type="text" class="form-control <?= isset($err->producto) ? 'is-invalid' : '' ?>" id="producto" value="<?= isset($data->producto) ? $data->producto : '' ?>">
    <?php if (isset($err->producto)) : ?>
        <div class="invalid-feedback">
            <?= $err->producto ?>
        </div>
    <?php endif; ?>
</div>
<div class="col-md-6">
    <label for="descripcion" class="form-label">Descripción</label>
    <input name="descripcion" type="text" class="form-control <?= isset($err->descripcion) ? 'is-invalid' : '' ?>" id="descripcion" value="<?= isset($data->descripcion) ? $data->descripcion : '' ?>">
    <?php if (isset($err->descripcion)) : ?>
        <div class="invalid-feedback">
            <?= $err->descripcion ?>
        </div>
    <?php endif; ?>
</div>
<div class="col-md-6">
    <label for="precio" class="form-label">Precio</label>
    <input name="precio" type="number" class="form-control <?= isset($err->precio) ? 'is-invalid' : '' ?>" id="precio" value="<?= isset($data->precio) ? $data->precio : '' ?>">
    <?php if (isset($err->precio)) : ?>
        <div class="invalid-feedback">
            <?= $err->precio ?>
        </div>
    <?php endif; ?>
</div>

<input type="hidden" name="user_id" value="<?= isset($data->user_id) ? $data->user_id : auth()->user()->id ?> ">
<input type="hidden" name="id" value="<?= isset($data->id) ? $data->id : '' ?> ">