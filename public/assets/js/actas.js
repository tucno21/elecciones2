window.onload = function (event) {
    var toastElList = [].slice.call(document.querySelectorAll('.toast'))
    var toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl)
    });
    toastList.forEach(toast => toast.show());
}

//generar actas
let select = document.getElementById('inputGroupSelect01');
let button = document.getElementById('bottonmesa');
let href = button.getAttribute('href');
select.addEventListener('change', function () {
    if (select.value != '') {
        button.setAttribute('target', '_blank"');
        button.setAttribute('href', href + select.value);
    } else {
        button.removeAttribute('target');
        button.setAttribute('href', href + select.value);
    }
});


//generar relacion entrada
let select2 = document.getElementById('inputGroupSelect02');
let button2 = document.getElementById('bottonrelacionentrada');
let href2 = button2.getAttribute('href');
select2.addEventListener('change', function () {
    if (select2.value != '') {
        button2.setAttribute('target', '_blank"');
        button2.setAttribute('href', href2 + select2.value);
    } else {
        button2.removeAttribute('target');
        button2.setAttribute('href', href2 + select2.value);
    }
});

//generar relacion mesa
let select3 = document.getElementById('inputGroupSelect03');
let button3 = document.getElementById('bottonrelacionMesa');
let href3 = button3.getAttribute('href');
select3.addEventListener('change', function () {
    if (select3.value != '') {
        button3.setAttribute('target', '_blank"');
        button3.setAttribute('href', href3 + select3.value);
    } else {
        button3.removeAttribute('target');
        button3.setAttribute('href', href3 + select3.value);
    }
});

//generar credencial
let button4 = document.getElementById('bottoncredencial');
let href4 = button4.getAttribute('href');
button4.addEventListener('click', function () {
    let nameStudent = document.getElementById('nameStudent').value;
    let cargo = document.getElementById('cargo').value;
    let fecha = document.getElementById('fecha').value;
    if (nameStudent != '' && cargo != '' && fecha != '') {
        //add target="_blank"
        button4.setAttribute('target', '_blank"');
        button4.setAttribute('href', href4 + '?nameStudent=' + nameStudent + '&cargo=' + cargo + '&fecha=' + fecha);
    } else {
        //elimanr target="_blank"
        button4.removeAttribute('target');
        button4.setAttribute('href', href4 + '?nameStudent=' + nameStudent + '&cargo=' + cargo + '&fecha=' + fecha);
    }
});