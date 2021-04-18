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

            helper(['form']);

            $this -> reglas = [
                'nombre' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Nombre es obligatorio.'
                    ]
                ]
            ];
        }

        public function index()
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
            
            $marcas = $this -> marcas -> where('marca_state', 1) -> findAll();
            $data = ['title' => 'Marcas', 'datos' => $marcas];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('marcas/marcas', $data);
            echo view('footer');
        }

        public function nuevo($valid = null)
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

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $data = ['title' => 'Agregar Marca', 'validation' => $valid];
            }
            else
            {
                $data = ['title' => 'Agregar Marca'];
            }

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

            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {
                $this -> marcas -> save(['marca_nombre' => $this -> request -> getPost('nombre')]);

                return redirect() -> to(base_url() . '/marcas');
            }
            else
            {
                return $this -> nuevo($this -> validator);
            }
        }

        public function editar($id = 0, $valid = null)
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

            $marca = $this -> marcas -> where('marca_id', $id) -> where('marca_state', 1) -> first();

            if (is_null($marca)) 
            {
                return redirect() -> to(base_url() . '/marcas');
            }

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $data = ['title' => 'Editar Marca', 'datos' => $marca, 'validation' => $valid];
            }
            else
            {
                $data = ['title' => 'Editar Marca', 'datos' => $marca];
            }

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

            $id = $this -> request -> getPost('id');

            if (is_null($id)) 
            {
                return redirect() -> to(base_url() . '/marcas');
            }

            $marca = $this -> marcas -> where('marca_id', $id) -> where('marca_state', 1) -> first();

            if (is_null($marca)) 
            {
                return redirect() -> to(base_url() . '/marcas');
            }

            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {
                $this -> marcas -> update(
                    $this -> request -> getPost('id'), 
                    [
                        'marca_nombre' => $this -> request -> getPost('nombre')
                    ]
                );

                return redirect() -> to(base_url() . '/marcas');
            }
            else
            {
                return $this -> editar($id, $this -> validator);
            }
        }

        public function eliminar($id = 0)
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

            $marca = $this -> marcas -> where('marca_id', $id) -> where('marca_state', 1) -> first();

            if (is_null($marca)) 
            {
                return redirect() -> to(base_url() . '/marcas');
            }
            
            $this -> marcas -> update($id, ['marca_state' => 0]);

            return redirect() -> to(base_url() . '/marcas');
        }

        public function eliminados()
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

            $marcas = $this -> marcas -> where('marca_state', 0) -> findAll();
            $data = ['title' => 'Marcas Eliminadas', 'datos' => $marcas];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('marcas/eliminados', $data);
            echo view('footer');
        }

        public function reingresar($id = 0)
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

            $marca = $this -> marcas -> where('marca_id', $id) -> where('marca_state', 0) -> first();

            if (is_null($marca)) 
            {
                return redirect() -> to(base_url() . '/marcas');
            }
            
            $this -> marcas -> update($id, ['marca_state' => 1]);

            return redirect() -> to(base_url() . '/marcas');
        }
    }