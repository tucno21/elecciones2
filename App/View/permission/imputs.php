<!-- rol name -->
<div class="input-group input-group-sm mb-3">
    <spam class="input-group-text"><i class="bi bi-file-earmark-ppt"></i></spam>
    <input type="text" class="form-control <?= isset($err->per_name) ? 'is-invalid' : '' ?>" name="per_name" placeholder="Nombre en Routes: dashboard.index" value="<?= isset($data->per_name) ? $data->per_name : '' ?>">
    <?php if (isset($err->per_name)) : ?>
        <div class="invalid-feedback">
            <?= $err->per_name ?>
        </div>
    <?php endif; ?>
</div>

<!-- rol description -->
<div class="input-group input-group-sm">
    <spam class="input-group-text"><i class="bi bi-activity"></i></spam>
    <input type="text" class="form-control <?= isset($err->description) ? 'is-invalid' : '' ?>" name="description" placeholder="Descripción del rol" value="<?= isset($data->description) ? $data->description : '' ?>">
    <?php if (isset($err->description)) : ?>
        <div class="invalid-feedback">
            <?= $err->description ?>
        </div>
    <?php endif; ?>
</div>

<input type="hidden" name="id" value="<?= isset($data->id) ? $data->id : '' ?>">