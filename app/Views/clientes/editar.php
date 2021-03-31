    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
            <?= $validation -> listErrors() ?>
            </div>
        <?php } ?>

        <form method='POST' action='<?= base_url() ?>/clientes/actualizar' autocomplete='off'>
        
            <input type="text" class='form-control d-none' id='id' name='id' autofocus required value='<?= $cliente['cliente_id'] ?>'>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Nombre</label>
                        <input type="text" class='form-control' id='nombre' name='nombre' autofocus required value="<?= $cliente['cliente_nombre'] ?>">

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Dirección</label>
                        <input type="text" class='form-control' id='direccion' name='direccion' value="<?= $cliente['cliente_direccion'] ?>">

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Teléfono</label>
                        <input type="tel" class='form-control' id='telefono' name='telefono' value="<?= $cliente['cliente_telefono'] ?>">

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Correo</label>
                        <input type="email" class='form-control' id='correo' name='correo' value="<?= $cliente['cliente_correo'] ?>">

                    </div>
                </div>
            </div>


            <div class=''>
                <a href="<?= base_url() ?>/clientes" class='btn btn-light'>Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->