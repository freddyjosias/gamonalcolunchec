<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ConfiguracionModel;
    use App\Models\DetallePermisosModel;

    class Dashboard extends BaseController
    {
        protected $isLogin = true, $detPermisos, $session, $permisosUser;
        protected $configModel, $datosTienda;

        public function __construct()
        {
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
        }

        public function index($state = 1)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            
            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Dashboard'
            ];

            echo view('header', $dataHeader);
            //echo view('marcas/marcas', $data);
            echo view('footer');
        }
    }