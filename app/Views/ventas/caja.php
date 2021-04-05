<?php

    $idUnico = uniqid();

?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <form method='POST' action='<?= base_url() ?>/ventas/guarda' autocomplete='off' id='form_venta' name='form_venta'>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="ui-widget">
                            <input type="hidden" class='form-control' id='id_cliente' name='id_cliente' value='1'>
                            <input type="hidden" class='form-control' id='id_venta' name='id_venta' value='<?= $idUnico ?>'>
                            <label for="">Cliente: </label>
                            <input type="text" class='form-control' id='cliente' name='cliente' autofocus placeholder='Escribe el nombre del cliente' value='Público en general' required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">

                        <label for="">Forma de Pago</label>
                        <select name="forma_pago" id="forma_pago" class='form-control' required>
                            <option value="001">Efectivo</option>
                            <option value="002">Tarjeta</option>
                            <option value="003">Trasferencia</option>
                        </select>

                    </div>

                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-4">

                        <input type="hidden" class='form-control' id='id_producto' name='id_producto'>
                        <label for="">Código de barras</label>
                        <input type="text" class='form-control' id='codigo' name='codigo' placeholder="Escribe el código y enter">

                    </div>

                    <div class="col-sm-2">

                        <label for="codigo" id='res_error' class=''>&nbsp;</label>
                        <input type="text" class='form-control d-none' id='subtotal' name='subtotal'>

                    </div>

                    <div class="col-12 col-sm-6 mt-2 row">

                        <p for="" class='font-weight-bolder h2 text-dark mt-4 '>Total S/ <span class='label_total'>0.00</span></p>
                        <input type="text" id='total' name='total' class='d-none' value='0.00'>
                        <div class="ml-4 mt-4">
                            <button type="button" id='completa_venta' class="btn btn-success">Completar Venta</button>
                        </div>

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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>       

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script src="<?= base_url() ?>/js/caja.js"></script>