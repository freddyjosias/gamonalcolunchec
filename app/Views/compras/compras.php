    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>
        
        <div class="">
            <p class="">
                <?php if (isset($permisos[6])) { ?>
                    <a class='btn btn-success' href="<?= base_url() ?>/compras/nuevo">Nueva Compra</a>
                <?php }  ?>
                <a href="<?= base_url() ?>/compras/eliminados" class='btn btn-warning'>Compras Anuladas</a>
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
                                <th>Id</th>
                                <th>Proveedor</th>
                                <th>Documento</th>
                                <th>IGV</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Proveedor</th>
                                <th>Documento</th>
                                <th>IGV</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                foreach ($datos as $key => $value) { ?>
                                    
                                    <tr>
                                        <td><?= $value['compra_id'] ?></td>
                                        <td><?= $value['compra_proveedor'] ?></td>
                                        <td><?= $value['compra_tipodoc'] ?></td>
                                        <td><?= ($value['compra_igv'] == 1) ? 'SI' : 'NO' ?></td>
                                        <td><?= $value['compratotal'] ?></td>
                                        <td><?= $value['compra_creation'] ?></td>

                                        <td class='text-center'>
                                            <a type='button' href="<?= base_url() ?>/compras/muestracomprapdf/<?= $value['compra_id'] ?>" class='btn btn-primary py-1 my-1 px-2'title=''><i class="fas fa-file-pdf"></i></a>
                                            <?php
                                                
                                                $dateCompra = new DateTime(str_replace(" ", "T", $value['compra_creation']) . 'America/Lima');
                                                $dateCompra -> add($interval);
                                                if ($dateCompra > $now) { ?>
                                                
                                                    <a type='button' data-href="<?= base_url() ?>/compras/anular/<?= $value['compra_id'] ?>" class='btn btn-danger  py-1 my-1 px-2 ml-2' data-toggle='modal' data-target='#modal-confirma' data-placement='top' title='Anular Registro'><i class="fas fa-times-circle"></i></a>
                                                    
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
                <h5 class="modal-title">Anular Compra</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">??</span>
                </button>
            </div>

            <div class="modal-body">
                ??Desea anular esta compra?
            </div>
                                    
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok" type="button">Si</a>
            </div>
        </div>
    </div>
</div>