    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
            <?= $validation -> listErrors() ?>
            </div>
        <?php } ?>

        <form method='POST' action='<?= base_url() ?>/usuarios/insertar' autocomplete='off'>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Usuario</label>
                        <input type="text" class='form-control' id='usuario' name='usuario' autofocus  value='<?= set_value('usuario') ?>' required>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Nombre</label>
                        <input type="text" class='form-control' id='nombre' name='nombre'  value='<?= set_value('nombre') ?>' required>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Contraseña</label>
                        <input type="password" class='form-control' id='password' name='password'  value='<?= set_value('password') ?>' required>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Confirmar Contraseña</label>
                        <input type="password" class='form-control' id='repassword' name='repassword'  value='<?= set_value('repassword') ?>' required>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Caja</label>
                        <select name="id_caja" id="id_caja" class='form-control' required>
                            <option value="">Selecionar caja</option>

                            <?php foreach ($cajas as $key => $value) { ?>
                                <option value="<?= $value['caja_id'] ?>"><?= $value['caja_nombre'] ?></option>
                            <?php } ?>

                        </select>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Perfiles</label>
                        <select name="id_rol" id="id_rol" class='form-control' required>
                            <option value="">Selecionar perfil</option>

                            <?php foreach ($roles as $key => $value) { ?>
                                <option value="<?= $value['rol_id'] ?>"><?= $value['rol_nombre'] ?></option>
                            <?php } ?>

                        </select>

                    </div>
                </div>
            </div>
            <?php /*
            <div class="">
                <p class='text-dark mb-1'>Permisos</p>
                
                <div class="mb-3 row">

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
            */ ?>
            <div class='mt-5'>
                <a href="<?= base_url() ?>/usuarios" class='btn btn-light'>Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->