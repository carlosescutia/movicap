<?php
/*
|--------------------------------------------------------------------------
| dlg_borrar_archivo
|--------------------------------------------------------------------------
|
| Modal dialog to ask for confirmation before deletion of file.
| 
| Requirements:
|   bootstrap
|        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
|        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
|        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js">
|   jquery
|       <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
|
| Usage:
|   controller
|       $this->load->view('templates/dlg_borrar_archivo');
|   view
|        <?php 
|            $item_eliminar = $nombre_archivo;
|            $url_actual = base_url() . "ejecucion"; 
|            $dir_docs = "./doc/"; 
|        ?>
|        <a href="#dlg_borrar_archivo" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url_actual?>', '<?=$dir_docs?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
|
 */
?>

<div class="modal fade" id="dlg_borrar_archivo" tabindex="-1" aria-labelledby="dlg_borrar_archivo" aria-hidden="true">
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
                <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>archivos/eliminar">
                    <input type="hidden" id="nombre_archivo" name="nombre_archivo" value="eliminar">
                    <input type="hidden" id="url_actual" name="url_actual" value="url">
                    <input type="hidden" id="dir_docs" name="dir_docs" value="docs">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger boton">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function pass_data(item_eliminar, url_actual, dir_docs) {
        $("#item_eliminar").text(item_eliminar);
        $('#nombre_archivo').val(item_eliminar);
        $('#url_actual').val(url_actual);
        $('#dir_docs').val(dir_docs);
    }
</script>
