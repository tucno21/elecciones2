<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Crear Institución</h2>
        <hr class="mt-0 mb-4" />



        <div class="mx-auto card">
            <div class="card-header">
                <a class="btn btn-outline-dark btn-sm" href="<?= route('schools.index') ?>">Volver</a>
            </div>

            <form action="<?= route('schools.createadmin') ?>" method="POST">
                <?= csrf() ?>

                <div class="card-body">
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
                </div>

                <div class="text-center card-footer">
                    <button type="submit" class="btn btn-dark">Agregar</button>
                </div>
            </form>
        </div>

    </div>
</main>
<?php include ext('layoutDash.footer') ?>