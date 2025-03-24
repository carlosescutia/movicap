<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="<?=base_url()?>img/favicon.svg"/>

        <title><?= $nom_sitio_corto ?? 'Lorem ipsum' ?></title>

        <!-- global css -->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/admin.css" />

        <!-- bootstrap 5.3 -->
        <link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?=base_url()?>css/bootstrap-icons.css" rel="stylesheet"/>
        <script src="<?=base_url()?>js/bootstrap.bundle.min.js"></script>

        <!-- jquery -->
        <script src="<?=base_url()?>js/jquery-3.6.3.min.js"></script>

        <!-- touchswipe -->
        <script type="text/javascript" src="<?=base_url()?>js/jquery.touchSwipe.min.js"></script>
    <!--
        <script src="https://code.jquery.com/mobile/1.5.0-rc1/jquery.mobile-1.5.0-rc1.js"></script>
-->

        <!-- leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <link rel="stylesheet" href="<?=base_url()?>js/Control.FullScreen.css" />
        <script src="<?=base_url()?>js/Control.FullScreen.js"></script>

    </head>
    <body>
        <nav class="navbar navbar-expand-sm navbar-light fixed-top d-print-block pr-3">

            <div class="container-fluid">
                <!-- logo -->
                <div class="logo_menu">
                    <img class="logo" src="<?=base_url()?>img/<?= $logo_org_sitio ?? 'logotipo.png' ?>" class="d-inline-block align-top" alt="logo">
                </div>
                <!-- titulo -->
                <div class="titulo_menu">
                    <h4 class="texto-titulo"><?= $nom_sitio_corto ?? 'Lorem ipsum' ?></h4>
                </div>

                <!-- boton para menu colapsado (pantallas pequeñas) -->
                <button class="navbar-toggler navbar-toggler-right pr-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" >
                    <span class="navbar-toggler-icon"></span>
                </button> <!-- boton menu -->

                <!-- opciones del menu -->
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="col-sm-7 mt-2">
                        <h5 class="texto-titulo"><?= $nom_sitio_largo ?? 'Lorem ipsum' ?></h5>
                        <hr class="mb-0 mt-2 pt-0 pb-0 " />
                        <ul class="navbar-nav mr-auto">
                            <?php
                                $permisos_requeridos = array(
                                'cuestionario.can_view',
                                );
                                if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                    <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?>cuestionario">Proyectos</a></li>
                                <?php }
                            ?>
                            <?php
                                $permisos_requeridos = array(
                                'reportes.can_view',
                                );
                                if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                    <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?>reportes">Reportes</a></li>
                                <?php }
                            ?>
                            <?php
                                $permisos_requeridos = array(
                                'catalogos.can_view',
                                );
                                if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                                    <li class="nav-item d-print-none"><a class="nav-link" href="<?=base_url()?>catalogos">Catalogos</a></li>
                                <?php }
                            ?>
                        </ul>
                    </div>
                    <div class="col-sm-5 text-end">
                        <p class="m-2 texto-titulo"><?php echo $nom_usuario ?> · <?php echo $nom_organizacion ?> | <a class="m-2 texto-titulo d-print-none" href="<?= base_url() ?>admin/cerrar_sesion">Cerrar sesión</a></p>
                    </div>
                </div> <!-- opciones del menu -->
            </div>

        </nav>

        <main role="main" class="container-fluid col-sm-12 px-4">
