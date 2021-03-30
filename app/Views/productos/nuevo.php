    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <form method='POST' action='<?= base_url() ?>/productos/insertar' autocomplete='off'>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Código</label>
                        <input type="text" class='form-control' id='codigo' name='codigo' autofocus required>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Nombre</label>
                        <input type="text" class='form-control' id='nombre' name='nombre' required>

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

                        <label for="">Precio Venta</label>
                        <input type="text" class='form-control' id='precio_venta' name='precio_venta' autofocus required>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Precio Compra</label>
                        <input type="text" class='form-control' id='pracio_compra' name='pracio_compra' required>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Stock Minimo</label>
                        <input type="text" class='form-control' id='stock_minimo' name='stock_minimo' autofocus required>

                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Es inventariable</label>
                        <select name="inventariable" id="inventariable" class='form-control' required>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>

                    </div>
                </div>
            </div>

            <div class=''>
                <a href="<?= base_url() ?>/productos" class='btn btn-primary'>Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->