<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Panel de Permisos</h2>
        <hr class="mt-0 mb-4" />



        <div class="row px-3">

            <div class="p-2 mb-2">
                <a href="<?= route('permissions.create') ?>" class="btn btn-outline-dark btn-sm">Crear Permiso</a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($permissions as $p) : ?>
                        <tr>
                            <th scope="row"><?= $p->id ?></th>
                            <td><?= $p->per_name ?></td>
                            <td><?= $p->description ?></td>

                            <td>
                                <a href="<?= route('permissions.edit') . '?id=' . $p->id ?>" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil"></i>
                                </a>
                                <a href=<?= route('permissions.destroy') . '?id=' . $p->id ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>
<?php include ext('layoutDash.footer') ?>