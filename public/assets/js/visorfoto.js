//seleccionar input file
let visorFoto = document.querySelector('.visorFoto');

visorFoto.addEventListener('change', function (e) {

    let file = e.target.files[0];
    //validar que sea una imagen
    if (file["type"] != "image/jpg" && file["type"] != "image/png" && file["type"] != "image/jpeg") {
        visorFoto.value = '';
        Swal.fire({
            title: "Error al subir imagen",
            text: "la imagen debe ser de formato JPQ o PNG",
            icon: "error",
            confirmButtonText: "Cerrar"
        });
        //validar tamaño de la imagen
    } else if (file["size"] > 1000000) {
        visorFoto.value = '';
        Swal.fire({
            title: "Error de tamaño de imagen",
            text: "la imagen no debe pesar mas de 1MB",
            icon: "error",
            confirmButtonText: "Cerrar"
        });
    } else {
        //clase de js hace lectura de archivo
        var datosImagen = new FileReader;
        //leer como dato url la imagen cargada
        datosImagen.readAsDataURL(file);
        //cuando la imagen este cargada
        datosImagen.addEventListener('load', function (event) {
            //asignar la imagen al elemento img
            document.querySelector('.previsualizar').setAttribute('src', event.target.result);
        });
    }
});


