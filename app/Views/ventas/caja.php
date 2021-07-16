<?php

    $idUnico = uniqid();

?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        
        <?php if (is_null($caja)) {  ?>

            <h1 class="h2 mb-2 text-gray-800"><?= $title ?></h1>

        <?php } else { ?>

            <h1 class="h2 mb-2 text-gray-800"><?= $title . ' - ' . $caja["caja_nombre"] ?></h1>            

        <form method='POST' action='<?= base_url() ?>/ventas/guarda' autocomplete='off' id='form_venta' name='form_venta'>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <div class="ui-widget">
                            <input type="hidden" class='form-control' id='id_cliente' name='id_cliente' value='<?= $clienteDefecto['cliente_id'] ?>'>
                            <input type="hidden" class='form-control' id='id_venta' name='id_venta' value='<?= $idUnico ?>'>
                            <label for="">Nombres/Razón Social: </label>
                            <input type="text" class='form-control' id='cliente' placeholder='Escribe el nombre del cliente' value='<?= $clienteDefecto['cliente_nombre'] ?>'>
                        </div>
                    </div>

                    <div class="col-12 col-sm-2">
                        <div class="ui-widget">
                            <label for=""><span class="docu_cli"><?= $clienteDefecto['cliente_documento'] ?></span> Cliente: </label>
                            <input type="text" class='form-control' id='dni'  placeholder='Escribe el DNI del cliente' value='<?= $clienteDefecto['cliente_dni'] ?>'>
                        </div>
                    </div>

                    <div class="col-12 col-sm-2">
                        <div class="ui-widget">
                            <label for="">Correo Cliente: </label>
                            <input type="text" class='form-control' id='correo'  value='<?= $clienteDefecto['cliente_correo'] ?>' disabled>
                        </div>
                    </div>

                    <div class="col-12 col-sm-2">
                        <div class="ui-widget">
                            <label for="">Teléfono Cliente: </label>
                            <input type="text" class='form-control' id='telefono'  value='<?= $clienteDefecto['cliente_telefono'] ?>' disabled>
                        </div>
                    </div>

                    <div class="col-12 col-sm-1">

                        <label for="">Id</label>
                        <input type="text" class='form-control text-center' id='idcli' value='<?= $clienteDefecto['cliente_id'] ?>' disabled>

                    </div>

                    <div class="col-12 col-sm-2">

                        <label for="">Forma de Pago</label>
                        <select name="forma_pago" id="forma_pago" class='form-control' required>
                            <option value="001" selected>Efectivo</option>
                            <!-- <option value="002">Tarjeta</option>
                            <option value="003">Trasferencia</option> -->
                        </select>

                    </div>
                </div>
            </div>
            
            <div class="form-group border border-dark border-left-0 border-right-0 border-top-0 pb-4 mb-4">
                <div class="row">

                    <div class="col-12 col-sm-5">
                        <div class="ui-widget">
                            <label for="">Dirección Cliente: </label>
                            <input type="text" class='form-control' id='direccion'  value='<?= $clienteDefecto['cliente_direccion'] ?>' disabled>
                        </div>
                    </div>

                    <?php if (false) { ?>
                        <div class="col-12 col-sm-3 pt-1">
                            <a type="button" id='edit_user' class="btn btn-warning mt-4">Editar Usuario</a>
                        </div>
                    <?php } ?>
                    

                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-4">

                        <input type="hidden" class='form-control' id='id_producto' name='id_producto'>
                        <label for="">Código de barras</label>
                        <input type="text" class='form-control' id='codigo' name='codigo' autofocus placeholder="Escribe el código y enter">

                    </div>

                    <div class="col-12 col-sm-3">

                        <label for="">Cantidad</label>
                        <input type="number" class='form-control' id='cantidad' name='cantidad' value="1">

                    </div>

                    <div class="col-sm-5">

                        <label for="" id='res_error' class='font-weight-bold text-danger mt-4 pt-3'>&nbsp;</label>
                        <input type="text" class='form-control d-none input-codpro' id='subtotal' name='subtotal' data-idcompra='<?= $idUnico ?>'>

                    </div>

                    
                </div>
            </div>

            <div class="">
                <table id='tableproducto' class='table table-hover table-striped table-sm tabla_productos' >
                    <thead class='thead-dark'>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th whith="1%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>

            <div class="text-right">

                <p for="" class='font-weight-bolder h3 text-dark mt-4 '>Total S/ <span class='label_total'>0.00</span></p>
                <input type="text" id='total' name='total' class='d-none' value='0.00'>
                <div class="ml-4 mt-2">
                    <a class="btn btn-info mr-2" href="<?= base_url() ?>/ventas">Regresar</a>
                    <button type="button" id='completa_venta' class="btn btn-success">Completar Venta</button>
                </div>

            </div>

        </form>

        <?php } ?>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script src="<?= base_url() ?>/public/js/caja.js"></script>