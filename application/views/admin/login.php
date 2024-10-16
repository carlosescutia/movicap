<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="<?=base_url()?>img/favicon.png" sizes="16x16" type="image/png" />

        <title><?= $nom_sitio_corto ?? 'Lorem ipsum' ?></title>

        <!-- global css -->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/admin.css" />

        <!-- bootstrap 5.3 -->
        <link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?=base_url()?>css/bootstrap-icons.css" rel="stylesheet"/>
        <script src="<?=base_url()?>js/bootstrap.bundle.min.js"></script>

        <!-- jquery -->
        <script src="<?=base_url()?>js/jquery-3.6.3.min.js"></script>

        <style>
            html,
            body {
            }

            body {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-align: center;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                width: 100%;
                max-width: 430px;
                padding: 15px;
                margin: auto;
                background-color: white;
            }
            .form-signin .form-control {
                position: relative;
                box-sizing: border-box;
                height: auto;
                padding: 10px;
                font-size: 16px;
            }
            .form-signin .form-control:focus {
                z-index: 2;
            }
            .form-signin input[type="email"] {
                margin-bottom: -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }
            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        </style>
    </head>
    <body class="text-center">
        <form class="form-signin" method="post" action="<?= base_url() ?>admin/post_login">
            <h2><?= $nom_sitio_corto ?? 'Lorem ipsum' ?></h2>
            <h4><?= $nom_sitio_largo ?? 'dolor sit amet' ?></h4>
            <hr>
            <?php if ($error): ?>
            <p class="text-danger"><?php echo $error ?></p>
            <?php endif ?>
            <div class="col-sm-4 offset-sm-4">
                <img class="logo_login" src="<?=base_url()?>img/<?= $logo_org_sitio ?? 'logotipo.png' ?>" alt="logo">
            </div>
            <h1 class="h3 mb-3 mt-5 font-weight-normal">Inicie sesión</h1>
            <input name="usuario" class="form-control" placeholder="Usuario" required autofocus>
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
            <p class="mt-5 mb-3 text-muted">&copy; <?= $anio_org_sitio ?? '2024' ?> <?= $nom_org_sitio ?? 'Organización' ?></p>
        </form>
    </body>
</html>
