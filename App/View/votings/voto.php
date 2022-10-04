<!doctype html>
<html lang="es" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/icon/bootstrap-icons.css">

    <style>
        .bg-fondo {
            background-color: <?= $school->color ?>25;
        }

        .bg-header {
            background-color: <?= $school->color ?>;
            color: #fff;
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
    </style>
</head>

<body class="d-flex h-100">
    <div class="d-flex flex-column w-100 bg-fondo">
        <header class="bg-header">
            <div class="container-fluid ">

                <div class="row ">
                    <div class="col-3 text-end my-auto">
                        <img src="<?= base_url('/assets/img/' . $school->photo) ?>" class="png-shadow" style="width:4rem;" alt="...">
                    </div>

                    <div class="col-6 text-center my-auto py-2">
                        <h1 class="fs-5 text-shadow">
                            <i class="bi bi-qr-code-scan"></i>
                            VOTO ELECTRÓNICO <?= date('Y'); ?>
                            <i class="bi bi-qr-code-scan"></i>
                        </h1>
                        <h2 class="fs-3 text-uppercase fw-bold text-shadow">I.E. <?= $school->name; ?></h2>
                    </div>

                    <div class=" col-3 text-start my-auto">
                        <img src="<?= base_url('/assets/img/escudo.png') ?>" class="png-shadow expand" style="width:4rem;" alt="...">
                    </div>
                </div>
            </div>
        </header>

        <main class="mb-2">
            <div class="container text-center mt-2 p-4">
                <h2>Bienvenido(a): <span class="fw-bold"><?= session()->get('student')->fullname ?></span></h2>
                <h4>DNI: <span class="fw-bold"><?= session()->get('student')->dni ?></span></h4>
                <div class="row px-6">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <p class="fs-6">Elige al alcalde o alcaldeza escolar para el siguiente año, tu voto vale mucho y
                            vota a conciencia</p>
                    </div>
                    <div class="col-2"></div>
                </div>
            </div>

            <div class="container">
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
        </main>

        <footer class="mt-auto bg-footer">
            <div class="container text-center p-2">
                <p class="text-white-50 m-0">Dev: Ideasweb21 © 2022 - Todos los derechos reservados</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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