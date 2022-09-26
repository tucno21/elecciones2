<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Panel de Roles</h2>
        <hr class="mt-0 mb-4" />



        <div class="row px-3">

            <div class="p-2 mb-2">
                <a href="<?= route('roles.create') ?>" class="btn btn-outline-dark btn-sm">Crear Rol</a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Permisos</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $r) : ?>
                        <tr>
                            <th scope="row"><?= $r->id ?></th>
                            <td><?= $r->rol_name ?></td>

                            <td><a href="<?= '?id=' . $r->id ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-key"></i></a></td>

                            <td>
                                <a href="<?= route('roles.edit') . '?id=' . $r->id ?>" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil"></i>
                                </a>
                                <a href=<?= route('roles.destroy') . '?id=' . $r->id ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i>
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