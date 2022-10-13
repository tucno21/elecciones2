<?php
$linksScript2 = [
    base_url . '/assets/js/visorfoto.js',
];
?>
<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Editar Candidato</h2>
        <hr class="mt-0 mb-4" />



        <div class="mx-auto card">
            <div class="card-header">
                <a class="btn btn-outline-dark btn-sm" href="<?= route('candidates.index') ?>">Volver</a>
            </div>

            <form action="<?= route('candidates.edit') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf() ?>

                <div class="card-body row p-4">
                    <?php include_once 'imputs.php' ?>
                </div>

                <div class="text-center card-footer">
                    <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                </div>
            </form>
        </div>

    </div>
</main>
<?php include ext('layoutDash.footer') ?>