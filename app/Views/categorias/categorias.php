    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <div class="">
            <p class="">
                <a href="<?= base_url() ?>/categorias/nuevo" class='btn btn-info'>Agregar</a>
                <a href="<?= base_url() ?>/categorias/eliminados" class='btn btn-warning'>Eliminado</a>
            </p>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Categoria ID</th>
                                <th>Nombre</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Categoria ID</th>
                                <th>Nombre</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                foreach ($datos as $key => $value) { ?>
                                    
                                    <tr>
                                        <td><?= $value['categoria_id'] ?></td>
                                        <td><?= $value['categoria_nombre'] ?></td>

                                        <td><a href="<?= base_url() ?>/categorias/editar/<?= $value['categoria_id'] ?>" class='btn btn-warning'><i class="fas fa-edit"></i></a></td>

                                        <td><a href="<?= base_url() ?>/categorias/eliminar/<?= $value['categoria_id'] ?>" class='btn btn-danger'><i class="fas fa-trash-alt"></i></a></td>
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