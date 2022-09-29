<!-- name -->
<div class="mb-3">
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-person"></i></spam>
        <input type="text" class="form-control <?= isset($err->fullname) ? 'is-invalid' : '' ?>" name="fullname" placeholder="Ingresar el Nombre Completo" value="<?= isset($data->fullname) ? $data->fullname : '' ?>">
        <?php if (isset($err->fullname)) : ?>
            <div class="invalid-feedback">
                <?= $err->fullname ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- dni -->
<div class="mb-3">
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-postcard"></i></spam>
        <input type="number" class="form-control <?= isset($err->dni) ? 'is-invalid' : '' ?>" name="dni" placeholder="Ingrese el dni" value="<?= isset($data->dni) ? $data->dni : '' ?>">
        <?php if (isset($err->dni)) : ?>
            <div class="invalid-feedback">
                <?= $err->dni ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- nombre de la agrupación -->
<div class="mb-3">
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-paragraph"></i></spam>
        <input type="text" class="form-control <?= isset($err->group_name) ? 'is-invalid' : '' ?>" name="group_name" placeholder="Ingrese el titulo Agrupación" value="<?= isset($data->group_name) ? $data->group_name : '' ?>">
        <?php if (isset($err->group_name)) : ?>
            <div class="invalid-feedback">
                <?= $err->group_name ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- estado -->
<div class="mb-3">
    <div class="input-group input-group-sm ">
        <spam class="input-group-text"><i class="bi bi-shield-lock"></i></spam>
        <div class="form-control  <?= isset($err->estado) ? 'is-invalid' : '' ?>">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estado" id="estado1" value="1" <?= (isset($data->estado) && $data->estado == 1) ? 'checked' : '' ?>>
                <label class="form-check-label" for="estado1">Habilitar</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estado" id="estado2" value="0" <?= (isset($data->estado) && $data->estado == 0) ? 'checked' : '' ?>>
                <label class="form-check-label" for="estado2">Inhabilitar</label>
            </div>
        </div>
        <?php if (isset($err->estado)) : ?>
            <div class="invalid-feedback">
                <?= $err->estado ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- foto -->
<div class="col-md-6">

    <div class="mb-3">
        <p class="p-0 m-0 fw-bold">Foto del candidato</p>
        <div class="input-group input-group-sm ">
            <spam class="input-group-text"><i class="bi bi-file-person-fill"></i></spam>
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
                <img class="img-thumbnail card-img-top previsualizar" src="<?= base_url('/assets/img/user.png') ?>" alt="Card image cap">
            <?php endif; ?>
            <div class="my-2">
                <p class="card-text">Peso máximo de 1mb</p>
            </div>
        </div>
    </div>

</div>
<!-- Logo -->
<div class="col-md-6">
    <div class="mb-3">
        <p class="p-0 m-0 fw-bold">Logo de la agrupación</p>
        <div class="input-group input-group-sm ">
            <spam class="input-group-text"><i class="bi bi-image"></i></spam>
            <input type="file" class="form-control visorLogo <?= isset($err->logo) ? 'is-invalid' : '' ?>" name="logo" value="<?= isset($data->logo) ? $data->logo : '' ?>">
            <?php if (isset($err->logo)) : ?>
                <div class="invalid-feedback">
                    <?= $err->logo ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="input-group text-center d-flex justify-content-center">
        <div class="" style="width: 8rem;">
            <?php if (!empty($data->logo)) : ?>
                <img class="img-thumbnail card-img-top previsualizarLogo" src="<?= base_url('/assets/img/' . $data->logo) ?>" alt="Card image cap">
            <?php else : ?>
                <img class="img-thumbnail card-img-top previsualizarLogo" src="<?= base_url('/assets/img/logo.png') ?>" alt="Card image cap">
            <?php endif; ?>
            <div class="my-2">
                <p class="card-text">Peso máximo de 1mb</p>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="id" value="<?= isset($data->id) ? $data->id : '' ?>">