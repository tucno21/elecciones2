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

            <div class="col-md-6 mb-2">
                <div class="card border border-success border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <div class="card border border-danger border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <div class="card border border-info border-4 border-top-0 border-end-0 border-bottom-0  shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
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