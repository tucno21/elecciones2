<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Acceso de permisos</h2>
        <hr class="mt-0 mb-4" />



        <div class="mx-auto card">
            <div class="card-header">
                <a class="btn btn-outline-dark btn-sm" href="<?= route('roles.index') ?>">Volver</a>
            </div>

            <form action="<?= route('roles.permissions') ?>" method="POST">
                <?= csrf() ?>

                <div class="card-body">
                    <div class="form-group">
                        <h5 class="card-title text-center mb-3">Permisos para: <?= $rol->rol_name ?></h5>

                        <div class="row">

                            <div class="mb-3 border col mx-2">

                                <?php foreach ($permissions as $p) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" id="<?= $p->id ?>" type="checkbox" name="<?= $p->per_name ?>" value="<?= $p->id ?>" id="<?= $p->id ?>" <?= in_array($p->per_name, array_column((array)$permisosRol, 'per_name')) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="<?= $p->id ?>">
                                            <?= $p->description ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="text-center card-footer">
                    <input type="hidden" name="rol_id" value="<?= $rol->id ?>">
                    <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                </div>
            </form>
        </div>

    </div>
</main>
<?php include ext('layoutDash.footer') ?>