    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                
                <?php if (isset($validation)) { ?>
                    <div class="alert alert-danger">
                    <?= $validation -> listErrors() ?>
                    </div>
                <?php } ?>

                <form method='POST' enctype="multipart/form-data" action='<?= base_url() ?>/configuracion/actualizar' autocomplete='off'>
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-6">

                                <label for="">Nombre de la tienda</label>
                                <input type="text" class='form-control' id='tienda_nombre' name='tienda_nombre' autofocus  value='<?= $nombreTienda ?>' required>

                            </div>

                            <div class="col-12 col-sm-6">

                                <label for="">RUC</label>
                                <input type="text" class='form-control' id='tienda_rfc' name='tienda_rfc'  value='<?= $rucTienda ?>' required>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-6">

                                <label for="">Teléfono de la Tienda</label>
                                <input type="text" class='form-control' id='tienda_telefono' name='tienda_telefono'  value='<?= $telefonoTienda ?>' required>

                            </div>

                            <div class="col-12 col-sm-6">

                                <label for="">Correo de la Tienda</label>
                                <input type="email" class='form-control' id='tienda_correo' name='tienda_correo'  value='<?= $emailTienda ?>' required>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-12 col-sm-6">

                                <label for="">Dirección de la tienda</label>
                                <input type="text" class='form-control' id='tienda_direccion' name='tienda_direccion'  value='<?= $direccionTienda ?>' required>

                            </div>

                            <div class="col-12 col-sm-6">

                                <label for="">Leyenda del Ticket</label>
                                <input type="text" class='form-control' id='leyenda_ticket' name='leyenda_ticket'  value='<?= $leyendaTicket ?>' required>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-6">

                                <label for="">Logotipo</label> <br>
                                <img src="<?= base_url() . '/img/' . $logoTienda ?>" class='configuracion_logo' alt=""> <br>

                                <div class="custom-file">
                                    <input type="file" id='tienda_logo' name='tienda_logo' class="custom-file-input" accept="image/png,image/jpeg">
                                    <label class="custom-file-label">Seleccionar Archivo...</label>
                                </div>

                                <div class="configuracion_filename">
                                    
                                </div>

                            </div>                        
                        </div>
                    </div>

                    <div class='text-right'>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                    
                </form>
                
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Logout Modal-->
<div class="modal fade" id="modal-confirma" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Registro</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                ¿Desea eliminar este registro?
            </div>
                                    
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-light" type="button" data-dismiss="modal">No</button>
                <a class="btn btn-danger btn-ok" type="button">Si</a>
            </div>
        </div>
    </div>
</div>