<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\TemporalCompraModel;
    use App\Models\ProductosModel;

    class TemporalCompra extends BaseController
    {
        protected $temCompra, $productos;
        protected $reglas;

        public function __construct()
        {
            $this -> temCompra = new TemporalCompraModel();
            $this -> productos = new ProductosModel();
        }

        public function insertar($idProducto, $cantidad, $idCompra)
        {
            $error = '';
            $producto = $this -> productos -> where('producto_id', $idProducto) -> first();
            
            if ($producto) 
            {
                $datosExisten = $this -> temCompra -> porIdProductoCompra($idProducto, $idCompra);

                if ($datosExisten) 
                {
                    $cantidad = $datosExisten -> tem_compra_cantidad + $cantidad;
                    $subTotal = $cantidad * $datosExisten -> tem_compra_precio;

                    $this -> temCompra -> actualizarProductoCompra($idProducto, $idCompra, $cantidad, $subTotal);
                }
                else
                {
                    $subTotal = $cantidad * $producto['producto_preciocompra'];

                    $this -> temCompra -> save([
                        'tem_compra_folio' => $idCompra, 
                        'producto_id' => $idProducto,
                        'tem_compra_codigo' => $producto['producto_codigo'],
                        'tem_compra_nombre' => $producto['producto_nombre'],
                        'tem_compra_precio' => $producto['producto_preciocompra'],
                        'tem_compra_cantidad' => $cantidad,
                        'tem_compra_subtotal' => $subTotal
                    ]);
                }
            }
            else
            {
                $error = 'No existe el producto';
            }

            $res['error'] = $error;
            $res['datos'] = $this -> cargaProductos($idCompra);
            $res['totalinput'] = number_format($this -> totalProductos($idCompra), 2, '.', '');
            $res['total'] = number_format($this -> totalProductos($idCompra), 2, '.', "'");

            print_r(json_encode($res));

        }

        public function actualizarTabla($idCompra = null)
        {
            $error = '';

            $res['error'] = $error;
            $res['datos'] = $this -> cargaProductos($idCompra);
            $res['totalinput'] = number_format($this -> totalProductos($idCompra), 2, '.', '');
            $res['total'] = number_format($this -> totalProductos($idCompra), 2, '.', "'");

            print_r(json_encode($res));
        }

        public function cargaProductos($idCompra)
        {
            $resultado = $this -> temCompra -> porCompra($idCompra);
            $fila = '';
            $numFila = 0;
            
            foreach ($resultado as $key => $value) 
            {
                $numFila++;
                $fila = $fila . '<tr id="fila-"' . $numFila . '>';
                $fila = $fila . '<td>' . $numFila . '</td>';
                $fila = $fila . '<td>' . $value['tem_compra_codigo'] . '</td>';
                $fila = $fila . '<td>' . $value['tem_compra_nombre'] . '</td>';
                $fila = $fila . '<td>' . $value['tem_compra_precio'] . '</td>';
                $fila = $fila . '<td>' . $value['tem_compra_cantidad'] . '</td>';
                $fila = $fila . '<td>' . $value['tem_compra_subtotal'] . '</td>';
                $fila = $fila . '<td><button class="btn btn-danger btn-deleteProducto" type="button" data-idproducto="' . $value['producto_id'] . '" data-idcompra="' . $idCompra . '"><i class="fas fa-trash-alt"></i></button></td>';
                $fila = $fila . '</tr>';
            }

            return $fila;
        }

        public function totalProductos($idCompra)
        {
            $resultado = $this -> temCompra -> porCompra($idCompra);
            $total = 0;

            foreach ($resultado as $key => $value) 
            {
                $total = $total + $value['tem_compra_subtotal'];
            }

            return $total;
        }

        public function eliminar($idProducto, $idCompra)
        {
            $datosExisten = $this -> temCompra -> porIdProductoCompra($idProducto, $idCompra);

            if ($datosExisten) 
            {
                if ($datosExisten -> tem_compra_cantidad > 1) 
                {
                    $cantidad = $datosExisten -> tem_compra_cantidad - 1;
                    $subTotal = $cantidad * $datosExisten -> tem_compra_precio;

                    $this -> temCompra -> actualizarProductoCompra($idProducto, $idCompra, $cantidad, $subTotal);
                }
                else
                {
                    $this -> temCompra -> eliminarProductoCompra($idProducto, $idCompra);
                }

                $res['error'] = '';
                $res['datos'] = $this -> cargaProductos($idCompra);
                $res['total'] = number_format($this -> totalProductos($idCompra), 2, '.', "'");

                print_r(json_encode($res));
            }
        }

    }