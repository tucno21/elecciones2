<!-- rol name -->
<div class="input-group input-group-sm ">
    <spam class="input-group-text"><i class="bi bi-list-task"></i></spam>
    <input type="text" class="form-control <?= isset($err->group_name) ? 'is-invalid' : '' ?>" name="group_name" placeholder="Ingrese 6 digitos solo numeros" value="<?= isset($data->group_name) ? $data->group_name : '' ?>">
    <?php if (isset($err->group_name)) : ?>
        <div class="invalid-feedback">
            <?= $err->group_name ?>
        </div>
    <?php endif; ?>
</div>

<input type="hidden" name="id" value="<?= isset($data->id) ? $data->id : '' ?>">