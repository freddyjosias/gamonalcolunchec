    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <div class="">
            <p class="">
                <a href="<?= base_url() ?>/clientes" class='btn btn-warning'>Clientes</a>
            </p>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nombres/Razón Social</th>
                                <th>DNI/RUC</th>
                                <th>Dirección</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nombres/Razón Social</th>
                                <th>DNI/RUC</th>
                                <th>Dirección</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                foreach ($datos as $key => $value) { ?>
                                    
                                    <tr>
                                        <td><?= $value['cliente_nombre']?></td>
                                        <td><?= ($value['cliente_dni'] != '') ? $value['cliente_dni'] : '---' ?></td>
                                        <td><?= ($value['cliente_direccion'] != '') ? $value['cliente_direccion'] : '---' ?></td>
                                        <td><?= ($value['cliente_correo'] != '') ? $value['cliente_correo'] : '---' ?></td>

                                        <td class="text-center">
                                            <a type='button' data-href="<?= base_url() ?>/clientes/reingresar/<?= $value['cliente_id'] ?>" class='btn btn-success   py-1 my-1 px-2' data-toggle='modal' data-target='#modal-confirma' data-placement='top' title='Reingresar Registro'><i class="fas fa-undo-alt"></i></a>
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
                <h5 class="modal-title">Reingresar Registro</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                ¿Desea reingresar este registro?
            </div>
                                    
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok" type="button">Si</a>
            </div>
        </div>
    </div>
</div>