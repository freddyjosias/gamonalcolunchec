<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\DetallePermisosModel;

    class Dashboard extends BaseController
    {
        protected $isLogin = true, $detPermisos, $session, $permisosUser;

        public function __construct()
        {
            $this -> detPermisos = new DetallePermisosModel();

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
            $dataHeader = ['permisos' => $this -> permisosUser];

            echo view('header', $dataHeader);
            //echo view('marcas/marcas', $data);
            echo view('footer');
        }
    }