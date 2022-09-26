<!-- rol name -->
<div class="input-group input-group-sm ">
    <spam class="input-group-text"><i class="bi bi-gear"></i></spam>
    <input type="text" class="form-control <?= isset($err->rol_name) ? 'is-invalid' : '' ?>" name="rol_name" placeholder="Nombre del rol" value="<?= isset($data->rol_name) ? $data->rol_name : '' ?>">
    <?php if (isset($err->rol_name)) : ?>
        <div class="invalid-feedback">
            <?= $err->rol_name ?>
        </div>
    <?php endif; ?>
</div>

<input type="hidden" name="id" value="<?= isset($data->id) ? $data->id : '' ?> ">