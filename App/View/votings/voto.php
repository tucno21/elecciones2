<!doctype html>
<html lang="es" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="<?= base_url('/assets/img/qricon.png') ?>" />
    <title><?= isset($title) ? $title : 'Voto Electrónico' ?></title>
    <link href="<?= base_url ?>/assets/plugins/bootstrap/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('/assets/css/icon/bootstrap-icons.css') ?>">

    <style>
        .grid-elecciones {
            display: grid;
            min-height: 100vh;
            grid-template-rows: auto 1fr auto;
        }

        .bg-fondo {
            background-color: <?= $school->color ?>25;
        }

        .bg-header {
            background-color: <?= $school->color ?>;
            color: <?= $school->colorletter ?>;
            /* sombra */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .bg-footer {
            /* //color opacity */
            background-color: <?= $school->color ?>;
            color: #fff;
        }

        .text-shadow {
            text-shadow: 2px 5px 8px #222;
        }

        .png-shadow {
            filter: drop-shadow(2px 5px 5px #222);
        }

        .text-centerXY {
            display: flex;
            justify-content: center;
            align-items: center;
            /* eliminar borde */
            border: 0;
        }

        .color-texto-muted {
            color: <?= $school->colorletter ?>80;
        }

        /* .btn-check:checked+.btn {
            background-color: <?= $school->color ?>;
            color: #fff;
        } */
        /* .image {
            width: 100%;
            height: 100%;
        } */

        .check-x {
            position: relative;
        }

        .check-x::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            height: 120%;
            width: 0.3rem;
            background-color: #000;
        }

        .check-x::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            height: 120%;
            width: 0.3rem;
            background-color: #000;
        }

        .px-6 {
            padding-right: 4rem !important;
            padding-left: 4rem !important;
        }

        .color-bot {
            background-color: <?= $school->color ?>90;
            border: 1px solid <?= $school->color ?>;
        }

        .centermain {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body class="grid-elecciones bg-fondo">
    <header class="bg-header">
        <div class="container-fluid ">

            <div class="row ">
                <div class="col-sm-3 text-center text-sm-end my-auto">
                    <img src="<?= base_url('/assets/img/' . $school->photo) ?>" class="png-shadow" style="width:4rem;" alt="...">
                </div>

                <div class="col-sm-6 text-center my-auto py-2">
                    <h1 class="fs-5 text-shadow">
                        <i class="bi bi-qr-code-scan"></i>
                        VOTO ELECTRÓNICO <?= date('Y'); ?>
                        <i class="bi bi-qr-code-scan"></i>
                    </h1>
                    <h2 class="fs-3 text-uppercase fw-bold text-shadow">I.E. <?= $school->name; ?></h2>
                </div>

                <div class=" col-sm-3 text-center text-sm-start my-auto">
                    <img src="<?= base_url('/assets/img/escudo.png') ?>" class="png-shadow expand" style="width:4rem;" alt="...">
                </div>
            </div>
        </div>
    </header>

    <main class="mb-2 centermain">
        <div class="">
            <div class="container text-center mt-2 p-4">
                <h2>Bienvenido(a): <span class="fw-bold"><?= session()->get('student')->fullname ?></span></h2>
                <h4>DNI: <span class="fw-bold"><?= session()->get('student')->dni ?></span></h4>
                <div class="row">

                    <p class="fs-6 m-0 px-2">Elige al alcalde o alcaldeza Escolar para el siguiente año, tu voto, el ejercicio del porder elegir a quien te represente</p>

                </div>
            </div>

            <div class="container p-3 p-md-0">
                <form method="POST" action="<?= route('votings.candidate') ?>" id="formVotar">
                    <?= csrf() ?>
                    <?php foreach ($candidatos as $cand) : ?>

                        <div class="row">
                            <!-- nombre del grupo -->
                            <div class="border col-8 border-secondary d-grid p-0">
                                <input type="radio" class="btn-check" name="candidate_id" id="<?= $cand->id; ?>" autocomplete="off" value="<?= $cand->id; ?>">
                                <label class="btn btn-outline-secondary text-uppercase text-centerXY" for="<?= $cand->id; ?>">
                                    <?= $cand->group_name; ?>
                                </label>
                            </div>
                            <!-- logo del candidato -->
                            <div class="border col-2 border-secondary d-flex justify-content-center ">
                                <label for="<?= $cand->id; ?>">
                                    <img class="p-1" style="width:4.5rem;" src="<?= base_url('/assets/img/' . $cand->logo) ?>" alt="foto">
                                </label>
                            </div>
                            <!-- foto del candidato -->
                            <div class="border col-2 border-secondary d-flex justify-content-center ">
                                <label for="<?= $cand->id; ?>">
                                    <img class="p-1" style="width:4.5rem;" src="<?= base_url('/assets/img/' . $cand->photo) ?>" alt="foto">
                                </label>
                            </div>
                        </div>

                    <?php endforeach; ?>
                    <input type="hidden" name="id" value="<?= session()->get('student')->id ?>">


                    <div class="mt-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-dark color-bot fs-5 px-6">Votar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="bg-footer mt-2">
        <div class="container text-center p-2">
            <p class="color-texto-muted m-0">Dev: Ideasweb21 © 2022 - Todos los derechos reservados</p>
        </div>
    </footer>

    <script src="<?= base_url ?>/assets/plugins/bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="<?= base_url('/assets/js/sweetalert2.js') ?>"></script>

    <script>
        let btnCheck = document.querySelectorAll('.btn-check');

        btnCheck.forEach((btn) => {
            btn.addEventListener('change', (e) => {
                //eliminar clase check-x de todos los elementos
                btnCheck.forEach((btn) => {
                    // acceder a su apdre
                    let padre = btn.parentNode;
                    //acceder a todos sus hermanos
                    let hermano1 = padre.nextElementSibling;
                    let hermano2 = hermano1.nextElementSibling;
                    //eliminar clase check-x
                    padre.classList.remove('check-x');
                    hermano1.classList.remove('check-x');
                    hermano2.classList.remove('check-x');
                });


                //acceder a su padre
                let padre = e.target.parentNode;
                //acceder a su hermano
                let hermano1 = padre.nextElementSibling;
                let hermano2 = hermano1.nextElementSibling;
                hermano1.classList.add('check-x');
                hermano2.classList.add('check-x');
            });
        });

        const formVotar = document.getElementById('formVotar');
        formVotar.addEventListener('submit', (e) => {
            e.preventDefault();
            // acceder a data
            let data = new FormData(formVotar);
            //id
            let candidate_id = data.get('candidate_id');

            if (candidate_id == null) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debes elegir una opción',
                });
            } else {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esta acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, votar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formVotar.submit();
                    }
                })
            }
        });
    </script>

</body>

</html>