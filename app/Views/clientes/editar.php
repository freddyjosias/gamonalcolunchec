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

                        <label for="">Apellidos</label>
                        <input type="text" class='form-control' id='apellido' name='apellido' value="<?= $cliente['cliente_apellido'] ?>">

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-4">

                        <label for="">DNI/RUC</label>
                        <input type="tel" class='form-control' id='dni' name='dni' value="<?= $cliente['cliente_dni'] ?>" maxlength="8">

                    </div>

                    <div class="col-12 col-sm-4">

                        <label for="">Tipo de Documento</label>
                        <select name="documento" id="documento" class='form-control'>
                            <?php if ($cliente['cliente_documento'] == 'DNI') { ?>
                                <option value="">Selecionar</option>
                                <option value="DNI" selected>DNI</option>
                                <option value="RUC">RUC</option>
                            <?php } else if($cliente['cliente_documento'] == 'RUC') { ?>
                                <option value="">Selecionar</option>
                                <option value="DNI">DNI</option>
                                <option value="RUC" selected>RUC</option>
                            <?php } else { ?>
                                <option value="" selected>Selecionar</option>
                                <option value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="col-12 col-sm-4">

                        <label for="">Correo</label>
                        <input type="email" class='form-control' id='correo' name='correo' value="<?= $cliente['cliente_correo'] ?>">

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Dirección</label>
                        <input type="text" class='form-control' id='direccion' name='direccion' value="<?= $cliente['cliente_direccion'] ?>">

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Teléfono</label>
                        <input type="tel" class='form-control' id='telefono' name='telefono' value="<?= $cliente['cliente_telefono'] ?>">

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