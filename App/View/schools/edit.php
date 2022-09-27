<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Editar Institución</h2>
        <hr class="mt-0 mb-4" />



        <div class="mx-auto card w-75">
            <div class="card-header">
                <a class="btn btn-outline-dark btn-sm" href="<?= route('schools.index') ?>">Volver</a>
            </div>

            <form action="<?= route('schools.edit') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf() ?>

                <div class="card-body">
                    <?php include_once 'imputs.php' ?>
                </div>

                <div class="text-center card-footer">
                    <button type="submit" class="btn btn-dark">Modificar</button>
                </div>
            </form>
        </div>

    </div>
</main>
<?php include ext('layoutDash.footer') ?>