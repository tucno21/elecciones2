<?php include ext('layoutDash.head') ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-2 mb-0">Panel de Roles Pare Estudiantes</h2>
        <hr class="mt-0 mb-4" />



        <div class="row px-3">
            <div class="col-12">
                <h3>Mesa N° : <?= $mesa->group_name ?></h3>
            </div>

            <div class="p-2 mb-2">
                <a href="<?= route('votinggroups.index') ?>" class="btn btn-outline-dark btn-sm">Regresar a Mesas de sufragio</a>

                <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#miembroEstudiante">
                    Agregar Miembro de mesa
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Miembro</th>
                            <th scope="col">DNI</th>
                            <th scope="col">Nombre y Apellidos</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="mostrarMiembros">
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>


<!-- Modal -->
<div class="modal fade" id="miembroEstudiante" tabindex="-1" aria-labelledby="miembroEstudiante" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="miembroEstudiante">Miembro de Mesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route('members.create') ?>" method="POST" id="addMiembroMesa">

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-123"></i></span>
                        <input type="number" class="form-control" placeholder="Buscar por DNI" name="dni">
                        <button class="btn btn-outline-secondary" type="button" id="buscardni"><i class="bi bi-search"></i></button>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" placeholder="Estudiante" name="fullname">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-gear"></i></span>
                        <select class="form-select" name="studentrol_id">
                            <option selected>Seleccione...</option>
                            <!-- roles -->
                            <?php foreach ($roles as $rol) : ?>
                                <option value="<?= $rol->id ?>"><?= $rol->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" name="id">

                    <div class="text-center card-footer p-0 pb-3">
                        <button type="submit" class="btn btn-dark">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        iniciarApp();
    });

    function iniciarApp() {
        buscarData();

        buscarDni();

        addMiembroMesa();

        updateMiembroMesa();

        deleteMiembroMesa();
    }


    function buscarData() {
        const url = "<?= route('members.members') . '?id=' . $mesa->id  ?>";
        consultaMienbros(url);
    }

    async function consultaMienbros(url) {
        const resp = await fetch(url, {
            method: "GET",
            mode: "cors",
            cache: "no-cache",
        });

        const resultado = await resp.json();

        if (resultado.status) {
            // console.log(resultado.data);

            const miembros = resultado.data;
            const mostrarMiembros = document.querySelector('#mostrarMiembros');

            let i = 1;
            miembros.forEach(miembro => {
                const {
                    id,
                    fullname,
                    dni,
                    name
                } = miembro;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <th scope="row">${i}</th>
                    <td>${name}</td>
                    <td>${dni}</td>
                    <td>${fullname}</td>
                    <td>
                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#miembroEstudiante" id="updatemember" data-id="${id}">
                        <i class="bi bi-pencil"></i>
                        </button>

                        <button type="button" class="btn btn-outline-danger btn-sm" id="deletemember" data-id="${id}">
                        <i class="bi bi-trash3"></i>
                        </button>
                    </td>
                `;

                mostrarMiembros.appendChild(row);
                i++;
            });
        }
    }

    function buscarDni() {
        const btnBuscarDni = document.querySelector('#buscardni');
        btnBuscarDni.addEventListener('click', async () => {
            const dni = document.querySelector('input[name="dni"]').value;
            //url buscar dni u mesa
            const url = "<?= route('members.search') . '?dni=' ?>" + dni + "&mesa=" + <?= $mesa->id ?>;
            const resp = await fetch(url, {
                method: "GET",
                mode: "cors",
                cache: "no-cache",
            });

            const resultado = await resp.json();

            if (resultado.status) {
                const {
                    id,
                    fullname,
                } = resultado.data;

                document.querySelector('input[name="fullname"]').value = fullname;
                document.querySelector('input[name="id"]').value = id;
            } else {
                document.querySelector('input[name="dni"]').value = "";
                document.querySelector('input[name="fullname"]').value = '';
                document.querySelector('input[name="id"]').value = '';

                Swal.fire('No se encontro al estudiante o no pertenece a esta mesa');
            }
        });
    }

    function addMiembroMesa() {
        const form = document.querySelector('#addMiembroMesa');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const data = new FormData(form);

            const url = "<?= route('members.create') ?>";

            const resp = await fetch(url, {
                method: "POST",
                mode: "cors",
                cache: "no-cache",
                body: data
            });

            const resultado = await resp.json();

            if (resultado.status) {
                swal.fire({
                    text: "Cambios guardados correctamente",
                    type: "success"
                }).then(function() {
                    location.reload();
                })
                // Swal.fire('Miembro de mesa agregado correctamente');
                // form.reset();
                // document.querySelector('#mostrarMiembros').innerHTML = '';
                // buscarData();
            } else {
                Swal.fire('No se pudo agregar el miembro de mesa');
            }
        });
    }

    function updateMiembroMesa() {
        // esperar  medio segundo para que se cargue el dom
        setTimeout(() => {

            const btnUpdate = document.querySelectorAll('#updatemember');
            btnUpdate.forEach(btn => {
                btn.addEventListener('click', async () => {

                    const id = btn.getAttribute('data-id');
                    const url = "<?= route('members.student') . '?id=' ?>" + id;

                    const resp = await fetch(url, {
                        method: "GET",
                        mode: "cors",
                        cache: "no-cache",
                    });

                    const resultado = await resp.json();
                    // console.log(resultado);
                    if (resultado.status) {
                        const {
                            id,
                            fullname,
                            dni,
                            studentrol_id
                        } = resultado.data;

                        document.querySelector('input[name="fullname"]').value = fullname;
                        document.querySelector('input[name="dni"]').value = dni;
                        document.querySelector('input[name="id"]').value = id;
                        document.querySelector('select[name="studentrol_id"]').value = studentrol_id;
                    } else {
                        Swal.fire('No se encontro al estudiante');
                    }
                });
            });
        }, 700);
    }

    function deleteMiembroMesa() {
        // esperar  medio segundo para que se cargue el dom
        setTimeout(() => {

            const btnDelete = document.querySelectorAll('#deletemember');
            btnDelete.forEach(btn => {
                btn.addEventListener('click', async () => {

                    const id = btn.getAttribute('data-id');
                    const url = "<?= route('members.destroy') . '?id=' ?>" + id;
                    console.log(url);
                    const resp = await fetch(url, {
                        method: "GET",
                        mode: "cors",
                        cache: "no-cache",
                    });

                    const resultado = await resp.json();
                    // console.log(resultado);
                    if (resultado.status) {
                        //  location.reload(); esperar aceptar Swal.fire
                        swal.fire({
                            text: "Miembro de mesa eliminado correctamente",
                            type: "success"
                        }).then(function() {
                            location.reload();
                        })
                    } else {
                        Swal.fire('No se pudo eliminar el miembro de mesa');
                    }
                });
            });
        }, 700);

    }
</script>

<?php include ext('layoutDash.footer') ?>