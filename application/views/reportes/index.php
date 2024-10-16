<div class="my-3 pb-2 border-bottom">
    <h2>Reportes</h2>
</div>

<div class="area-contenido col-md-12">
    <div class="row">
        <div class="col-md-6">
            <h3>Listados</h3>
            <?php
                $permisos_requeridos = array(
                    'reportes_usuario.can_view',
                    'reportes_supervisor.can_view',
                    'reportes_administrador.can_view',
                );
                if (has_permission_or($permisos_requeridos, $permisos_usuario)) {
                    include "btn_listado_bitacora_01.php";
                }
            ?>
        </div>
    </div>
</div>
