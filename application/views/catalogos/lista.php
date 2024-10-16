<main role="main" class="ml-sm-auto px-4 mb-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Catálogos</h1>
    </div>
    <div class="row">
        <div class="col-md-9 p-3">
            <h2>Aplicación</h2>
            <div class="row mb-3 gy-3">
                <?php
                    $permisos_requeridos = array(
                    'organizacion.can_edit',
                    );
                    if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                        <div class="col-md-4">
                            <?php include "organizacion/boton.php" ?>
                        </div>
                    <?php }
                ?>
                <?php
                    $permisos_requeridos = array(
                    'parametro_sistema.can_edit',
                    );
                    if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                        <div class="col-md-4">
                            <?php include "parametro_sistema/boton.php" ?>
                        </div>
                    <?php }
                ?>
            </div>
        </div>
        <div class="col-md-3 p-3 border bg-light">
            <h2>Sistema</h2>
            <div class="row mb-3 gy-3">
                <?php
                    $permisos_requeridos = array(
                    'usuario.can_edit',
                    );
                    if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                        <div class="col-md-12">
                            <?php include "usuario/boton.php" ?>
                        </div>
                    <?php }
                ?>
                <?php
                    $permisos_requeridos = array(
                    'rol.can_edit',
                    );
                    if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                        <div class="col-md-12">
                            <?php include "rol/boton.php" ?>
                        </div>
                    <?php }
                ?>
                <?php
                    $permisos_requeridos = array(
                    'opcion_sistema.can_edit',
                    );
                    if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                        <div class="col-md-12">
                            <?php include "opcion_sistema/boton.php" ?>
                        </div>
                    <?php }
                ?>
                <?php
                    $permisos_requeridos = array(
                    'acceso_sistema.can_edit',
                    );
                    if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                        <div class="col-md-12">
                            <?php include "acceso_sistema/boton.php" ?>
                        </div>
                    <?php }
                ?>
                <?php
                    $permisos_requeridos = array(
                    'opcion_publica.can_edit',
                    );
                    if (has_permission_or($permisos_requeridos, $permisos_usuario)) { ?>
                        <div class="col-md-12">
                            <?php include "opcion_publica/boton.php" ?>
                        </div>
                    <?php }
                ?>
            </div>
        </div>
    </div>
</main>
