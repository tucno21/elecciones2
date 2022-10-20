<?php include ext('auth.layout.head') ?>

<div class="vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-4 p-5 shadow-sm border rounded-5 border-primary">
        <h4 class="text-center mb-4 text-light">Elecciones del Municipal Escolar - Voto Electrónico</h4>
        <p class="text-center mb-4 text-light">¡Acceso Solo Presidente de mesa!</p>
        <?php
        if (session()->has('errorSesion')) {
        ?>
            <div class="alert alert-danger text-center">
                <?= session()->get('errorSesion'); ?>
            </div>
        <?php
        }
        ?>
        <form action="<?= route('login.index') ?>" method="POST">
            <?= csrf() ?>
            <div class="mb-5">
                <label for="inputb" class="form-label text-light">DNI</label>
                <div class="input-group">
                    <span class="input-group-text border border-primary bg-primary opacity-75 text-light">
                        <i class="bi bi-person-square"></i>
                    </span>
                    <input name="dni" type="number" class="form-control border border-primary <?= isset($err->dni) ? 'is-invalid' : '' ?>" placeholder="11223344" id="inputb" value="<?= isset($data->dni) ? $data->dni : '' ?>">
                    <?php if (isset($err->dni)) : ?>
                        <div class="invalid-feedback">
                            <?= $err->dni ?>
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
                <a href="<?= route('login.admin') ?>" class="text-primary-50">
                    Panel Administrativo
                </a>
            </p>
        </div>
    </div>
</div>

<?php include ext('auth.layout.footer') ?>