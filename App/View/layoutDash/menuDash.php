<?php

// DATOS GENERALES ADMIN
$title = 'Voto Electronico ' . date('Y');
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
    can('dashboard.index') ?
        [
            'mode' => 'menu',
            'text' => 'Dashboard',
            'url'  => route('dashboard.index'),
            'icon' => 'bi bi-speedometer2',
        ] : null,
    can('users.index')  ?
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
        ] : null,
    can('schools.myschool')  ?
        [
            'mode' => 'menu',
            'text' => 'Mi Institución',
            'url'  => route('schools.myschool'),
            'icon' => 'bi bi-house-door',
        ] : null,
    can('votinggroups.index')  ?
        [
            'mode' => 'menu',
            'text' => 'Mesa Sufragio',
            'url'  => route('votinggroups.index'),
            'icon' => 'bi bi-list-task',
        ] : null,
    can('students.index')  ?
        [
            'mode' => 'menu',
            'text' => 'Estudiantes',
            'url'  => route('students.index'),
            'icon' => 'bi bi-people',
        ] : null,
    can('studentroles.index')  ?
        [
            'mode' => 'menu',
            'text' => 'Roles Estudiantes',
            'url'  => route('studentroles.index'),
            'icon' => 'bi bi-sliders2-vertical',
        ] : null,
    can('candidates.index')  ?
        [
            'mode' => 'menu',
            'text' => 'Candidatos',
            'url'  => route('candidates.index'),
            'icon' => 'bi bi-person-workspace',
        ] : null,
    can('actas.index')  ?
        [
            'mode' => 'menu',
            'text' => 'Materiales y Actas',
            'url'  => route('actas.index'),
            'icon' => 'bi bi-file-earmark-pdf',
        ] : null,
];



//ENLACES PARA CSS Y JS html

$linksCss = [
    base_url . '/assets/css/bootstrap.css',
    base_url . '/assets/css/icon/bootstrap-icons.css',
    base_url . '/assets/plugins/flatpickr/flatpickr.min.css',
];

$linksScript = [
    base_url . '/assets/js/feather.min.js',
    base_url . '/assets/js/bootstrap.bundle.js',
    base_url . '/assets/js/scripts.js',
    base_url . '/assets/js/sb-customizer.js',
    base_url . '/assets/js/sweetalert2.js',
    base_url . '/assets/plugins/flatpickr/flatpickr.js',
    base_url . '/assets/js/fecha.js',

];
