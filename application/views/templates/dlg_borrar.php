<?php
/*
|--------------------------------------------------------------------------
| dlg_borrar
|--------------------------------------------------------------------------
|
| Modal dialog to ask for confirmation before deletion of element.
| 
| Requirements:
|   bootstrap
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js">
|   jquery
|       <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
|
| Usage:
|   controller
|       $this->load->view('templates/dlg_borrar');
|   view
|        <?php 
|            $item_eliminar = $usuarios_item['nom_usuario']; 
|            $action_link = base_url() . "usuarios/eliminar/". $usuarios_item['cve_usuario']; 
|        ?>
|        <a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$action_link?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
|
 */
?>

<div class="modal fade" id="dlg_borrar" tabindex="-1" aria-labelledby="dlg_borrar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dlg_borrarLabel">Confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="ml-3">Confirme que desea eliminar:</p>
                <h3 class="text-center"><span id="item_eliminar"></span></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="action_link" type="button" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script>
    function pass_data(item_eliminar, action_link) {
        $("#item_eliminar").text(item_eliminar);
        $('#action_link').attr("href" , action_link );
    }
</script>
