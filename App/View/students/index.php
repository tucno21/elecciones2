<?php
$linksCss2 = [
    base_url . '/assets/plugins/dataTables/dataTables.bootstrap5.min.css',
    base_url . '/assets/plugins/dataTables/responsive.bootstrap5.min.css',
];

$linksScript2 = [
    base_url . '/assets/plugins/dataTables/jquery-3.5.1.js',
    base_url . '/assets/plugins/dataTables/jquery.dataTables.min.js',
    base_url . '/assets/plugins/dataTables/dataTables.bootstrap5.min.js',
    base_url . '/assets/plugins/dataTables/dataTables.responsive.min.js',
    base_url . '/assets/plugins/dataTables/responsive.bootstrap5.min.js',
    base_url . '/assets/js/datatable.js',
];
?>
<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Lista de Estudiantes</h2>
        <hr class="mt-0 mb-4" />



        <div class="row px-3">
            <!-- //mensage session flash -->
            <?php if (session()->has('error_code')) : ?>
                <div class="col-md-4">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>¡Error!</strong> <?= session()->get('error_code') ?>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>

            <!-- //mensage session flash -->
            <?php if (session()->has('succes_data')) : ?>
                <div class="col-md-4">
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Exito!</strong> <?= session()->get('succes_data') ?>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>

            <!-- BOTONES -->
            <div class="p-2 mb-2">

                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalExel">
                    <i class="mx-1 bi bi-file-earmark-excel"></i>
                    Subir Excel
                    <i class="mx-1 bi bi-arrow-down-square"></i>
                </button>

                <a href="<?= route('students.deleteStudentSchool') ?>" id="deleteStudents" class="btn btn-outline-dark btn-sm">Borrar Estudiantes</a>
                <a href="<?= route('students.report') ?>" class="btn btn-outline-success btn-sm">Reporte</a>
                <a href="<?= route('qr.index') ?>" target="_blanck" class="btn btn-outline-dark btn-sm">DNI QR <i class="mx-1 bi bi-qr-code"></i></a>
                <a href="<?= route('students.reiniciarvotos') ?>" id="reiniciarVoto" class="btn btn-outline-danger btn-sm">Reniciar Votos<i class="mx-1 bi bi-arrow-counterclockwise"></i></a>
            </div>


            <table class="table table-sm table-striped dt-responsive" id="datatableStudent">
                <!-- <table class="table table-sm table-striped dt-responsive nowrap" id="example"> -->
                <thead>
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Estudiante</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Mesa</th>
                        <th scope="col">Voto?</th>
                        <th scope="col">Fecha Votación</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($students as $user) : ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td><?= $user->fullname ?></td>
                            <td><?= $user->dni ?></td>

                            <td><?= $user->group_name ?></td>

                            <?php if ($user->candidate_id > 0) { ?>
                                <td>
                                    <p class="pt-0 pb-0 btn btn-primary">si</p>
                                </td>
                            <?php } else { ?>
                                <td>
                                    <p class="pt-0 pb-0 btn btn-danger">no</p>
                                </td>
                            <?php }; ?>

                            <td><?= $user->date_voting ?></td>

                            <td>
                                <a href=<?= route('students.destroy') . '?id=' . $user->id ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i>
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

<!-- modal Excel -->
<div class="modal fade" id="modalExel" tabindex="-1" aria-labelledby="modalExel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Subir Estudiantes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route('students.uploaddata') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf() ?>
                    <p>Seleccione el archivo excel que descargo de ejemplo y agrego a sus estudiantes</p>

                    <div class="mb-3">
                        <div class="input-group input-group-sm mb-3">
                            <label class="input-group-text" for="inputGroupFile01"><i class="bi bi-filetype-xls"></i></label>
                            <input type="file" name="file" id="imagen" accept=".xls,.xlsx" class="form-control" required>
                        </div>
                    </div>

                    <div class="text-center card-footer p-0 pb-3">
                        <a href="<?= route('students.tablemodel') ?>" class="btn btn-success">
                            <i class="mx-1 bi bi-file-earmark-excel"></i>
                            Descargar Excel de ejemplo
                            <i class="mx-1 bi bi-arrow-down-square"></i>
                        </a>
                    </div>


                    <div class="text-center card-footer p-0 pb-3">
                        <button type="submit" class="btn btn-dark">Subir EXCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include ext('layoutDash.footer') ?>