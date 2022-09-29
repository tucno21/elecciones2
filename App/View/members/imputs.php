<!-- rol name -->
<div class="input-group input-group-sm ">
    <spam class="input-group-text"><i class="bi bi-gear"></i></spam>
    <input type="number" class="form-control <?= isset($err->dni) ? 'is-invalid' : '' ?>" name="dni" placeholder="Ingrese el DNI" value="<?= isset($data->dni) ? $data->dni : '' ?>">
    <?php if (isset($err->dni)) : ?>
        <div class="invalid-feedback">
            <?= $err->dni ?>
        </div>
    <?php endif; ?>
</div>

<input type="hidden" name="id" value="<?= isset($data->id) ? $data->id : '' ?> ">