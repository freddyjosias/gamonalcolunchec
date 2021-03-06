    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <?php if (isset($validation)) { ?>
            <div class="alert alert-danger">
            <?= $validation -> listErrors() ?>
            </div>
        <?php } ?>

        <form method='POST' action='<?= base_url() ?>/productos/insertar<?= (!is_null($idCompra)) ? '/' . $idCompra : '' ?>' autocomplete='off'>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Código</label>
                        <input type="text" class='form-control' id='codigo' name='codigo' autofocus required value="<?= set_value('codigo') ?>" maxlength="20">

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Nombre</label>
                        <input type="text" class='form-control' id='nombre' name='nombre' required value="<?= set_value('nombre') ?>" maxlength="200">

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Unidad</label>
                        <select name="id_unidad" id="id_unidad" class='form-control' required>
                            <option value="">Selecionar unidad</option>

                            <?php foreach ($unidades as $key => $value) { ?>
                                <option value="<?= $value['unidad_id'] ?>"><?= $value['unidad_nombre'] ?></option>
                            <?php } ?>

                        </select>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Categoría</label>
                        <select name="id_categoria" id="id_categoria" class='form-control' required>
                            <option value="">Selecionar categoría</option>

                            <?php foreach ($categorias as $key => $value) { ?>
                                <option value="<?= $value['categoria_id'] ?>"><?= $value['categoria_nombre'] ?></option>
                            <?php } ?>

                        </select>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Stock Minimo</label>
                        <input type="number" class='form-control' id='stock_minimo' name='stock_minimo' required value="<?= set_value('stock_minimo') ?>" max="10000" min="0" step="1">

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Marca</label>
                        <select name="id_marca" id="id_marca" class='form-control' required>
                            <option value="">Selecionar marca</option>

                            <?php foreach ($marcas as $key => $value) { ?>
                                <option value="<?= $value['marca_id'] ?>"><?= $value['marca_nombre'] ?></option>
                            <?php } ?>

                        </select>

                    </div>
                    
                    <?php if(false) { ?>
                    <div class="col-12 col-sm-6">

                        <label for="">Es inventariable</label>
                        <select name="inventariable" id="inventariable" class='form-control' required>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>

                    </div>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Precio Venta</label>
                        <input type="number" class='form-control' id='precio_venta' name='precio_venta' required value="<?= set_value('precio_venta') ?>" max="100000" min="0" step="0.01">

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Precio Compra</label>
                        <input type="number" class='form-control' id='pracio_compra' name='pracio_compra' required value="<?= set_value('pracio_compra') ?>" max="100000" min="0" step="0.01">

                    </div>
                </div>
            </div>

            <div class=''>
                <a href="<?= (is_null($idCompra)) ? base_url() . '/productos' : base_url() . '/compras/nuevo/' . $idCompra ?>" class='btn btn-light'>Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->