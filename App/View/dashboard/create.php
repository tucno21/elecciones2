<?php include ext('layoutdash.head') ?>
<main>
    <header class="py-2 mb-4 bg-gradient-primary-to-secondary">
        <div class="container-xl px-2">
            <div class="text-center">
                <h1 class="text-white">Welcome to SB Admin Pro</h1>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Dashboards</h2>
        <p>Three dashboard examples to get you started!</p>
        <hr class="mt-0 mb-4" />

        <div class="row">
            <form action="<?= route('dashboard.create') ?>" method="POST">
                <div class="row g-3">

                    <?php include_once 'imputs.php' ?>

                    <div class="col-md-12">
                        <button class="btn btn-lg btn-primary mt-3" type="submit">Crear Producto</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<?php include ext('layoutdash.footer') ?>