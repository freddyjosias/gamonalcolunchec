<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ProductosModel;
    use App\Models\ConfiguracionModel;
    use App\Models\DetallePermisosModel;
    use App\Models\VentasModel;
    use CodeIgniter\I18n\Time;

    class Dashboard extends BaseController
    {
        protected $isLogin = true, $detPermisos, $session, $permisosUser;
        protected $configModel, $datosTienda;

        public function __construct()
        {
            $this -> detPermisos = new DetallePermisosModel();
            $this -> productos = new ProductosModel();
            $this -> configModel = new ConfiguracionModel();
            $this -> ventas = new VentasModel();

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
        }

        public function index()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }

            $ventasHoy = $this -> ventas -> like('venta_creation', date('Y-m-d')) -> where('venta_state', 1) -> findAll();
            
            $time = new Time('-1 day');
            $ventasAyer = $this -> ventas -> like('venta_creation', $time -> toDateString()) -> where('venta_state', 1) -> findAll();
            
            $now = new Time('now');
            $time = new Time('-' . ($now -> getDayOfWeek() - 1) . ' day');
            
            $ventasEstaSemana = array();

            while ($now > $time) 
            {
                $ventasAux = $this -> ventas -> like('venta_creation', $time -> toDateString()) -> where('venta_state', 1) -> findAll();

                foreach ($ventasAux as $key => $value) 
                {
                    array_push($ventasEstaSemana, $value);
                }

                $time = $time->addDays(1);
            }

            $time = new Time('-' . ($now -> getDayOfWeek()) . ' day');
            $auxTime = new Time('-' . ($now -> getDayOfWeek() - 1) . ' day');
            $time = $time -> subDays(6);

            $ventasSemanaAnterior = array();

            while ($auxTime > $time) 
            {
                $ventasAux = $this -> ventas -> like('venta_creation', $time -> toDateString()) -> where('venta_state', 1) -> findAll();
                
                foreach ($ventasAux as $key => $value) 
                {
                    array_push($ventasSemanaAnterior, $value);
                }
                
                $time = $time -> addDays(1);
            }
            
            //$ventasEstaSemana = $this -> ventas -> where("venta_creation BETWEEN '" . $time -> toDateString() . "' AND '" . $time -> toDateString()) -> where('venta_state', 1) -> findAll();

            $time = Time::createFromFormat('Y-m-d', $now -> getYear() . '-' . $now -> getMonth() . '-1', 'America/Lima');
            
            $ventasEsteMes = array();
            $costoVentaEsteMes = 0;
            while ($now > $time) 
            {
                $ventasAux = $this -> ventas -> like('venta_creation', $time -> toDateString()) -> where('venta_state', 1) -> findAll();
                
                foreach ($ventasAux as $key => $value) 
                { 
                    $costoVentaEsteMes = $costoVentaEsteMes + $value['venta_total'];
                    array_push($ventasEsteMes, $value);
                }

                $time = $time->addDays(1);
            }

            $monthDate = $now -> getMonth() - 1;
            $yearDate = $now -> getYear();

            if ($monthDate == 0) {
                $monthDate = 12;
                $yearDate--;
            }
            
            $time = Time::createFromFormat('Y-m-d', $yearDate . '-' . $monthDate . '-1', 'America/Lima');
            $auxTime = Time::createFromFormat('Y-m-d', $now -> getYear() . '-' . $now -> getMonth() . '-1', 'America/Lima');

            $ventasMesAnterior = array();
            $costoVentaMesAnterior = 0;

            while ($auxTime > $time) 
            {
                $ventasAux = $this -> ventas -> like('venta_creation', $time -> toDateString()) -> where('venta_state', 1) -> findAll();
                
                foreach ($ventasAux as $key => $value) 
                {
                    $costoVentaMesAnterior = $costoVentaMesAnterior + $value['venta_total'];
                    array_push($ventasMesAnterior, $value);
                }
                
                $time = $time -> addDays(1);
            }

            $productosMinimos = array();

            $productosAll = $this -> productos -> where('producto_state', 1) -> findAll();

            foreach ($productosAll as $key => $value) 
            {
                if ($value['producto_stock'] <= $value['producto_stockminimo']) {
                    array_push($productosMinimos, $value);
                }
            }

            $clientesMasCompradores = $this -> ventas -> select('*, count(venta_id) AS cantidad_ventas, SUM(venta_total) AS total_ventas',) -> join('cliente', 'cliente.cliente_id = venta.cliente_id') -> where('venta_state', 1) -> groupBy('cliente.cliente_id') -> orderBy('count(venta_id)', 'DESC') -> orderBy('SUM(venta_total)', 'DESC') -> findAll();
            
            //echo json_encode($clientesMasCompradores); die;

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Dashboard',
                'cantVentasHoy' => count($ventasHoy),
                'cantVentasEstaSemana' => count($ventasEstaSemana),
                'cantVentasSemanaAnterior' => count($ventasSemanaAnterior),
                'cantVentasMesAnterior' => count($ventasMesAnterior),
                'cantVentasEsteMes' => count($ventasEsteMes),
                'costoVentaMesAnterior' => $costoVentaMesAnterior,
                'costoVentaEsteMes' => $costoVentaEsteMes,
                'productosMinimos' => $productosMinimos,
                'clientesMasCompradores' => $clientesMasCompradores,
                'anyChart' => true,
                'css' => ['dashboard'],
                'js' => ['dashboard'],
                'cantVentasAyer' => count($ventasAyer)
            ];

            echo view('header', $dataHeader);
            echo view('dashboard/dashboard');
            echo view('footer');
        }

        public function imprTableMinStock()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }

            $productosMinimos = array();

            $productosAll = $this -> productos -> where('producto_state', 1) -> findAll();

            foreach ($productosAll as $key => $value) 
            {
                if ($value['producto_stock'] <= $value['producto_stockminimo']) {
                    array_push($productosMinimos, $value);
                }
            }

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Dashboard',
                'productosMinimos' => $productosMinimos,
                'anyChart' => true,
                'css' => ['dashboard'],
                'js' => ['dashboard']
            ];

            echo view('headerImpr', $dataHeader);
            echo view('dashboard/minstock');
            echo view('footerImpr');
        }

        public function imprTableClientesRec()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }

            $clientesMasCompradores = $this -> ventas -> select('*, count(venta_id) AS cantidad_ventas, SUM(venta_total) AS total_ventas',) -> join('cliente', 'cliente.cliente_id = venta.cliente_id') -> where('venta_state', 1) -> groupBy('cliente.cliente_id') -> orderBy('count(venta_id)', 'DESC') -> orderBy('SUM(venta_total)', 'DESC') -> findAll();

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Dashboard',
                'clientesMasCompradores' => $clientesMasCompradores,
                'anyChart' => true,
                'css' => ['dashboard'],
                'js' => ['dashboard']
            ];

            echo view('headerImpr', $dataHeader);
            echo view('dashboard/clientesrec');
            echo view('footerImpr');
        }
    }