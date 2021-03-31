    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
            <?= $validation -> listErrors() ?>
            </div>
        <?php } ?>

        <form method='POST' action='<?= base_url() ?>/clientes/insertar' autocomplete='off'>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Nombre</label>
                        <input type="text" class='form-control' id='nombre' name='nombre' autofocus required value="<?= set_value('nombre') ?>">

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Dirección</label>
                        <input type="text" class='form-control' id='direccion' name='direccion' value="<?= set_value('direccion') ?>">

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Teléfono</label>
                        <input type="tel" class='form-control' id='telefono' name='telefono' value="<?= set_value('telefono') ?>">

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Correo</label>
                        <input type="email" class='form-control' id='correo' name='correo' value="<?= set_value('correo') ?>">

                    </div>
                </div>
            </div>

            <div class=''>
                <a href="<?= base_url() ?>/clientes" class='btn btn-primary'>Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->