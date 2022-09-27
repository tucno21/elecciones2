<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Panel de Escuelas</h2>
        <hr class="mt-0 mb-4" />



        <div class="row px-3">

            <div class="p-2 mb-2">
                <a href="<?= route('schools.create') ?>" class="btn btn-outline-dark btn-sm">Crear Institución</a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Escuela</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schools as $r) : ?>
                        <tr>
                            <th scope="row"><?= $r->id ?></th>
                            <td><?= $r->name ?></td>

                            <td>
                                <a href="<?= route('schools.edit') . '?id=' . $r->id ?>" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil"></i>
                                </a>
                                <a href=<?= route('schools.destroy') . '?id=' . $r->id ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i>
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