
<!-- Modal nuevo registro -->
<div class="modal fade" id="ComentarioModal" tabindex="-1" aria-labelledby="comentarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="comentarioModalLabel">Agregar Un Comentario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../config/guardarComentarios.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="comentario" class="form-label">Comentario: </label>
                        <textarea name="comentario" id="comentario" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="calificacion" class="form-label">Calificacion:</label>
                        <input type="range" min="0" max="10" step="1" name="calificacion" id="calificacion" class="form-control" required>
                    </div>

                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>