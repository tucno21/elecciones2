<?php

// DATOS GENERALES ADMIN
$title = 'Elecciones ' . date('Y');
$titleShort = 'H';
$mainLink = base_url('/dashboard');
$logoAdmin = '../public/logo/logo.png';

//DATOS DEL USUARIO ADMIN
$userName = session()->user()->fullname;



//MENU CERRAR O PERFIL DE ADMINISTRADOR
$menuSession = [
    [
        'text' => 'Logout',
        'url'  => route('login.logout'),
        'icon' => 'bi bi-box-arrow-right',
    ],
];



//CREACION DE ENLACES PARA EL MENU SIDEBAR
$linksSidebar = [
    ['header' => 'Navegación',],
    [
        'mode' => 'menu',
        'text' => 'Dashboard',
        'url'  => '/',
        'icon' => 'bi bi-speedometer2',
    ],
    [
        'mode' => 'submenu',
        'text'    => 'Usuarios',
        'url'    => '#',
        'icon' => 'bi bi-person-lines-fill',
        'submenu' => [
            [
                'text' => 'Usuarios',
                'url'  => route('users.index'),
                'icon' => 'fas fa-circle',
            ],
            [
                'text' => 'Roles',
                'url'  => route('roles.index'),
                'icon' => 'fas fa-circle',
            ],
            [
                'text' => 'Permisos',
                'url'  => route('permissions.index'),
                'icon' => 'fas fa-circle',
            ],
            [
                'text' => 'Instituciones',
                'url'  => route('schools.index'),
                'icon' => 'bi bi-house-fill',
            ],
        ],
    ],
    [
        'mode' => 'menu',
        'text' => 'Mi Institución',
        'url'  => route('schools.myschool'),
        'icon' => 'bi bi-house-door',
    ],
    [
        'mode' => 'menu',
        'text' => 'Mesa Sufragio',
        'url'  => route('votinggroups.index'),
        'icon' => 'bi bi-list-task',
    ],
    [
        'mode' => 'menu',
        'text' => 'Estudiantes',
        'url'  => route('students.index'),
        'icon' => 'bi bi-people',
    ],
    [
        'mode' => 'menu',
        'text' => 'Roles Estudiantes',
        'url'  => route('studentroles.index'),
        'icon' => 'bi bi-sliders2-vertical',
    ],
    [
        'mode' => 'menu',
        'text' => 'Candidatos',
        'url'  => '/charts',
        'icon' => 'bi bi-person-workspace',
    ],
];



//ENLACES PARA CSS Y JS html
$linkURL = base_url;

$linksCss = [
    $linkURL . '/assets/css/bootstrap.css',
    $linkURL . '/assets/css/icon/bootstrap-icons.css',
    $linkURL . '/assets/plugins/flatpickr/flatpickr.min.css',
];

$linksScript = [
    $linkURL . '/assets/js/feather.min.js',
    $linkURL . '/assets/js/bootstrap.bundle.js',
    $linkURL . '/assets/js/scripts.js',
    $linkURL . '/assets/js/sb-customizer.js',
    $linkURL . '/assets/js/sweetalert2.js',
    $linkURL . '/assets/js/visorfoto.js',
    $linkURL . '/assets/plugins/flatpickr/flatpickr.js',
    $linkURL . '/assets/js/fecha.js',
];
