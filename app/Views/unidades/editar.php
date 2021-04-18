    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
            <?= $validation -> listErrors() ?>
            </div>
        <?php } ?>

        <form method='POST' action='<?= base_url() ?>/unidades/actualizar' autocomplete='off'>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Nombre</label>
                        <input type="text" class='form-control' value='<?= $datos['unidad_nombre'] ?>' id='nombre' name='nombre' autofocus required>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Nombre Corto</label>
                        <input type="text" class='form-control' value='<?= $datos['unidad_corto'] ?>' id='nombre_corto' name='nombre_corto' required>

                    </div>
                </div>
            </div>

            <input type="hidden" value='<?= $datos['unidad_id'] ?>' name='id'>

            <div class=''>
                <a href="<?= base_url() ?>/unidades" class='btn btn-light'>Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->