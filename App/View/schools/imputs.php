<!-- name -->
<div class="mb-3">
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-house-fill"></i></spam>
        <input type="text" class="form-control <?= isset($err->name) ? 'is-invalid' : '' ?>" name="name" placeholder="Nombre Institución Educativa" value="<?= isset($data->name) ? $data->name : '' ?>">
        <?php if (isset($err->name)) : ?>
            <div class="invalid-feedback">
                <?= $err->name ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- codigo modular -->
<div class="mb-3">
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-123"></i></spam>
        <input type="number" class="form-control <?= isset($err->codigo_modular) ? 'is-invalid' : '' ?>" name="codigo_modular" placeholder="Codigo Modular" value="<?= isset($data->codigo_modular) ? $data->codigo_modular : '' ?>">
        <?php if (isset($err->codigo_modular)) : ?>
            <div class="invalid-feedback">
                <?= $err->codigo_modular ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Color -->
<div class="mb-3">
    <p class="p-0 m-0 fw-bold">Color principal IE</p>
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-palette"></i></spam>
        <input type="color" class="form-control form-control-color <?= isset($err->color) ? 'is-invalid' : '' ?>" name="color" placeholder="Color IE" value="<?= isset($data->color) ? $data->color : '' ?>">
        <?php if (isset($err->color)) : ?>
            <div class="invalid-feedback">
                <?= $err->color ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Color letra -->
<div class="mb-3">
    <p class="p-0 m-0 fw-bold">Color de Letra</p>
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-palette"></i></spam>
        <input type="color" class="form-control form-control-color <?= isset($err->colorletter) ? 'is-invalid' : '' ?>" name="colorletter" placeholder="Color IE" value="<?= isset($data->colorletter) ? $data->colorletter : '' ?>">
        <?php if (isset($err->colorletter)) : ?>
            <div class="invalid-feedback">
                <?= $err->colorletter ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- message -->
<div class="mb-3">
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-chat-left-text"></i></spam>
        <input type="text" class="form-control <?= isset($err->message) ? 'is-invalid' : '' ?>" name="message" placeholder="texto para elecciones" value="<?= isset($data->message) ? $data->message : '' ?>">
        <?php if (isset($err->message)) : ?>
            <div class="invalid-feedback">
                <?= $err->message ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- foto -->
<div class="mb-3">
    <p class="p-0 m-0 fw-bold">Logo IE</p>
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-image"></i></spam>
        <input type="file" class="form-control visorFoto <?= isset($err->photo) ? 'is-invalid' : '' ?>" name="photo" value="<?= isset($data->photo) ? $data->photo : '' ?>">
        <?php if (isset($err->photo)) : ?>
            <div class="invalid-feedback">
                <?= $err->photo ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="input-group text-center d-flex justify-content-center">
    <div class="" style="width: 8rem;">
        <?php if (!empty($data->photo)) : ?>
            <img class="img-thumbnail card-img-top previsualizar" src="<?= base_url('/assets/img/' . $data->photo) ?>" alt="Card image cap">
        <?php else : ?>
            <img class="img-thumbnail card-img-top previsualizar" src="<?= base_url('/assets/img/logo.png') ?>" alt="Card image cap">
        <?php endif; ?>
        <div class="my-2">
            <p class="card-text">Peso máximo de 1mb</p>
        </div>
    </div>
</div>

<input type="hidden" name="id" value="<?= isset($data->id) ? $data->id : '' ?>">