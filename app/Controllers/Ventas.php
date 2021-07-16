<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\VentasModel;
    use App\Models\CajasModel;
    use App\Models\UsuariosModel;
    use App\Models\ClientesModel;
    use App\Models\TemporalCompraModel;
    use App\Models\DetalleVentasModel;
    use App\Models\ProductosModel;
    use App\Models\ConfiguracionModel;
    use App\Models\DetallePermisosModel;
    use CodeIgniter\I18n\Time;

    class Ventas extends BaseController
    {
        protected $ventas, $temCompra, $detVenta, $productos, $cajas, $usuarios;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;
        protected $configModel, $datosTienda;

        public function __construct()
        {
            $this -> ventas = new VentasModel();
            $this -> clientes = new ClientesModel();
            $this -> cajas = new CajasModel();
            $this -> usuarios = new UsuariosModel();
            $this -> detVenta = new DetalleVentasModel();
            $this -> configModel = new ConfiguracionModel();
            $this -> detPermisos = new DetallePermisosModel();
            $this -> productos = new ProductosModel();
            
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
                if (!isset($this -> permisosUser[7])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $msg = null;

            $datos = $this -> ventas -> obtener(1);

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Ventas Realizadas', 
                'datos' => $datos,
                'msg' => $msg
            ];

            echo view('header', $dataHeader);
            echo view('ventas/ventas');
            echo view('footer');
        }

        public function eliminados()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[7])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $datos = $this -> ventas -> obtener(0);

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Ventas Anuladas', 
                'datos' => $datos
            ];

            echo view('header', $dataHeader);
            echo view('ventas/eliminados');
            echo view('footer');
        }

        public function ventas()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[8])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $infoUsuario = $this -> usuarios -> where('usuario_id', $this -> session -> id_usuario) -> first();
            
            $caja = $this -> cajas -> where('caja_id', $infoUsuario["caja_id"]) -> whereNotIn('caja_id', array(0)) -> where('caja_state', 1) -> first();

            $clienteDefecto = $this -> clientes -> where('cliente_id', 1) -> first();
            
            if (!is_null($caja)) 
            {
                $dataHeader = [
                    'permisos' => $this -> permisosUser,
                    'logoTienda' => $this -> datosTienda['logoTienda'],
                    'nombreTienda' => $this -> datosTienda['nombreTienda'],
                    'caja' => $caja,
                    'title' => 'Nueva Venta', 
                    'clienteDefecto' => $clienteDefecto
                ];
            }
            else
            {
                $dataHeader = [
                    'permisos' => $this -> permisosUser,
                    'logoTienda' => $this -> datosTienda['logoTienda'],
                    'nombreTienda' => $this -> datosTienda['nombreTienda'],
                    'caja' => $caja,
                    'title' => 'Usted no está asignado a una caja',
                    'clienteDefecto' => $clienteDefecto
                ];
            }
            
            echo view('header', $dataHeader);
            echo view('ventas/caja');
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
                if (!isset($this -> permisosUser[8])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $idVenta = $this -> request -> getPost('id_venta');
            $formaPago = $this -> request -> getPost('forma_pago');
            $idCliente = $this -> request -> getPost('id_cliente');
            $total = $this -> request -> getPost('total');
            
            $session = session();
            
            $idUsuario = $session -> id_usuario;

            $usuarioAct = $this -> usuarios -> join('caja', 'caja.caja_id = usuario.caja_id') -> where('usuario_id', $idUsuario) -> where('usuario_state', 1) -> where('caja_state', 1) -> whereNotIn('caja.caja_id', array(0)) -> first();
            
            if (is_null($usuarioAct)) 
            {
                return redirect() -> to(base_url() . '/dashboard');
            }
            
            $resultadoId = $this -> ventas -> insertaVenta($idVenta, $total, $idUsuario, $usuarioAct['caja_id'], $idCliente, $formaPago);

            $this -> temCompra = new TemporalCompraModel();
            
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

        public function muestraTicket($idVenta = null)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[7]) && !isset($this -> permisosUser[8])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $venta = $this -> ventas -> where('venta_id', $idVenta) -> first();

            if (is_null($venta)) 
            {
                return redirect() -> to(base_url() . '/ventas');
            }

            $comple = '';

            if ($venta['venta_state'] == 0) 
            {
                $comple = ' - Venta Anulada';
            }

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Venta ' . $idVenta . $comple,  
                'idventa' => $idVenta
            ];

            echo view('header', $dataHeader);
            echo view('ventas/verticket');
            echo view('footer');
        }

        public function generaTicket($idVenta)
        {
            $datosVenta = $this -> ventas -> where('venta_id', $idVenta) -> first();

            $detalleVenta = $this -> detVenta -> where('venta_id', $idVenta) -> findAll();

            $nombreTienda = $this -> datosTienda['nombreTienda'];
            
            $direcionTienda = $this -> datosTienda['direccionTienda'];

            $leyendaTiket = $this -> datosTienda['leyendaTicket'];

            $cliente = $this -> clientes -> where('cliente_id', $datosVenta['cliente_id']) -> first();
            
            $pdf = new \PDFRotate('P', 'mm', array(150, 250));
            $pdf -> AddPage();
            $pdf -> SetMargins(5, 5, 5);
            $pdf -> setTitle('Venta');
            $pdf -> SetFont('Arial', 'B', 20);

            $pdf -> SetY(10);
            $pdf -> SetX(5);

            $pdf -> Cell(80, 5, utf8_decode($nombreTienda), 0, 1, 'C');

            $pdf -> SetFont('Arial', 'B', 9);

            $pdf -> Image(base_url() . '/public/img/logopos.png', 7, 8, 15, 15, 'PNG');

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(80, 5, utf8_decode($direcionTienda), 0, 0, 'C');
            $pdf -> Cell(10, 5, '', 0, 0, 'C');
            $pdf -> Cell(40, 5, 'R.U.C. ' . $this -> datosTienda['rucTienda'], 1, 1, 'C');

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(80, 5, utf8_decode('Cel.: ' . $this -> datosTienda['telefonoTienda']), 0, 0, 'C');
            $pdf -> Cell(10, 5, '', 0, 0, 'C');
            $pdf -> SetFillColor(227, 230, 233);
            $pdf -> Cell(40, 5, 'BOLETA DE VENTA', 1, 1, 'C', 1);

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(80, 5, utf8_decode('E-Mail: ' . $this -> datosTienda['emailTienda']), 0, 0, 'C');
            $pdf -> Cell(10, 5, '', 0, 0, 'C');

            $auxNumero = $idVenta;
            $auxNumero = strval($auxNumero);
            $count = strlen($auxNumero);

            switch ($count) {
                case 1:
                    $auxNumero = '0000' . $auxNumero;
                    break;
                case 2:
                    $auxNumero = '000' . $auxNumero;
                    break;
                case 3:
                    $auxNumero = '00' . $auxNumero;
                    break;
                case 4:
                    $auxNumero = '0' . $auxNumero;
                    break;
                default:
                    break;
            }

            $pdf -> Cell(40, 5, utf8_decode('N° - ' . $auxNumero), 1, 1, 'C');

            $pdf -> SetFont('Arial', 'B', 9);
            $pdf -> Cell(37, 3,  '', 0, 1, 'L');
            $pdf -> Cell(16, 5,  utf8_decode('DNI/RUC: '), 0, 0, 'L');

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(50, 5, $cliente['cliente_dni'], 0, 1, 'L');

            $pdf -> SetFont('Arial', 'B', 9);
            $pdf -> Cell(37, 5,  utf8_decode('Nombres/Razón Social: '), 0, 0, 'L');

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(50, 5, $cliente['cliente_nombre'], 0, 1, 'L');

            $pdf -> SetFont('Arial', 'B', 9);
            $pdf -> Cell(18, 5,  utf8_decode('Dirección: '), 0, 0, 'L');

            $pdf -> SetFont('Arial', '', 9);

            if ($cliente['cliente_direccion'] == '' || is_null($cliente['cliente_direccion'])) 
            {
                $cliente['cliente_direccion'] = '............................................................................................';
            } 
            elseif (strlen($cliente['cliente_direccion']) > 60) 
            {
                $cliente['cliente_direccion'] = substr($cliente['cliente_direccion'], 0, 60) . '...';
            }

            $pdf -> Cell(70, 5, $cliente['cliente_direccion'], 0, 1, 'L');
            
            $pdf -> SetFont('Arial', 'B', 9);
            $pdf -> Cell(24, 5, 'Fecha y Hora: ', 0, 0, 'L');

            $pdf -> SetFont('Arial', '', 9);
            $pdf -> Cell(50, 5, $datosVenta['venta_creation'], 0, 1, 'L');

            $pdf -> Ln();
            $pdf -> SetFont('Arial', 'B', 9);

            $pdf -> Cell(11, 5, 'Cant.', 1, 0, 'L');
            $pdf -> Cell(83, 5, 'Nombre', 1, 0, 'L');
            $pdf -> Cell(23, 5, 'Precio', 1, 0, 'L');
            $pdf -> Cell(23, 5, 'Importe', 1, 1, 'L');

            $pdf -> SetFont('Arial', '', 9);

            foreach ($detalleVenta as $key => $value) 
            {
                $pdf -> Cell(11, 5, utf8_decode($value['det_venta_cantidad']), 1, 0, 'C');
                $pdf -> Cell(83, 5, utf8_decode($value['det_venta_nombre']), 1, 0, 'L');
                $pdf -> Cell(23, 5, 'S/ ' . number_format($value['det_venta_precio'], 2, '.',"'"), 1, 0, 'L');
                $importe = number_format($value['det_venta_precio'] * $value['det_venta_cantidad'], 2, '.',"'");
                $pdf -> Cell(23, 5, 'S/ ' . $importe, 1, 1, 'R');
            }
            
            $pdf -> Cell(37, 1,  '', 0, 1, 'L');
            $pdf -> Cell(105, 5,  '', 0, 0, 'L');

            $pdf -> SetFont('Arial', 'B', 9);
            $pdf -> Cell(35, 5, 'Total: ' . 'S/ ' . number_format($datosVenta['venta_total'], 2, '.',"'"), 0, 1, 'R');

            $pdf -> MultiCell(140, 5, $leyendaTiket, 0, 'C');

            if ($datosVenta['venta_state'] == 0) 
            {
                $pdf -> SetFont('Arial', 'B', 70);
                $pdf -> SetTextColor(220,50,50);

                //$pdf -> Cell(195, 5, 'ANULADO', 0, 1, 'C');
                $pdf->RotatedText(60,130,'ANULADO', 70);
            }

            $this -> response -> setHeader('Content-Type', 'application/pdf');

            $pdf -> Output('Ticket.pdf', 'I');
        }

        public function anular($idVenta = null)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[7])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            if (is_null($idVenta)) 
            {
                return redirect() -> to(base_url() . '/ventas');
            }

            $venta = $this -> ventas -> where('venta_id', $idVenta) -> where('venta_state', 1) -> first();
            
            if (is_null($venta)) 
            {
                return redirect() -> to(base_url() . '/ventas');
            }

            date_default_timezone_set('America/Lima');

            $now = Time::now('America/Lima', 'es_ES');

            $dateVenta = Time::createFromFormat('Y-m-d H:i:s', $venta['venta_creation'], 'America/Lima');
            
            $dateVenta = $dateVenta -> addDays(3);
            
            if ($dateVenta -> isBefore($now)) 
            { 
                return redirect() -> to(base_url() . '/ventas');
            }

            $detVenta = $this -> detVenta -> join('producto', 'producto.producto_id = det_venta.producto_id') -> where('venta_id', $idVenta) -> findAll();
            
            foreach ($detVenta as $key => $value) 
            {
                $this -> productos -> actualizaStock($value['producto_id'], $value['det_venta_cantidad'], '+');
            }

            $this -> ventas -> set('venta_state', 0) -> where('venta_id', $idVenta) -> update();

            return redirect() -> to(base_url() . '/ventas');
        }
    }