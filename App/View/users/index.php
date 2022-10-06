<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Panel de usuarios</h2>
        <hr class="mt-0 mb-4" />



        <div class="row px-3">

            <div class="p-2 mb-2">
                <a href="<?= route('users.create') ?>" class="btn btn-outline-dark btn-sm">Crear Usuario</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Escuela</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($users as $user) : ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><?= $user->fullname ?></td>
                                <td><?= $user->email ?></td>

                                <td>
                                    <p class="<?= $user->status == 1  ? 'btn btn-outline-success rounded-pill btn-xs  waves-effect waves-light' : 'btn btn-outline-danger rounded-pill btn-xs  waves-effect waves-light' ?>"><?= $user->status == 1  ? 'activo' : 'inactivo' ?> </p>
                                </td>

                                <td><?= $user->rol_name ?></td>
                                <td><?= $user->school_name ?></td>

                                <td>
                                    <a href="<?= route('users.edit') . '?id=' . $user->id ?>" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil"></i>
                                    </a>
                                    <a href=<?= route('users.destroy') . '?id=' . $user->id ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $i++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
<?php include ext('layoutDash.footer') ?>