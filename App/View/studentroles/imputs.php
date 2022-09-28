<!-- rol name -->
<div class="input-group input-group-sm ">
    <spam class="input-group-text"><i class="bi bi-gear"></i></spam>
    <input type="text" class="form-control <?= isset($err->name) ? 'is-invalid' : '' ?>" name="name" placeholder="Nombre del rol del estudiante" value="<?= isset($data->name) ? $data->name : '' ?>">
    <?php if (isset($err->name)) : ?>
        <div class="invalid-feedback">
            <?= $err->name ?>
        </div>
    <?php endif; ?>
</div>

<input type="hidden" name="id" value="<?= isset($data->id) ? $data->id : '' ?> ">