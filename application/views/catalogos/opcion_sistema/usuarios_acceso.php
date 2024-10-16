<div class="card mt-0 mb-3">
    <div class="card-header text-white bg-primary">
        Usuarios con este permiso
    </div>
    <div class="card-body">
        <ul>
        <?php foreach( $usuarios_acceso as $usuarios_acceso_item) { ?>
            <li><?= $usuarios_acceso_item['nom_usuario'] ?> - <?= $usuarios_acceso_item['nom_organizacion'] ?></li>
        <?php } ?>
        </ul>
    </div>
</div>
