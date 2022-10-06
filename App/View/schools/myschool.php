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
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border border-info border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Institucion Educativa</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= $school->name ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-house-door fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border border-warning border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Mensaje para cedula de votación</div>
                                <div class="mb-0 font-weight-bold text-gray-800">
                                    <?= $school->message ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-chat-left-text fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border border-success border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Color Fondo</div>
                                <div class="h5 mb-0 py-2 px-1" style="background-color: <?= $school->color; ?>;">
                                    <div style="color: <?= $school->colorletter; ?>;">Color Letra</div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-palette fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border border-danger border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Insignia</div>
                                <div class="mb-0">
                                    <?php if ($school->photo == "") : ?>
                                        <img src="<?= base_url('/assets/img/logo.png') ?>" alt="avatar" class="img-thumbnail" width="45px">
                                    <?php else : ?>
                                        <img src="<?= base_url('/assets/img/' . $school->photo) ?>" alt="avatar" class="img-thumbnail" width="45px">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-image fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border border-info border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Codigo Modular</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= $school->codigo_modular ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-upc fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</main>
<?php include ext('layoutDash.footer') ?>