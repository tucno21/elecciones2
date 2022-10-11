const reiniciarVoto = document.querySelector('#reiniciarVoto');
reiniciarVoto.addEventListener('click', (e) => {
    //detener el evento
    e.preventDefault();
    //url <a></a> href
    const url = e.target.href;
    Swal.fire({
        title: 'Desea reiniciar el voto?',
        text: "Esta accion no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, reiniciar!'
    }).then((result) => {
        if (result.isConfirmed) {
            //ejecutar url
            window.location.href = url;
        }
    });
});

const deleteStudents = document.querySelector('#deleteStudents');
deleteStudents.addEventListener('click', (e) => {
    //detener el evento
    e.preventDefault();
    //url <a></a> href
    const url = e.target.href;
    Swal.fire({
        title: 'Desea eliminar los estudiantes?',
        text: "Esta accion no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            //ejecutar url
            window.location.href = url;
        }
    });
});