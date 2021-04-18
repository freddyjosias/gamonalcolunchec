<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\CajasModel;
    use App\Models\DetallePermisosModel;

    class Cajas extends BaseController
    {
        protected $cajas;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;

        public function __construct()
        {
            $this -> cajas = new CajasModel();
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
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $cajas = $this -> cajas -> where('caja_state', $state) -> findAll();
            $data = ['title' => 'Cajas', 'datos' => $cajas];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('cajas/cajas', $data);
            echo view('footer');
        }

        public function nuevo()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $data = ['title' => 'Agregar Caja'];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('cajas/nuevo', $data);
            echo view('footer');
        }

        public function insertar()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $this -> cajas -> save(['caja_nombre' => $this -> request -> getPost('nombre')]);

            return redirect() -> to(base_url() . '/cajas');
        }

        public function editar($id)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $caja = $this -> cajas -> where('caja_id', $id) -> first();
            $data = ['title' => 'Editar Caja', 'datos' => $caja];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('cajas/editar', $data);
            echo view('footer');
        }

        public function actualizar()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $this -> cajas -> update(
                $this -> request -> getPost('id'), 
                [
                    'caja_nombre' => $this -> request -> getPost('nombre')
                ]
            );

            return redirect() -> to(base_url() . '/cajas');
        }

        public function eliminar($id)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $this -> cajas -> update($id, ['caja_state' => 0]);

            return redirect() -> to(base_url() . '/cajas');
        }

        public function eliminados($state = 0)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $cajas = $this -> cajas -> where('caja_state', $state) -> findAll();
            $data = ['title' => 'Cajas Eliminadas', 'datos' => $cajas];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('cajas/eliminados', $data);
            echo view('footer');
        }

        public function reingresar($id)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $this -> cajas -> update($id, ['caja_state' => 1]);

            return redirect() -> to(base_url() . '/cajas');
        }
    }