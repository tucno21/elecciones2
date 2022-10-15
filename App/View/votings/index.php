<!doctype html>
<html lang="es" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $title : 'Voto Electrónico' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('/assets/img/qricon.png') ?>" />
    <link href="<?= base_url ?>/assets/plugins/bootstrap/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('/assets/css/icon/bootstrap-icons.css') ?>">

    <style>
        .bg-fondo {
            background-color: <?= $school->color ?>25;
        }

        .bg-header {
            background-color: <?= $school->color ?>;
            color: <?= $school->colorletter ?>;
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

        .color-texto-muted {
            color: <?= $school->colorletter ?>80;
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

        <main class="">
            <div class="container text-center mt-2 p-4">
                <h2>N° DE MESA : <span class="fw-bold"><?= session()->user()->group_name ?></span></h2>
                <div class="row">
                    <p class="fs-2 text-secondary pt-2">Presidente(a) de Mesa</p>
                </div>
                <div class="row p-2">
                    <h4 class="fs-1 fw-bold"><?= session()->user()->fullname ?></h4>
                </div>
                <div class="row px-6">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <p class="fs-6">Puedes activar la mesa de votación para todos los electores que estan en el
                            padrón electoral</p>
                    </div>
                    <div class="col-2"></div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <form id="formInicio" action="<?= route('votings.create') ?>" method="POST">
                            <?= csrf() ?>

                            <input type="hidden" name="date_start">
                            <input type="hidden" name="student_id" value="<?= session()->user()->id ?>">

                            <button class="btn btn-dark px-4 py-2">Iniciar con el Voto Electronico</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <footer class="mt-auto bg-footer">
            <div class="container text-center p-2">
                <p class="color-texto-muted m-0">Dev: Ideasweb21 © 2022 - Todos los derechos reservados</p>
            </div>
        </footer>
    </div>

    <script src="<?= base_url ?>/assets/plugins/bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('/assets/js/sweetalert2.js') ?>"></script>

    <script>
        let expand = document.querySelector('.expand');
        //ejecutar f11 automaticamente
        expand.addEventListener('click', () => {
            if (document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                document.documentElement.requestFullscreen();
            }
        });


        let datatime = new Date();
        //solo hora am/pm
        let hora = datatime.toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: 'numeric',
            hour12: true
        });

        let formInicio = document.querySelector('#formInicio');
        formInicio.addEventListener('submit', (e) => {
            e.preventDefault();

            //sweetalert2
            Swal.fire({
                title: 'Inicio de Voto Electronico',
                text: hora,
                // icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Si, iniciar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // hora_inicio Y-m-d H:i:s
                    let date = new Date();
                    let dateTime = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

                    let inputHoraInicio = document.querySelector('input[name="date_start"]');
                    inputHoraInicio.value = dateTime;


                    formInicio.submit();
                }
            })
        });
    </script>
</body>

</html>