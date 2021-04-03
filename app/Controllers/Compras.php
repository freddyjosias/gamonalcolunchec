<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ComprasModel;
    use App\Models\TemporalCompraModel;
    use App\Models\DetalleComprasModel;
    use App\Models\ProductosModel;
    use App\Models\ConfiguracionModel;

    class Compras extends BaseController
    {
        protected $compras, $temCompra, $detCompra, $productos, $configuracion;
        protected $reglas;

        public function __construct()
        {
            $this -> compras = new ComprasModel();
            $this -> detCompra = new DetalleComprasModel();
            $this -> configuracion = new ConfiguracionModel();
            helper(['form']);
        }

        public function index($state = 1)
        {
            $compras = $this -> compras -> where('unidad_state', $state) -> findAll();
            $data = ['title' => 'Compras', 'datos' => $compras];

            echo view('header');
            echo view('compras/compras', $data);
            echo view('footer');
        }

        public function nuevo()
        {
            echo view('header');
            echo view('compras/nuevo');
            echo view('footer');
        }

        public function guarda()
        {
            $idCompra = $this -> request -> getPost('id_compra');
            $total = $this -> request -> getPost('total');
            
            $session = session();
            
            $idUsuario = $session -> id_usuario;

            $resultadoId = $this -> compras -> insertaCompra($idCompra, $total, $idUsuario);

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

            return redirect() -> to(base_url() . '/compras/muestracomprapdf/' . $resultadoId);
        }

        public function muestraCompraPdf($idCompra)
        {
            $data['idcompra'] = $idCompra;
            echo view('header');
            echo view('compras/vercomprapdf', $data);
            echo view('footer');
        }

        public function generacomprapdf($idCompra)
        {
            $datosCompra = $this -> compras -> where('compra_id', $idCompra) -> first();

            $detalleCompra = $this -> detCompra -> where('compra_id', $idCompra) -> findAll();

            $nombreTienda = $this -> configuracion -> select('configuracion_valor') -> where('configuracion_nombre', 'nombre_tienda') -> get() -> getRow() -> configuracion_valor;

            $direcionTienda = $this -> configuracion -> select('configuracion_valor') -> where('configuracion_nombre', 'tienda_direccion') -> get() -> getRow() -> configuracion_valor;

            $pdf = new \FPDF('P', 'mm', 'letter');
            $pdf -> AddPage();
            $pdf -> SetMargins(10, 10, 10);
            $pdf -> setTitle('Compra');
            $pdf -> SetFont('Arial', 'B', 10);

            $pdf -> Cell(195, 5, 'Entrada de productos', 0, 1, 'C');

            $pdf -> SetFont('Arial', 'B', 9);

            $pdf -> Image(base_url() . '/img/logopos.png', 185, 10, 20, 20, 'PNG');

            $pdf -> Cell(50, 5, $nombreTienda, 0, 1, 'L');
            $pdf -> Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(50, 5, $direcionTienda, 0, 1, 'L');
            
            $pdf -> SetFont('Arial', 'B', 9);
            $pdf -> Cell(25, 5, 'Fecha y hora: ', 0, 0, 'L');

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(50, 5, $datosCompra['compra_creation'], 0, 1, 'L');

            $pdf -> Ln();
            $pdf -> SetFont('Arial', 'B', 8);
            $pdf -> SetFillColor(0,0,0);
            $pdf -> SetTextColor(255,255,255);

            $pdf -> Cell(196, 5, 'Detalle de productos', 1, 1, 'C', 1);

            $pdf -> SetTextColor(0,0,0);

            $pdf -> Cell(14, 5, utf8_decode('Nº'), 1, 0, 'L');
            $pdf -> Cell(25, 5, 'Codigo', 1, 0, 'L');
            $pdf -> Cell(77, 5, 'Nombre', 1, 0, 'L');
            $pdf -> Cell(25, 5, 'Precio', 1, 0, 'L');
            $pdf -> Cell(25, 5, 'Cantidad', 1, 0, 'L');
            $pdf -> Cell(30, 5, 'Importe', 1, 1, 'L');

            $pdf -> SetFont('Arial', '', 8);

            foreach ($detalleCompra as $key => $value) 
            {
                $pdf -> Cell(14, 5, $key + 1, 1, 0, 'L');
                $pdf -> Cell(25, 5, utf8_decode($value['producto_id']), 1, 0, 'L');
                $pdf -> Cell(77, 5, utf8_decode($value['det_compra_nombre']), 1, 0, 'L');
                $pdf -> Cell(25, 5, 'S/ ' . number_format($value['det_compra_precio'], 2, '.',"'"), 1, 0, 'L');
                $pdf -> Cell(25, 5, utf8_decode($value['det_compra_cantidad']), 1, 0, 'L');
                $importe = number_format($value['det_compra_precio'] * $value['det_compra_cantidad'], 2, '.',"'");
                $pdf -> Cell(30, 5, 'S/ ' . $importe, 1, 1, 'R');
            }
            
            $pdf -> Ln();

            $pdf -> SetFont('Arial', 'B', 8);
            $pdf -> Cell(195, 5, 'Total: ' . 'S/ ' . number_format($datosCompra['compra_total'], 2, '.',"'"), 0, 1, 'R');

            $this -> response -> setHeader('Content-Type', 'application/pdf');

            $pdf -> Output('Compra_pdf.pdf', 'I');
        }
    }