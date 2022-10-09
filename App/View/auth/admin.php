<?php include ext('auth.layout.head') ?>
<div class="vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-4 p-5 shadow-sm border rounded-5 border-primary">
        <h4 class="text-center mb-4 text-light">Elecciones Municipales Escolares</h4>
        <p class="text-center mb-4 text-light">¡Acceso Administrador!</p>
        <form action="<?= route('login.admin') ?>" method="POST">
            <?= csrf() ?>
            <div class="mb-4">
                <label for="inputb" class="form-label text-light">Email</label>
                <div class="input-group">
                    <span class="input-group-text border border-primary bg-primary opacity-75 text-light">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input name="email" type="email" class="form-control border border-primary <?= isset($err->email) ? 'is-invalid' : '' ?>" placeholder="email@email.com" id="inputb" value="<?= isset($data->email) ? $data->email : '' ?>">

                    <?php if (isset($err->email)) : ?>
                        <div class="invalid-feedback">
                            <?= $err->email ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-5">
                <label for="inputa" class="form-label text-light">Password</label>
                <div class="input-group">
                    <span class="input-group-text border border-primary bg-primary opacity-75 text-light">
                        <i class="bi bi-key"></i>
                    </span>
                    <input name="password" type="password" class="form-control border border-primary <?= isset($err->password) ? 'is-invalid' : '' ?>" id="inputa">

                    <?php if (isset($err->password)) : ?>
                        <div class="invalid-feedback">
                            <?= $err->password ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="d-grid">
                <button class="btn btn-primary" type="submit">Entrar</button>
            </div>
        </form>
        <div class="mt-3">
            <p class="mb-0 text-center">
                <a href="<?= route('login.index') ?>" class="text-primary-50">
                    Regresar a votar
                </a>
            </p>
        </div>
    </div>
</div>

<?php include ext('auth.layout.footer') ?>