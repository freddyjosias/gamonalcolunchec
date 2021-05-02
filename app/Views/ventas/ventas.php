    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <div class="">
            <p class="">
                <a href="<?= base_url() ?>/ventas/eliminados" class='btn btn-warning'>Eliminado</a>
            </p>
        </div>
        <?php 
            date_default_timezone_set('America/Lima');
            $now = new DateTime('NOW');
            $interval = new DateInterval('PT1H');
            
            if (!is_null($msg)) { ?>

                <div class="alert alert-danger">
                <?= $msg ?>
                </div>

            <?php } ?>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Cajero</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Fecha</th>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Cajero</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                foreach ($datos as $key => $value) { ?>
                                    
                                    <tr>
                                        <td><?= $value['venta_creation'] ?></td>
                                        <td><?= $value['venta_folio'] ?></td>
                                        <td><?= $value['cliente_nombre'] ?></td>
                                        <td><?= $value['venta_total'] ?></td>
                                        <td><?= $value['usuario_user'] ?></td>

                                        <td><a href="<?= base_url() ?>/ventas/muestraTicket/<?= $value['venta_id'] ?>" class='btn btn-warning'><i class="fas fa-file-pdf"></i></a></td>

                                        <td><a type='button' data-href="<?= base_url() ?>/ventas/eliminar/<?= $value['venta_id'] ?>" class='btn btn-danger' data-toggle='modal' data-target='#modal-confirma' data-placement='top' title='Eliminar Registro'><i class="fas fa-trash-alt"></i></a></td>

                                        <td class='text-center'>
                                            <a type='button' href="<?= base_url() ?>/ventas/muestraTicket/<?= $value['venta_id'] ?>" class='btn btn-primary py-1 my-1 px-2'title=''><i class="fas fa-file-pdf"></i></a>
                                            <?php
                                                
                                                $dateVenta = new DateTime(str_replace(" ", "T", $value['venta_creation']) . 'America/Lima');
                                                $dateVenta -> add($interval);
                                                if ($dateVenta > $now) { ?>
                                                
                                                    <a type='button' data-href="<?= base_url() ?>/ventas/anular/<?= $value['venta_id'] ?>" class='btn btn-danger  py-1 my-1 px-2 ml-2' data-toggle='modal' data-target='#modal-confirma' data-placement='top' title='Anular Registro'><i class="fas fa-times-circle"></i></a>
                                                    
                                                <?php } ?>
                                        </td>

                                    </tr>
                                
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
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