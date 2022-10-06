<?php include ext('layoutDash.menuDash') ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= isset($titleHead) ? $titleHead : 'Elecciones ' . date('Y') ?></title>

    <link rel="icon" type="image/x-icon" href="<?= base_url('/assets/img/qricon.png') ?>" />

    <?php foreach ($linksCss as $value) : ?>
        <link href="<?= $value ?>" rel="stylesheet" />
    <?php endforeach; ?>

    <?php $dS = session()->user(); ?>

    <style>
        .color-dashboard {
            background-color: <?= isset($dS->color) ? $dS->color : '#ffffff' ?> !important;
            background-image: linear-gradient(135deg, <?= $dS->color ?> 0%, <?= $dS->color ?>25 100%) !important;
        }

        .color-footer {
            background-color: <?= isset($dS->color) ? $dS->color . '35' : '#ffffff' ?>;
        }

        .bg-mod {
            background-color: <?= isset($dS->color) ? $dS->color : '#ffffff' ?>;
            color: red;
        }

        .topnav.navbar-light .navbar-brand {
            color: <?= isset($dS->colorletter) ? $dS->colorletter : '#000' ?>;
        }

        .color-texto {
            color: <?= isset($dS->colorletter) ? $dS->colorletter : '#000' ?>;
        }

        .color-texto-muted {
            color: <?= isset($dS->colorletter) ? $dS->colorletter . '80' : '#000' ?>;
        }
    </style>

</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-mod" id="sidenavAccordion">
        <!-- Sidenav Toggle Button-->
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle">
            <i class="bi bi-list fs-4 color-texto"></i>
        </button>
        <!-- Navbar Brand-->
        <!-- * * Tip * * You can use text or an image for your navbar brand.-->
        <!-- * * * * * * When using an image, we recommend the SVG format.-->
        <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
        <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="<?= $mainLink ?>"><?= $title ?></a>

        <ul class="navbar-nav align-items-center ms-auto">


            <!-- User Dropdown-->
            <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                <a class="btn btn-icon bg-primary text-white dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!-- <img class="img-fluid" src="assets/img/illustrations/profiles/profile-1.png" /> -->
                    <i class="bi bi-person-circle fs-3"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <!-- <img class="dropdown-user-img" src="assets/img/illustrations/profiles/profile-1.png" /> -->
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name"><?= $userName ?></div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>

                    <?php foreach ($menuSession as $ms) : ?>
                        <a href="<?= $ms['url'] ?>" class="dropdown-item">
                            <div class="dropdown-item-icon">
                                <i class="<?= $ms['icon'] ?>"></i>
                            </div>
                            <?= $ms['text'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <!-- Sidenav Menu Heading (Core)-->

                        <?php foreach ($linksSidebar as $key => $value) : ?>
                            <!-- UNA SOLA LINEA - TITULO-->
                            <?php if (isset($value['header'])) : ?>
                                <div class="sidenav-menu-heading"><?= $value['header']; ?></div>
                            <?php endif; ?>
                            <!-- UNA SOLA LINEA - LINK-->
                            <?php if (isset($value['mode']) && $value['mode'] == 'menu') : ?>
                                <a href="<?= $value['url']; ?>" class="nav-link">
                                    <div class="nav-link-icon">
                                        <i class="<?= $value['icon']; ?>"></i>
                                    </div>
                                    <?= $value['text']; ?>
                                </a>
                            <?php endif; ?>
                            <!-- SUBMENUS - LINK-->
                            <?php if (isset($value['mode']) && $value['mode'] == 'submenu') : ?>
                                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#sidebar<?= $value['text']; ?>" aria-expanded="false" aria-controls="sidebar<?= $value['text']; ?>">
                                    <div class="nav-link-icon">
                                        <i class="<?= $value['icon']; ?>"></i>
                                    </div>
                                    <?= $value['text']; ?>
                                    <div class="sidenav-collapse-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="sidebar<?= $value['text']; ?>" data-bs-parent="#accordionSidenav">
                                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                        <?php foreach ($value['submenu'] as $subValue) : ?>
                                            <a href="<?= $subValue['url']; ?>" class="nav-link">
                                                <?= $subValue['text']; ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </nav>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </div>
                </div>
                <!-- Sidenav Footer-->
                <div class="sidenav-footer">
                    <div class="sidenav-footer-content">
                        <div class="sidenav-footer-subtitle">Conectado como:</div>
                        <div class="sidenav-footer-title"><?= $userName ?></div>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">