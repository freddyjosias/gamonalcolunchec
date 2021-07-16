    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <div class="row mt-4">
            <div class="col-3">
                <div class="alert pt-4 card_prin <?= ($cantVentasHoy > 0) ? 'alert-success' : 'alert-danger' ?>" role="alert">
                    <p class="cord_text_prin mb-1">Hoy se realizó <?= $cantVentasHoy ?> ventas</p>
                    <p class="cord_text_seco mb-4"><?= abs($cantVentasHoy - $cantVentasAyer) ?> <?= (($cantVentasHoy - $cantVentasAyer) >= 0) ? 'más' : 'menos' ?>  que ayer &nbsp; <i class="<?= (($cantVentasHoy - $cantVentasAyer) > 0) ? 'color-primary far fa-arrow-alt-circle-up' : '' ?> <?= (($cantVentasHoy - $cantVentasAyer) == 0) ? 'fas fa-minus-circle' : '' ?> <?= (($cantVentasHoy - $cantVentasAyer) < 0) ? 'color-danger far fa-arrow-alt-circle-down' : '' ?>"></i></p>

                    <p class="cord_img_fondo"><i class="<?= (($cantVentasHoy) > 0) ? 'far fa-arrow-alt-circle-up' : 'fas fa-minus-circle' ?>"></i></p>
                    
                </div>
            </div>
            
            <div class="col-3">
                <div class="alert pt-4 card_prin <?= ($cantVentasEstaSemana > 0) ? 'alert-success' : 'alert-danger' ?>" role="alert">
                    <p class="cord_text_prin mb-1">Esta semana se realizó <?= $cantVentasEstaSemana ?> ventas</p>
                    <p class="cord_text_seco mb-4"><?= abs($cantVentasEstaSemana - $cantVentasSemanaAnterior) ?> <?= (($cantVentasEstaSemana - $cantVentasSemanaAnterior) >= 0) ? 'más' : 'menos' ?>  que la semana anterior &nbsp; <i class="<?= (($cantVentasEstaSemana - $cantVentasSemanaAnterior) > 0) ? 'color-primary far fa-arrow-alt-circle-up' : '' ?> <?= (($cantVentasEstaSemana - $cantVentasSemanaAnterior) == 0) ? 'fas fa-minus-circle' : '' ?> <?= (($cantVentasEstaSemana - $cantVentasSemanaAnterior) < 0) ? 'color-danger far fa-arrow-alt-circle-down' : '' ?>"></i></p>

                    <p class="cord_img_fondo"><i class="<?= (($cantVentasEstaSemana) > 0) ? 'far fa-arrow-alt-circle-up' : 'fas fa-minus-circle' ?>"></i></p>
                    
                </div>
            </div>
            
            <div class="col-3">
                <div class="alert pt-4 card_prin <?= ($cantVentasEsteMes > 0) ? 'alert-success' : 'alert-danger' ?>" role="alert">
                    <p class="cord_text_prin mb-1">Este mes se realizó <?= $cantVentasEsteMes ?> ventas</p>
                    <p class="cord_text_seco mb-4"><?= abs($cantVentasEsteMes - $cantVentasMesAnterior) ?> <?= (($cantVentasEsteMes - $cantVentasMesAnterior) >= 0) ? 'más' : 'menos' ?>  que el mes anterior &nbsp; <i class="<?= (($cantVentasEsteMes - $cantVentasMesAnterior) > 0) ? 'color-primary far fa-arrow-alt-circle-up' : '' ?> <?= (($cantVentasEsteMes - $cantVentasMesAnterior) == 0) ? 'fas fa-minus-circle' : '' ?> <?= (($cantVentasEsteMes - $cantVentasMesAnterior) < 0) ? 'color-danger far fa-arrow-alt-circle-down' : '' ?>"></i></p>

                    <p class="cord_img_fondo"><i class="<?= (($cantVentasEsteMes) > 0) ? 'far fa-arrow-alt-circle-up' : 'fas fa-minus-circle' ?>"></i></p>
                    
                </div>
            </div>
            
            <div class="col-3">
                <div class="alert pt-4 card_prin <?= ($costoVentaEsteMes > 0) ? 'alert-success' : 'alert-danger' ?>" role="alert">
                    <p class="cord_text_prin mb-1">Este mes se vendió S/ <?= number_format($costoVentaEsteMes, 2) ?></p>
                    <p class="cord_text_seco mb-0">S/ <?= number_format(abs($costoVentaEsteMes - $costoVentaMesAnterior), 2) ?> <?= (($costoVentaEsteMes - $costoVentaMesAnterior) >= 0) ? 'más' : 'menos' ?>  que el <br> mes anterior &nbsp; <i class="<?= (($costoVentaEsteMes - $costoVentaMesAnterior) > 0) ? 'color-primary far fa-arrow-alt-circle-up' : '' ?> <?= (($costoVentaEsteMes - $costoVentaMesAnterior) == 0) ? 'fas fa-minus-circle' : '' ?> <?= (($costoVentaEsteMes - $costoVentaMesAnterior) < 0) ? 'color-danger far fa-arrow-alt-circle-down' : '' ?>"></i></p>

                    <p class="cord_img_fondo"><i class="<?= (($costoVentaEsteMes) > 0) ? 'far fa-arrow-alt-circle-up' : 'fas fa-minus-circle' ?>"></i></p>
                    
                </div>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="card shadow col-6 card_prod_min" id="div_table_minstock">
                <div class="row">
                    <div class="col-10">
                        <h4 class="text-dark font-weight-bold pt-4 pl-3">Productos con stock minimo:</h4>
                    </div>
                    <div class="col-2 text-right mt-3 pr-4">
                        <button class="btn btn-success" id="print_table_minstock">PDF <i class="far fa-file-pdf"></i></button>
                    </div>
                    
                </div>
                
                <div class="card-body pt-2">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                    foreach ($productosMinimos as $key => $value) { ?>
                                        
                                        <tr>
                                            <td><?= $value['producto_nombre'] ?></td>
                                            <td><?= $value['producto_precioventa'] ?></td>
                                            <td><?= $value['producto_stock'] ?></td>
                                        </tr>
                                    
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
            <div class="col-6" id="cont_ventas">
            </div>
        
        </div>

        <div class="row mb-4">
        
            <div class="card shadow col-6 card_prod_min">
                <div class="row">
                    <div class="col-10">
                        <h4 class="text-dark font-weight-bold pt-4 pl-3">Clientes recurrente:</h4>
                    </div>
                    <div class="col-2 text-right mt-3 pr-4">
                        <button class="btn btn-success" id="print_table_cliente_rec">PDF <i class="far fa-file-pdf"></i></button>
                    </div>
                    
                </div>
                
                <div class="card-body pt-2">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableDash" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="d-none">N°</th>
                                    <th>Nombres/Razón Social</th>
                                    <th>Precio</th>
                                    <th>Ventas</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="d-none">N°</th>
                                    <th>Nombres/Razón Social</th>
                                    <th>Precio</th>
                                    <th>Ventas</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                    foreach ($clientesMasCompradores as $key => $value) 
                                    { 
                                        if ($key == 10) {
                                            break;
                                        }

                                        ?>
                                        
                                        <tr>
                                            <td class="d-none"><?= $key ?></td>
                                            <td><?= $value['cliente_nombre'] ?></td>
                                            <td><?= ($value['total_ventas']) ?></td>
                                            <td><?= $value['cantidad_ventas'] ?></td>
                                        </tr>
                                    
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
            <div class="col-6" id="cont_ventas_soles">
                
            </div>
        
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Logout Modal-->
<div class="modal fade" id="modal-confirma" tabindex="-1" role="dialog" aria-labelledby=""
aria-hidden="true">
<div class="modal-dialog modal-sm" role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Eliminar Registro</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>

    <div class="modal-body">
        ¿Desea eliminar este registro?
    </div>
                            
    <div class="modal-footer">
        <button class="btn btn-light" type="button" data-dismiss="modal">Cancelar</button>
        <a class="btn btn-danger btn-ok" type="button">Si</a>
    </div>
</div>
</div>
</div>