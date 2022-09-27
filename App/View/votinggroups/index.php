<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Mesas de Sufragio</h2>
        <hr class="mt-0 mb-4" />



        <div class="row px-3">

            <div class="p-2 mb-2">
                <a href="<?= route('votinggroups.create') ?>" class="btn btn-outline-dark btn-sm">Crear Mesa de Votación</a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mesa N°</th>
                        <th scope="col">Miembros</th>
                        <th scope="col">Código Excel</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($mesas as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td><?= $m->group_name ?></td>

                            <td>Miembrop de mesa</td>

                            <td><?= $m->id ?></td>

                            <td>
                                <a href="<?= route('votinggroups.edit') . '?id=' . $m->id ?>" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil"></i>
                                </a>
                                <a href=<?= route('votinggroups.destroy') . '?id=' . $m->id ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                    <?php $i++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>
<?php include ext('layoutDash.footer') ?>