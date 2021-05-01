<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ComprasModel;
    use App\Models\TemporalCompraModel;
    use App\Models\DetalleComprasModel;
    use App\Models\ProductosModel;
    use App\Models\ConfiguracionModel;
    use App\Models\DetallePermisosModel;
    use CodeIgniter\I18n\Time;

    class Compras extends BaseController
    {
        protected $compras, $temCompra, $detCompra, $productos, $configuracion;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;
        protected $reglas;

        public function __construct()
        {
            $this -> compras = new ComprasModel();
            $this -> detCompra = new DetalleComprasModel();
            $this -> detPermisos = new DetallePermisosModel();
            $this -> configModel = new ConfiguracionModel();

            $this -> datosTienda = $this -> configModel -> getDatosTienda();

            $this -> session = session();

            if (is_null($this -> session -> id_usuario)) 
            {
                $this -> isLogin = false;
            }
            else
            {
                $this -> permisosUser = $this -> detPermisos -> getPermisosPorUsuario($this -> session -> id_usuario);
            }

            helper(['form']);
        }

        public function index()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[5])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $msg = null;

            if (!is_null($this -> session -> yavendido)) 
            {
                if ($this -> session -> yavendido == 'verdadero') 
                {
                    $msg = 'Uno de los productos de la compra ya se vendió, y debido a ello no se puede anular.';
                }
            }

            $compras = $this -> compras -> select('SUM(det_compra_precio * det_compra_cantidad) AS compratotal, compra.*') -> join('det_compra', 'det_compra.compra_id = compra.compra_id') -> where('compra_ustate', 1) -> groupBy("det_compra.compra_id") -> findAll();
            
            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Compras', 
                'datos' => $compras,
                'msg' => $msg
            ];

            echo view('header', $dataHeader);
            echo view('compras/compras');
            echo view('footer');
        }

        public function nuevo($idCompra = null, $lastPro = null)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[6])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Nueva Compra',
                'idCompra' => $idCompra,
                'lastPro' => $lastPro
            ];

            echo view('header', $dataHeader);
            echo view('compras/nuevo');
            echo view('footer');
        }

        public function guarda()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[6])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
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

        public function anular($idCompra = null)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[5])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            if (is_null($idCompra)) 
            {
                return redirect() -> to(base_url() . '/compras');
            }

            $compra = $this -> compras -> where('compra_id', $idCompra) -> where('compra_ustate', 1) -> first();
            
            if (is_null($compra)) 
            {
                return redirect() -> to(base_url() . '/compras');
            }

            date_default_timezone_set('America/Lima');

            $now = Time::now('America/Lima', 'es_ES');

            $dateCompra = Time::createFromFormat('Y-m-d H:i:s', $compra['compra_creation'], 'America/Lima');
            
            $dateCompra = $dateCompra -> addHours(1);
            
            if ($dateCompra -> isBefore($now)) 
            { 
                return redirect() -> to(base_url() . '/compras');
            }

            $detCompra = $this -> detCompra -> join('producto', 'producto.producto_id = det_compra.producto_id') -> where('compra_id', $idCompra) -> findAll();

            $cumple = true;

            foreach ($detCompra as $key => $value) 
            {
                if ($value["det_compra_cantidad"] > $value["producto_stock"]) 
                {
                    $cumple = false;
                    break;
                }
            }

            if (!$cumple) {
                return redirect()->back()->with('yavendido', 'verdadero');
            }

            echo json_encode($cumple); die;
        }

        public function muestraCompraPdf($idCompra = 0)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[5])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            $data['idcompra'] = $idCompra;

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Compras ' . $idCompra, 
            ];

            echo view('header', $dataHeader);
            echo view('compras/vercomprapdf', $data);
            echo view('footer');
        }

        public function generacomprapdf($idCompra = 0)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[5])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $datosCompra = $this -> compras -> where('compra_id', $idCompra) -> first();

            $compraTotal = $this -> detCompra -> select('SUM(det_compra_precio * det_compra_cantidad) AS total') -> where('compra_id', $idCompra) -> first();
            
            $detalleCompra = $this -> detCompra -> where('compra_id', $idCompra) -> findAll();

            $nombreTienda = $this -> datosTienda['nombreTienda'];

            $direcionTienda = $this -> datosTienda['direccionTienda'];

            $pdf = new \FPDF('P', 'mm', 'letter');
            $pdf -> AddPage();
            $pdf -> SetMargins(10, 10, 10);
            $pdf -> setTitle('Compra ' . $idCompra);
            $pdf -> SetFont('Arial', 'B', 10);

            $pdf -> Cell(195, 5, 'Entrada de productos', 0, 1, 'C');

            $pdf -> SetFont('Arial', 'B', 9);

            $pdf -> Image(base_url() . '/img/logopos.png', 185, 10, 20, 20, 'PNG');

            $pdf -> Cell(50, 5, $nombreTienda, 0, 1, 'L');
            $pdf -> Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(50, 5, utf8_decode($direcionTienda), 0, 1, 'L');
            
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
            $pdf -> Cell(195, 5, 'Total: ' . 'S/ ' . number_format($compraTotal["total"], 2, '.',"'"), 0, 1, 'R');

            $this -> response -> setHeader('Content-Type', 'application/pdf');

            $pdf -> Output('Compra_pdf_' . $idCompra . '.pdf', 'I');
        }
    }