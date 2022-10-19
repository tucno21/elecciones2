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

        .border-primary {
            border-color: <?= $school->color ?> !important;
        }

        .color-texto-muted {
            color: <?= $school->colorletter ?>80;
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
            <div class="container text-center mt-2">
                <h2>Mesa de Votación: <span class="fw-bold"><?= session()->user()->group_name ?></span></h2>

                <div class="row">
                    <p class="p-0 fw-bold"><?= $school->message; ?></p>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <video id="visualizadorVideo" class="border border-3 border-primary rounded" width="35%"></video>

                        <input type="hidden" name="text" id="codigoQR">

                        <p class="p-0">Acerca tu identificacion QR a la camara</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-footer">
        <div class="container text-center p-2">
            <p class="color-texto-muted m-0">Dev: Ideasweb21 © 2022 - Todos los derechos reservados</p>
        </div>
    </footer>

    <script>

    </script>

    <!-- <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> -->
    <script type="text/javascript" src="<?= base_url ?>/assets/plugins/instascan/instascan.min.js"></script>

    <script src="<?= base_url ?>/assets/plugins/bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('/assets/js/sweetalert2.js') ?>"></script>

    <script>
        let expand = document.querySelector('.expand');
        expand.addEventListener('click', () => {
            //maximizar la ventana
            if (document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                document.documentElement.requestFullscreen();
            }
        });


        let scanner = new Instascan.Scanner({
            video: document.getElementById('visualizadorVideo')
        });

        Instascan.Camera.getCameras().then(function(cameras) {
            // console.log(cameras);
            if (cameras.length > 0) {
                // iniciar la camara
                scanner.start(cameras[0]);
            } else {
                alert('No se encontraron cámaras');
            }

        }).catch(function(e) {
            console.error(e);
        });

        // captura y envia el codigo
        scanner.addListener('scan', async function(c) {
            //agregar sonido
            let audio = new Audio('<?= base_url('/assets/sound/beep.mp3') ?>');
            audio.play();
            // url buscar el codigo
            const url = "<?= route('votings.search') . '?codigo=' ?>" + c;

            const resp = await fetch(url, {
                method: "GET",
                mode: "cors",
                cache: "no-cache",
            });

            const resultado = await resp.json();

            if (resultado.status) {
                // console.log(resultado.data.fullname);
                Swal.fire({
                    title: 'Tus datos son correctos?',
                    text: resultado.data.fullname + ' - DNI: ' + resultado.data.dni,
                    icon: 'question',
                    cancelButtonColor: '#d33',
                    confirmButtonColor: '#3085d6',
                    showCancelButton: true,
                    confirmButtonText: 'Si, votar!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true

                }).then((result) => {
                    if (result.isConfirmed) {

                        window.location.href = "<?= route('votings.candidate') ?>";
                    }
                })

            } else {
                //resultado.data is string
                if (typeof resultado.data === 'string') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: resultado.data,
                    })
                }

                if (resultado.data.cerrar) {
                    //preguntar si desea cerrar votacion
                    Swal.fire({
                        title: 'Voto Electronico',
                        text: "¿Desea cerrar la mesa de votación?",
                        icon: 'question',
                        cancelButtonColor: '#d33',
                        confirmButtonColor: '#3085d6',
                        showCancelButton: true,
                        confirmButtonText: 'Si, cerrar!',
                        cancelButtonText: 'No, cancelar!',
                        reverseButtons: true

                    }).then((result) => {
                        if (result.isConfirmed) {
                            //redirect to close
                            window.location.href = "<?= route('votings.close') ?>";
                        }
                    })
                }
            }
        });
    </script>
</body>

</html>