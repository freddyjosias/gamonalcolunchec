<?php

    if (is_null($idCompra)) {
        $idUnico = uniqid();
    } else {
        $idUnico = $idCompra;
    }
    

?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <h1 class="h2 mb-2 text-gray-800"><?= $title ?></h1>

        <form method='POST' action='<?= base_url() ?>/compras/guarda' autocomplete='off' id='form_compra' name='form_compra'>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-4">

                        <input type="hidden" class='form-control' id='id_producto' name='id_producto'>
                        <input type="hidden" class='form-control' id='id_compra' name='id_compra' value='<?= $idUnico ?>'>
                        <label for="">Código</label>
                        <input type="text" class='form-control' id='codigo' name='codigo' autofocus placeholder='Escribe el código y enter' <?= (!is_null($lastPro)) ? 'value="' . $lastPro . '"' : '' ?>>
                        <label for="codigo" id='res_error'></label>

                    </div>

                    <div class="col-12 col-sm-4">

                        <label for="">Nombre del producto</label>
                        <input type="text" class='form-control' id='nombre' name='nombre' disabled>

                    </div>

                    <div class="col-12 col-sm-2">

                        <label for="">Cantidad</label>
                        <input type="number" class='form-control' id='cantidad' name='cantidad'>

                    </div>

                    
                </div>
            </div>

            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-3">

                        <label for="">Precio de Compra (S/.)</label>
                        <input type="text" class='form-control' id='precio_compra' name='precio_compra' disabled>

                    </div>

                    <div class="col-12 col-sm-3">

                        <label for="">Precio de Venta (S/.)</label>
                        <input type="text" class='form-control' id='precio_venta' name='precio_venta' disabled>

                    </div>

                    <div class="col-12 col-sm-3">

                        <label for="">Subtotal (S/.)</label>
                        <input type="text" class='form-control' id='subtotal' name='subtotal' disabled>

                    </div>

                    <div class="col-12 col-sm-3 mt-2">

                        <button id='btn-addproducto' name='addproducto' type='button' class='btn btn-primary mt-4' data-idcompra='<?= $idUnico ?>'>Agregar Producto</button>

                    </div>
                    
                </div>
            </div>

            <div class="">
                <table id='tableproducto' class='table table-hover table-striped table-sm tabla_productos' width="100%">
                    <thead class='thead-dark'>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-12 text-right pr-5">
                    <p for="" class='font-weight-bolder h3 text-dark mt-1 '>Total S/ <span class='label_total'>0.00</span></p>
                    <input type="text" id='total' name='total' class='d-none' value='0.00'>
                    <button type="button" id='completa_compra' class="btn btn-success">Completar Compra</button>
                </div>
            </div>            

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php if (!is_null($idCompra)) { ?>
        <p class="actualizar_compra d-none">SI</p>
<?php    } ?>

<script src="<?= base_url() ?>/js/nuevacompra.js"></script>

