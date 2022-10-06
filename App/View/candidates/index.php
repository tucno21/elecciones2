<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Panel de Candidatos</h2>
        <hr class="mt-0 mb-4" />

        <div class="row px-3">

            <div class="p-2 mb-2">
                <a href="<?= route('candidates.create') ?>" class="btn btn-outline-dark btn-sm">Registrar Candidato</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre Apellido</th>
                            <th scope="col">DNI</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Logo</th>
                            <th scope="col">Titulo del Grupo</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($candidates as $r) : ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><?= $r->fullname ?></td>
                                <td><?= $r->dni ?></td>

                                <?php if ($r->photo == "") : ?>
                                    <td><img src="<?= base_url('/assets/img/user.png') ?>" alt="avatar" class="img-thumbnail" width="40px"></td>
                                <?php else : ?>
                                    <td><img src="<?= base_url('/assets/img/' . $r->photo) ?>" alt="avatar" class="img-thumbnail" width="40px"></td>
                                <?php endif; ?>

                                <?php if ($r->logo == "") : ?>
                                    <td><img src="<?= base_url('/assets/img/logo.jpg') ?>" alt="avatar" class="img-thumbnail" width="40px"></td>
                                <?php else : ?>
                                    <td><img src="<?= base_url('/assets/img/' . $r->logo) ?>" alt="avatar" class="img-thumbnail" width="40px"></td>
                                <?php endif; ?>

                                <td><?php echo $r->group_name; ?></td>

                                <?php if ($r->estado != 0) : ?>
                                    <td>
                                        <p class="btn btn-success btn-xs">Activado</p>
                                    </td>
                                <?php else : ?>
                                    <td>
                                        <p class="btn btn-danger btn-xs">Desactivado</p>
                                    </td>
                                <?php endif; ?>

                                <td>
                                    <a href="<?= route('candidates.edit') . '?id=' . $r->id ?>" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil"></i>
                                    </a>
                                    <a href=<?= route('candidates.destroy') . '?id=' . $r->id ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i>
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