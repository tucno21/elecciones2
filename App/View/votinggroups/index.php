<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Mesas de Sufragio</h2>
        <hr class="mt-0 mb-4" />



        <div class="row px-3">

            <div class="p-2 mb-2 col-md-4">
                <form action="<?= route('votinggroups.create') ?>" method="POST">
                    <?= csrf() ?>
                    <div class="input-group input-group-sm mb-3">
                        <input type="number" name="number_mesa" class="form-control border border-dark <?= isset($err->number_mesa) ? 'is-invalid' : '' ?>" placeholder="Ingrese el cantidad de Mesas" aria-describedby="bb" value="<?= isset($data->number_mesa) ? $data->number_mesa : '' ?>">
                        <button class="btn btn-outline-dark" type="submit" id="bb">Generar Mesas</button>

                        <?php if (isset($err->number_mesa)) : ?>
                            <div class="invalid-feedback">
                                <?= $err->number_mesa ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <!-- //mensage session flash -->
            <?php if (session()->has('error_code')) : ?>
                <div class="col-md-4">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>¡Error!</strong> <?= session()->get('error_code') ?>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>


            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mesa N°</th>
                        <th scope="col">Miembros</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($mesas as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td><?= $m->group_name ?></td>

                            <td> <a href="<?= route('members.index') . '?id=' . $m->id ?>" class="btn btn-outline-dark btn-sm">Mienbros de Mesa</a></td>

                            <td>
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