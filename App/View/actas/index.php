<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">ACTAS ELECTORALES</h2>
        <hr class="mt-0 mb-4" />

        <!-- //mensage session flash -->
        <?php if (session()->has('errordata')) : ?>
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?= session()->get('errordata') ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (session()->has('successData')) : ?>
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?= session()->get('successData') ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <div class="row">
            <!-- ACTAS -->
            <div class="col-md-6 mb-2">
                <div class="card border border-info border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 p-3">
                    <div class="card-body">
                        <h5 class="card-title">Descargar Actas Electorales</h5>
                        <p class="card-text">Una ves que concluya el voto electronico puede descargar las actas electorales.</p>
                        <button data-bs-toggle="modal" data-bs-target="#modelactas" class="btn btn-info">Generar <i class="mx-2 bi bi-file-earmark-pdf"></i></button>
                    </div>
                </div>
            </div>
            <!-- MESAS -->
            <div class="col-md-6 mb-2">
                <div class="card border border-warning border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Cartel de Mesas</h5>
                        <p class="card-text">Generar cartel enumerado de las mesas para pegar en la entrada del aula</p>
                        <a href="<?= route('actas.mesas') ?>" target="_blank" class="btn btn-warning">Mesas<i class="mx-2 bi bi-file-earmark-pdf"></i></a>
                    </div>
                </div>
            </div>
            <!-- lista de entrada -->
            <div class="col-md-6 mb-2">
                <div class="card border border-success border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Relación de Electores (ENTRADA)</h5>
                        <p class="card-text">Descargar lista de los electores para ser pegado en la entrada del aula de votación.</p>
                        <a href="#" class="btn btn-success">Generar<i class="mx-2 bi bi-file-earmark-pdf"></i></a>
                    </div>
                </div>
            </div>
            <!-- lista para mesa -->
            <div class="col-md-6 mb-2">
                <div class="card border border-danger border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Relación de Electores (MESA)</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-danger">Generar<i class="mx-2 bi bi-file-earmark-pdf"></i></a>
                    </div>
                </div>
            </div>
            <!-- Acta de Proclamación -->
            <div class="col-md-6 mb-2">
                <div class="card border border-primary border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Acta de Proclamación</h5>
                        <p class="card-text">Es un modelo de acta de proclamación en archivo word para modificar con los datos generados con los resultados del voto electrónico.</p>
                        <a href="#" class="btn btn-primary">Descargar<i class="mx-2 bi bi-file-earmark-word"></i></a>
                    </div>
                </div>
            </div>
            <!-- Generar credencial -->
            <div class="col-md-6 mb-2">
                <div class="card border border-dark border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Generar Credenciales</h5>
                        <p class="card-text">Generar Credenciales para los ganadores del Municipio Escolar y ser entregado en acto protocolar.</p>
                        <a href="#" class="btn btn-dark">Descargar<i class="mx-2 bi bi-file-earmark-pdf"></i></a>
                    </div>
                </div>
            </div>
            <!-- datos finales -->
            <div class="col-md-6 mb-2">
                <div class="card border border-info border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Diveros archivos</h5>
                        <p class="card-text">Descargar archivos divesos como fuente de apoyo para relalizar las elecciones municipales Escolares.</p>
                        <a href="#" class="btn btn-info">Descargar<i class="mx-2 bi bi-file-earmark-zip"></i></a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</main>


<!-- Modal ACTAS-->
<div class="modal fade" id="modelactas" tabindex="-1" aria-labelledby="modelactasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modelactasLabel">Generar Actas Electorales</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Selecciones la mesa de votación para generar las actas electorales.
                <div class="input-group my-3 px-3">
                    <label class="input-group-text" for="inputGroupSelect01"><i class="bi bi-list-columns-reverse"></i></label>
                    <select class="form-select" id="inputGroupSelect01" name="mesa">
                        <option value="">Seleccione..</option>
                        <?php foreach ($mesas as $mesa) : ?>
                            <option value="<?= $mesa->id ?>"><?= $mesa->group_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="" class="btn btn-primary" id="bottonmesa">Generar</a>
                <!-- <button type="button" class="btn btn-primary" id="bottonmesa">Generar</button> -->
            </div>
        </div>
    </div>
</div>

<?php include ext('layoutDash.footer') ?>

<script>
    window.onload = function(event) {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
        });
        toastList.forEach(toast => toast.show());
    }

    let select = document.getElementById('inputGroupSelect01');
    let button = document.getElementById('bottonmesa');

    select.addEventListener('change', function() {
        if (select.value != '') {
            //add target="_blank"
            button.setAttribute('target', '_blank"');
            button.href = "<?= route('actas.create') ?>" + '?mesa=' + select.value;
        } else {
            button.href = "<?= route('actas.create') ?>" + '?mesa=' + select.value;
        }
    });

    button.href = "<?= route('actas.create') ?>" + '?mesa=';
</script>