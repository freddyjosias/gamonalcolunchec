    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <form method='POST' action='<?= base_url() ?>/productos/actualizar' autocomplete='off'>
        
            <input type="text" class='form-control d-none' id='id' name='id' autofocus required value='<?= $producto['producto_id'] ?>'>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Código</label>
                        <input type="text" class='form-control' id='codigo' name='codigo' autofocus required value='<?= $producto['producto_codigo'] ?>'>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Nombre</label>
                        <input type="text" class='form-control' id='nombre' name='nombre' required value='<?= $producto['producto_nombre'] ?>'>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Unidad</label>
                        <select name="id_unidad" id="id_unidad" class='form-control' required>
                            <option value="">Selecionar unidad</option>

                            <?php foreach ($unidades as $key => $value) { 
                                    if ($value['unidad_id'] == $producto['unidad_id']) { ?>
                                    <option value="<?= $value['unidad_id'] ?>" selected><?= $value['unidad_nombre'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $value['unidad_id'] ?>"><?= $value['unidad_nombre'] ?></option>
                                <?php } ?>
                            <?php } ?>

                        </select>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Categoría</label>
                        <select name="id_categoria" id="id_categoria" class='form-control' required>
                            <option value="">Selecionar categoría</option>

                            <?php foreach ($categorias as $key => $value) {
                                    if ($value['categoria_id'] == $producto['categoria_id']) { ?>
                                        <option value="<?= $value['categoria_id'] ?>" selected><?= $value['categoria_nombre'] ?></option>
                                <?php } else { ?>
                                        <option value="<?= $value['categoria_id'] ?>"><?= $value['categoria_nombre'] ?></option>
                                <?php } ?>
                            <?php } ?>

                        </select>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Precio Venta</label>
                        <input type="text" class='form-control' id='precio_venta' name='precio_venta' autofocus required value='<?= $producto['producto_precioventa'] ?>'>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Precio Compra</label>
                        <input type="text" class='form-control' id='pracio_compra' name='pracio_compra' required value='<?= $producto['producto_preciocompra'] ?>'>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Stock Minimo</label>
                        <input type="text" class='form-control' id='stock_minimo' name='stock_minimo' autofocus required value='<?= $producto['producto_stockminimo'] ?>'>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Es inventariable</label>
                        <select name="inventariable" id="inventariable" class='form-control' required>
                            
                            <?php if ($producto['producto_inventariable'] == 1) { ?>
                                <option value="1" selected>Si</option>
                                <option value="0">No</option>
                            <?php } else { ?>
                                <option value="1">Si</option>
                                <option value="0" selected>No</option>
                            <?php } ?>

                        </select>

                    </div>
                </div>
            </div>

            <div class=''>
                <a href="<?= base_url() ?>/productos" class='btn btn-light'>Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->