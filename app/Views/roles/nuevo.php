    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
            <?= $validation -> listErrors() ?>
            </div>
        <?php } ?>

        <form method='POST' action='<?= base_url() ?>/perfiles/insertar' autocomplete='off'>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Nombre</label>
                        <input type="text" class='form-control' id='nombre' name='nombre' autofocus required>

                    </div>

                </div>
            </div>
            
            <div class="mt-3">
                <p class='text-dark mb-1'>Permisos</p>
                
                <div class="mb-4 row">

                    <?php foreach ($permisosEdit as $key => $value) { ?>
                        <div class="mb-2 col-12 col-sm-6">
                            <div class='bg-white d-flex'>
                                <input type="checkbox" name="permiso_<?= $value['permiso_id'] ?>" id="permiso_<?= $value['permiso_id'] ?>" class='mt-2 ml-2' <?= (set_value('permiso_' . $value['permiso_id']) == 'on') ? 'checked' : '' ?> >
                                <label class='px-2 mb-0 py-1' for="permiso_<?= $value['permiso_id'] ?>"><?= $value['permiso_nombre'] ?></label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                
            </div>

            <div class=''>
                <a href="<?= base_url() ?>/perfiles" class='btn btn-light'>Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->