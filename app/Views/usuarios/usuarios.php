    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <div class="">
            <p class="">
                <a href="<?= base_url() ?>/usuarios/nuevo" class='btn btn-info'>Agregar</a>
                <a href="<?= base_url() ?>/usuarios/eliminados" class='btn btn-warning'>Eliminado</a>
            </p>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Usuario ID</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Usuario ID</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                foreach ($datos as $key => $value) { ?>
                                    
                                    <tr>
                                        <td><?= $value['usuario_id'] ?></td>
                                        <td><?= $value['usuario_user'] ?></td>
                                        <td><?= $value['usuario_nombre'] ?></td>

                                        <td><a href="<?= base_url() ?>/usuarios/editar/<?= $value['usuario_id'] ?>" class='btn btn-warning'><i class="fas fa-edit"></i></a></td>

                                        <td><a type='button' data-href="<?= base_url() ?>/usuarios/eliminar/<?= $value['usuario_id'] ?>" class='btn btn-danger' data-toggle='modal' data-target='#modal-confirma' data-placement='top' title='Eliminar Registro'><i class="fas fa-trash-alt"></i></a></td>
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