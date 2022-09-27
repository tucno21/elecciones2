<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Panel Mi Institución</h2>
        <hr class="mt-0 mb-4" />



        <div class="row px-3">

            <div class="p-2 mb-2">
                <a href="<?= route('schools.edit') . '?id=' . $school->id ?>" class="btn btn-outline-dark btn-sm">Modificar</a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">IE</th>
                        <th scope="col">Logo</th>
                        <th scope="col">Color</th>
                        <th scope="col">Fecha votación</th>
                        <th scope="col">Mensaje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row"><?= $school->name ?></th>
                        <?php if ($school->photo == "") : ?>
                            <td><img src="<?= base_url('/assets/img/logo.png') ?>" alt="avatar" class="img-thumbnail" width="40px"></td>
                        <?php else : ?>
                            <td><img src="<?= base_url('/assets/img/' . $school->photo) ?>" alt="avatar" class="img-thumbnail" width="40px"></td>
                        <?php endif; ?>
                        <td style="background-color: <?= $school->color; ?>;">
                            <div><?= $school->color; ?></div>
                        </td>
                        <td><?= $school->date ?></td>
                        <td><?= $school->message ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</main>
<?php include ext('layoutDash.footer') ?>