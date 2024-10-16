<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="<?=base_url()?>img/favicon.png" sizes="16x16" type="image/png" />

        <title><?= $nom_sitio_corto ?? 'Lorem ipsum' ?></title>

        <!-- global css -->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/publico.css" />

        <!-- bootstrap 5.3 -->
        <link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?=base_url()?>css/bootstrap-icons.css" rel="stylesheet"/>
        <script src="<?=base_url()?>js/bootstrap.bundle.min.js"></script>

        <!-- jquery -->
        <script src="<?=base_url()?>js/jquery-3.6.3.min.js"></script>

    </head>
    <body>
        <nav class="navbar navbar-expand-sm navbar-light fixed-top d-print-block pr-3">

            <div class="col-sm-8 offset-sm-2 container-fluid">
                <div class="logo_menu">
                    <img class="logo" src="<?=base_url()?>img/<?= $logo_org_sitio ?? 'logotipo.png' ?>" class="d-inline-block align-top" alt="logo">
                </div>
                <div class="titulo_menu">
                    <h4 class="texto-titulo"><?= $nom_sitio_corto ?? 'Lorem ipsum' ?></h4>
                </div>

                <button class="navbar-toggler navbar-toggler-right pr-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="col-sm-7 mt-2">
                        <h5 class="texto-titulo"><?= $nom_sitio_largo ?? 'Lorem ipsum' ?></h5>
                        <hr class="mb-0 mt-2 pt-0 pb-0 " />
                        <ul class="navbar-nav mr-auto">
                            <?php foreach ($opciones_publicas as $opciones_publicas_item) { ?>
                                <li class="nav-item"><a class="nav-link" href="<?=base_url()?><?=$opciones_publicas_item['url'] ?>"><?=$opciones_publicas_item['nombre'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

        </nav>

        <main role="main" class="container-fluid col-sm-8 offset-sm-2">
