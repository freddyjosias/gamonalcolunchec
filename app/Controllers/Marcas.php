<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\MarcasModel;
    use App\Models\DetallePermisosModel;

    class Marcas extends BaseController
    {
        protected $marcas;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;

        public function __construct()
        {
            $this -> marcas = new MarcasModel();
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
                if (!isset($this -> permisosUser[12])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
            $marcas = $this -> marcas -> where('marca_state', $state) -> findAll();
            $data = ['title' => 'Marcas', 'datos' => $marcas];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('marcas/marcas', $data);
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
                if (!isset($this -> permisosUser[12])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $data = ['title' => 'Agregar Marca'];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('marcas/nuevo', $data);
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
                if (!isset($this -> permisosUser[12])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
            $this -> marcas -> save(['marca_nombre' => $this -> request -> getPost('nombre')]);

            return redirect() -> to(base_url() . '/marcas');
        }

        public function editar($id)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[12])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $marca = $this -> marcas -> where('marca_id', $id) -> first();
            $data = ['title' => 'Editar Marca', 'datos' => $marca];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('marcas/editar', $data);
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
                if (!isset($this -> permisosUser[12])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
            $this -> marcas -> update(
                $this -> request -> getPost('id'), 
                [
                    'marca_nombre' => $this -> request -> getPost('nombre')
                ]
            );

            return redirect() -> to(base_url() . '/marcas');
        }

        public function eliminar($id)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[12])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $this -> marcas -> update($id, ['marca_state' => 0]);

            return redirect() -> to(base_url() . '/marcas');
        }

        public function eliminados($state = 0)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[12])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $marcas = $this -> marcas -> where('marca_state', $state) -> findAll();
            $data = ['title' => 'Marcas Eliminadas', 'datos' => $marcas];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('marcas/eliminados', $data);
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
                if (!isset($this -> permisosUser[12])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
            $this -> marcas -> update($id, ['marca_state' => 1]);

            return redirect() -> to(base_url() . '/marcas');
        }
    }