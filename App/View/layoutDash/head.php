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

    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />

    <?php foreach ($linksCss as $value) : ?>
        <link href="<?= $value ?>" rel="stylesheet" />
    <?php endforeach; ?>
</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
        <!-- Sidenav Toggle Button-->
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle">
            <i class="bi bi-list text-dark"></i>
        </button>
        <!-- Navbar Brand-->
        <!-- * * Tip * * You can use text or an image for your navbar brand.-->
        <!-- * * * * * * When using an image, we recommend the SVG format.-->
        <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
        <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="<?= $mainLink ?>"><?= $title ?></a>
        <!-- Navbar Search Input-->
        <!-- * * Note: * * Visible only on and above the lg breakpoint-->
        <form class="form-inline me-auto d-none d-lg-block me-3">
            <div class="input-group input-group-joined input-group-solid">
                <input class="form-control pe-0" type="search" placeholder="Search" aria-label="Search" />
                <div class="input-group-text">
                    <i class="bi bi-search"></i>
                </div>
            </div>
        </form>
        <!-- Navbar Items-->
        <ul class="navbar-nav align-items-center ms-auto">

            <!-- Navbar Search Dropdown-->
            <!-- * * Note: * * Visible only below the lg breakpoint-->
            <li class="nav-item dropdown no-caret me-3 d-lg-none">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="searchDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-search"></i></a>
                <!-- Dropdown - Search-->
                <div class="dropdown-menu dropdown-menu-end p-3 shadow animated--fade-in-up" aria-labelledby="searchDropdown">
                    <form class="form-inline me-auto w-100">
                        <div class="input-group input-group-joined input-group-solid">
                            <input class="form-control pe-0" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                            <div class="input-group-text"><i class="bi bi-search"></i></div>
                        </div>
                    </form>
                </div>
            </li>

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
                        <!-- Sidenav Menu Heading (Account)-->
                        <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                        <div class="sidenav-menu-heading d-sm-none">Account</div>
                        <!-- Sidenav Link (Alerts)-->
                        <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                        <a class="nav-link d-sm-none" href="#!">
                            <div class="nav-link-icon">
                                <i class="bi bi-bell"></i>
                            </div>
                            Alerts
                            <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
                        </a>
                        <!-- Sidenav Link (Messages)-->
                        <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                        <a class="nav-link d-sm-none" href="#!">
                            <div class="nav-link-icon"><i class="bi bi-envelope"></i></div>
                            Messages
                            <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                        </a>
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