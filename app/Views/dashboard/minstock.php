<div class="card shadow card_prod_min" id="div_table_minstock">
    <div class="row">

        <h4 class="text-dark font-weight-bold pt-4 pl-3">Productos con stock minimo:</h4>
        
    </div>
    
    <div class="card-body pt-2">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable_impr_minstock" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="d-none">N°</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="d-none">N°</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        foreach ($productosMinimos as $key => $value) { ?>
                            
                            <tr>
                                <td class="d-none"><?= $key ?></td>
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