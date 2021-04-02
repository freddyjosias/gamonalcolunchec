    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
            <?= $validation -> listErrors() ?>
            </div>
        <?php } ?>

        <form method='POST' action='<?= base_url() ?>/usuarios/actualizarpassword' autocomplete='off'>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Usuario </label>
                        <input type="text" class='form-control' value='<?= $usuario['usuario_user'] ?>' disabled>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Nombre</label>
                        <input type="text" class='form-control' value='<?= $usuario['usuario_nombre'] ?>' disabled>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Contraseña</label>
                        <input type="password" class='form-control' name='password' autofocus required>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Confirma contraseña</label>
                        <input type="password" class='form-control' name='repassword' required>

                    </div>
                </div>
            </div>

            <div class=''>
                <a href="<?= base_url() ?>" class='btn btn-primary'>Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>

            <?php if (isset($mensaje)) { ?>
                <div class="alert alert-success">
                <?= $mensaje ?>
                </div>
            <?php } ?>

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->