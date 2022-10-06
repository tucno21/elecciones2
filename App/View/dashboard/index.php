<?php include ext('layoutDash.head') ?>
<main>
    <header class="py-2 mb-4 color-dashboard">
        <div class="container-xl px-2">
            <div class="text-center">
                <h1 class="color-texto">I.E. <?= $school->name ?></h1>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Resultados</h2>
        <p>Resultados del Voto Electrónico <?= date('Y') ?><i class="bi bi-qr-code-scan mx-2"></i></p>
        <hr class="mt-0 mb-4" />

        <!-- resultados individuales -->

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border border-info border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Cantidad de candidatos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= count((array)$candidatos); ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-people-fill fs-2 text-gray-300"></i>
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
                                    Cantidad de estudiantes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= count((array)$estudiantes); ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-mortarboard fs-2 text-gray-300"></i>
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
                                    Porcentaje de Participacion</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= $estudiantes != null ? round(count((array)$votos) / count((array)$estudiantes) * 100, 2) : ''; ?>%
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-percent fs-2 text-gray-300"></i>
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
                                    Cantidad No votaron</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= (count((array)$estudiantes) - count((array)$votos)); ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-question-circle fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between color-dashboard">
                        <div class="">
                            <h5 class="card-title color-texto">Resultados Electorales</h5>
                            <h6 class="card-subtitle color-texto-muted">Diagrama de barras</h6>
                        </div>
                        <div class="">
                            <a href="#" class="btn btn-dark btn-sm">Reporte Excel</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="chart">
                            <canvas id="chartBar"></canvas>
                        </div>
                    </div>
                    <div class="card-footer color-footer">
                        <h5 class="card-title color-dark">Ganador: <?= $alcalde->name ?></h5>
                        <p class="card-subtitle color-muted">Cantidad de votos: <?= $alcalde->cant ?></p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between color-dashboard">
                        <div class="">
                            <h5 class="card-title color-texto">Resultados Electorales</h5>
                            <h6 class="card-subtitle color-texto-muted">Gráfico circular</h6>
                        </div>
                        <div class="">
                            <a href="" class="btn btn-dark btn-sm">Reporte Excel</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart chart-sm">
                            <canvas id="chartpie" width="10%" height="3rem"></canvas>
                        </div>
                    </div>
                    <div class="card-footer color-footer">
                        <h5 class="card-title color-dark">Ganador: <?= $alcalde->name ?></h5>
                        <p class="card-subtitle color-muted">Cantidad de votos: <?= $alcalde->cant ?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php include ext('layoutDash.footer') ?>