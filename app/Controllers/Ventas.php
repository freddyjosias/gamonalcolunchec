<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\VentasModel;
    use App\Models\TemporalCompraModel;
    use App\Models\DetalleVentasModel;
    use App\Models\ProductosModel;

    class Ventas extends BaseController
    {
        protected $ventas, $temCompra, $detVenta, $productos;

        public function __construct()
        {
            $this -> ventas = new VentasModel();
            $this -> detVenta = new DetalleVentasModel();
            helper(['form']);
        }

        public function index($state = 1)
        {
            $ventas = $this -> ventas -> where('compra_ustate', $state) -> findAll();
            $data = ['title' => 'Ventas', 'datos' => $ventas];

            echo view('header');
            echo view('ventas/ventas', $data);
            echo view('footer');
        }

        public function ventas()
        {
            echo view('header');
            echo view('ventas/caja');
            echo view('footer');
        }

        public function guarda()
        {
            $idCompra = $this -> request -> getPost('id_compra');
            $total = $this -> request -> getPost('total');
            
            $session = session();
            
            $idUsuario = $session -> id_usuario;

            $resultadoId = $this -> ventas -> insertaCompra($idCompra, $total, $idUsuario);

            $this -> temCompra = new TemporalCompraModel();
            $this -> productos = new ProductosModel();
            
            if ($resultadoId) 
            {
                $resultadoCompra = $this -> temCompra -> porCompra($idCompra);

                foreach ($resultadoCompra as $key => $value) 
                {
                    $this -> detCompra -> save([
                        'compra_id' => $resultadoId,
                        'producto_id' => $value['producto_id'],
                        'det_compra_nombre' => $value['tem_compra_nombre'],
                        'det_compra_cantidad' => $value['tem_compra_cantidad'],
                        'det_compra_precio' => $value['tem_compra_precio']
                    ]);

                    $this -> productos -> actualizaStock($value['producto_id'], $value['tem_compra_cantidad']);
                }

                $this -> temCompra -> eliminarCompra($idCompra);
            }

            return redirect() -> to(base_url() . '/ventas/muestracomprapdf/' . $resultadoId);
        }
    }