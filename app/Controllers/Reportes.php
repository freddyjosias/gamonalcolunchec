<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\CajasModel;
    use App\Models\DetallePermisosModel;
    use App\Models\ComprasModel;
    use App\Models\VentasModel;
    use App\Models\ConfiguracionModel;
    use CodeIgniter\I18n\Time;

    class Reportes extends BaseController
    {
        protected $cajas;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;
        protected $configModel, $datosTienda;

        public function __construct()
        {
            $this -> compras = new ComprasModel();
            $this -> cajas = new CajasModel();
            $this -> detPermisos = new DetallePermisosModel();
            $this -> ventas = new VentasModel();
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

        public function getJsonComprasVentas()
        {
            if (!$this -> isLogin) 
            {
                return false;
            }
            else
            {
                if (!isset($this -> permisosUser[14])) 
                {
                    $data = array(array('No Data', 0, 0));

                    return json_encode($data);
                }
            }

            $data = array();

            $now = new Time('now');

            $monthDate = $now -> getMonth() + 1;
            $yearDate = $now -> getYear() - 1;

            if ($monthDate == 13) {
                $monthDate = 1;
                $yearDate++;
            }

            $time = Time::createFromFormat('Y-m-d', $yearDate . '-' . $monthDate . '-1', 'America/Lima');
            
            //$ventasEsteMes = array();
            //$costoVentaEsteMes = 0;
            
            while ($now > $time) 
            {
                $auxTime = $time;
                $auxTime = $auxTime -> addMonths(1);
                $auxTime = $auxTime -> subDays(1);

                $ventasByMes = $this -> ventas -> where('venta_creation >=', $time -> toDateString()) -> where('venta_creation <=', $auxTime -> toDateString()) -> where('venta_state', 1) -> findAll();

                $comprasByMes = $this -> compras -> where('compra_creation >=', $time -> toDateString()) -> where('compra_creation <=', $auxTime -> toDateString()) -> where('compra_ustate', 1) -> findAll();

                $arrayData = array($this -> getMesByNumber($time -> getMonth()), count($ventasByMes), count($comprasByMes));

                array_push($data, $arrayData);
                //array_push($data, $auxTime -> toDateString());

                /*$ventasAux = $this -> ventas -> like('venta_creation', $time -> toDateString()) -> where('venta_state', 1) -> findAll();
                
                foreach ($ventasAux as $key => $value) 
                { 
                    $costoVentaEsteMes = $costoVentaEsteMes + $value['venta_total'];
                    array_push($ventasEsteMes, $value);
                }
                */
                $time = $time -> addMonths(1);
                
            }

            return json_encode($data); die;

            return json_encode($data);
        }

        public function getJsonComprasVentasPrecio()
        {
            if (!$this -> isLogin) 
            {
                return false;
            }
            else
            {
                if (!isset($this -> permisosUser[14])) 
                {
                    $data = array(array('No Data', 0, 0));

                    return json_encode($data);
                }
            }

            $data = array();

            $now = new Time('now');

            $monthDate = $now -> getMonth() + 1;
            $yearDate = $now -> getYear() - 1;

            if ($monthDate == 13) {
                $monthDate = 1;
                $yearDate++;
            }

            $time = Time::createFromFormat('Y-m-d', $yearDate . '-' . $monthDate . '-1', 'America/Lima');
            
            while ($now > $time) 
            {
                $auxTime = $time;
                $auxTime = $auxTime -> addMonths(1);
                $auxTime = $auxTime -> subDays(1);

                $ventasByMes = $this -> ventas -> select('SUM(venta_total) AS cant_ventas_sol') -> where('venta_creation >=', $time -> toDateString()) -> where('venta_creation <=', $auxTime -> toDateString()) -> where('venta_state', 1) -> first();

                $comprasByMes = $this -> compras -> select('SUM(compra_total) AS cant_compra_sol') -> where('compra_creation >=', $time -> toDateString()) -> where('compra_creation <=', $auxTime -> toDateString()) -> where('compra_ustate', 1) -> first();

                if ($comprasByMes["cant_compra_sol"] == null) {
                    $comprasByMes["cant_compra_sol"] = 0;
                }

                $arrayData = array($this -> getMesByNumber($time -> getMonth()), $ventasByMes["cant_ventas_sol"], $comprasByMes["cant_compra_sol"]);

                array_push($data, $arrayData);
                
                $time = $time -> addMonths(1);
                
            }

            return json_encode($data);
        }

        protected function getMesByNumber($number)
        {
            switch ($number) {
                case 1:
                    return 'Ene';
                    break;
                    
                case 2:
                    return 'Feb';
                    break;

                case 3:
                    return 'Mar';
                    break;

                case 4:
                    return 'Abr';
                    break;

                case 5:
                    return 'May';
                    break;

                case 6:
                    return 'Jun';
                    break;

                case 7:
                    return 'Jul';
                    break;

                case 8:
                    return 'Ago';
                    break;

                case 9:
                    return 'Sep';
                    break;

                case 10:
                    return 'Oct';
                    break;

                case 11:
                    return 'Nov';
                    break;

                case 12:
                    return 'Dic';
                    break;
                
                default:
                    return 'Otros';
                    break;
            }
        }
    }