<div class="card mt-0 mb-3">
    <div class="card-header text-white bg-primary">
        Roles con este permiso
    </div>
    <div class="card-body">
        <ul>
        <?php foreach( $roles_acceso as $roles_acceso_item) { ?>
            <li><?= $roles_acceso_item['nom_rol'] ?></li>
        <?php } ?>
        </ul>
    </div>
</div>
