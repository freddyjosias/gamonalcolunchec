    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <div class="">
            <p class="">
                <a href="<?= base_url() ?>/marcas/nuevo" class='btn btn-info'>Agregar</a>
                <a href="<?= base_url() ?>/marcas/eliminados" class='btn btn-warning'>Eliminados</a>
            </p>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                foreach ($datos as $key => $value) { ?>
                                    
                                    <tr>
                                        <td><?= $value['marca_id'] ?></td>
                                        <td><?= $value['marca_nombre'] ?></td>

                                        <td class='text-center'>
                                            <a href="<?= base_url() ?>/marcas/editar/<?= $value['marca_id'] ?>" class='btn btn-warning py-1 my-1 px-2'><i class="fas fa-edit"></i></a>
                                            
                                            <a href="<?= base_url() ?>/marcas/eliminar/<?= $value['marca_id'] ?>" class='btn btn-danger py-1 my-1 px-2 ml-2'><i class="fas fa-trash-alt"></i></a>
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