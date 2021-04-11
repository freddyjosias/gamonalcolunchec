<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\VentasModel;
    use App\Models\TemporalCompraModel;
    use App\Models\DetalleVentasModel;
    use App\Models\ProductosModel;
    use App\Models\ConfiguracionModel;

    class Ventas extends BaseController
    {
        protected $ventas, $temCompra, $detVenta, $productos;

        public function __construct()
        {
            $this -> ventas = new VentasModel();
            $this -> detVenta = new DetalleVentasModel();
            $this -> configuracion = new ConfiguracionModel();
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
            $idVenta = $this -> request -> getPost('id_venta');
            $formaPago = $this -> request -> getPost('forma_pago');
            $idCliente = $this -> request -> getPost('id_cliente');
            $total = $this -> request -> getPost('total');
            
            $session = session();
            
            $idUsuario = $session -> id_usuario;
            
            $resultadoId = $this -> ventas -> insertaVenta($idVenta, $total, $idUsuario, $session -> id_caja, $idCliente, $formaPago);

            $this -> temCompra = new TemporalCompraModel();
            $this -> productos = new ProductosModel();
            
            if ($resultadoId) 
            {
                $resultadoCompra = $this -> temCompra -> porCompra($idVenta);

                foreach ($resultadoCompra as $key => $value) 
                {
                    $this -> detVenta -> save([
                        'venta_id' => $resultadoId,
                        'producto_id' => $value['producto_id'],
                        'det_venta_nombre' => $value['tem_compra_nombre'],
                        'det_venta_cantidad' => $value['tem_compra_cantidad'],
                        'det_venta_precio' => $value['tem_compra_precio']
                    ]);

                    $this -> productos -> actualizaStock($value['producto_id'], $value['tem_compra_cantidad'], '-');
                }

                $this -> temCompra -> eliminarCompra($idVenta);
            }

            return redirect() -> to(base_url() . '/ventas/muestraticket/' . $resultadoId);
        }

        public function muestraTicket($idVenta)
        {
            $data['idcompra'] = $idVenta;
            echo view('header');
            echo view('ventas/verticket', $data);
            echo view('footer');
        }

        public function generaTicket($idVenta)
        {
            $datosVenta = $this -> ventas -> where('venta_id', $idVenta) -> first();

            $detalleVenta = $this -> detVenta -> where('venta_id', $idVenta) -> findAll();

            $nombreTienda = $this -> configuracion -> select('configuracion_valor') -> where('configuracion_nombre', 'nombre_tienda') -> get() -> getRow() -> configuracion_valor;

            $direcionTienda = $this -> configuracion -> select('configuracion_valor') -> where('configuracion_nombre', 'tienda_direccion') -> get() -> getRow() -> configuracion_valor;

            $leyendaTiket = $this -> configuracion -> select('configuracion_valor') -> where('configuracion_nombre', 'ticket_leyenda') -> get() -> getRow() -> configuracion_valor;

            $pdf = new \FPDF('P', 'mm', array(80, 200));
            $pdf -> AddPage();
            $pdf -> SetMargins(5, 5, 5);
            $pdf -> setTitle('Venta');
            $pdf -> SetFont('Arial', 'B', 10);

            $pdf -> Cell(70, 5, $nombreTienda, 0, 1, 'C');

            $pdf -> SetFont('Arial', 'B', 9);

            $pdf -> Image(base_url() . '/img/logopos.png', 10, 0, 20, 20, 'PNG');

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(70, 5, $direcionTienda, 0, 1, 'C');
            
            $pdf -> SetFont('Arial', 'B', 9);
            $pdf -> Cell(25, 5, 'Fecha y hora: ', 0, 0, 'L');

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(50, 5, $datosVenta['venta_creation'], 0, 1, 'L');

            $pdf -> SetFont('Arial', 'B', 9);
            $pdf -> Cell(25, 5, 'Ticket: ', 0, 0, 'L');

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(50, 5, $datosVenta['venta_folio'], 0, 1, 'L');

            $pdf -> Ln();
            $pdf -> SetFont('Arial', 'B', 7);

            $pdf -> Cell(7, 5, 'Cant.', 0, 0, 'L');
            $pdf -> Cell(35, 5, 'Nombre', 0, 0, 'L');
            $pdf -> Cell(15, 5, 'Precio', 0, 0, 'L');
            $pdf -> Cell(15, 5, 'Importe', 0, 1, 'L');

            $pdf -> SetFont('Arial', '', 7);

            foreach ($detalleVenta as $key => $value) 
            {
                $pdf -> Cell(7, 5, utf8_decode($value['det_venta_cantidad']), 0, 0, 'L');
                $pdf -> Cell(35, 5, utf8_decode($value['det_venta_nombre']), 0, 0, 'L');
                $pdf -> Cell(15, 5, 'S/ ' . number_format($value['det_venta_precio'], 2, '.',"'"), 0, 0, 'L');
                $importe = number_format($value['det_venta_precio'] * $value['det_venta_cantidad'], 2, '.',"'");
                $pdf -> Cell(15, 5, 'S/ ' . $importe, 0, 1, 'R');
            }
            
            $pdf -> Ln();

            $pdf -> SetFont('Arial', 'B', 8);
            $pdf -> Cell(70, 5, 'Total: ' . 'S/ ' . number_format($datosVenta['venta_total'], 2, '.',"'"), 0, 1, 'R');

            $pdf -> Ln();
            $pdf -> MultiCell(70, 5, $leyendaTiket, 0, 'C');

            $this -> response -> setHeader('Content-Type', 'application/pdf');

            $pdf -> Output('Ticket.pdf', 'I');
        }
    }