<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\UnidadesModel;
    use App\Models\DetallePermisosModel;

    class Unidades extends BaseController
    {
        protected $unidades;
        protected $reglas;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;

        public function __construct()
        {
            $this -> unidades = new UnidadesModel();
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
                ], 
                'nombre_corto' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Nombre Corto es obligatorio.'
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
                if (!isset($this -> permisosUser[10])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $unidades = $this -> unidades -> where('unidad_state', 1) -> findAll();
            $data = ['title' => 'Unidades', 'datos' => $unidades];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('unidades/unidades', $data);
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
                if (!isset($this -> permisosUser[10])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $data = ['title' => 'Agregar Unidad'];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('unidades/nuevo', $data);
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
                if (!isset($this -> permisosUser[10])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {
                $this -> unidades -> save([
                    'unidad_nombre' => $this -> request -> getPost('nombre'), 
                    'unidad_corto' => $this -> request -> getPost('nombre_corto')
                ]);
                return redirect() -> to(base_url() . '/unidades');
            }
            else
            {
                $data = ['title' => 'Agregar Unidad', 'validation' => $this -> validator];

                $dataHeader = ['permisos' => $this -> permisosUser];
            
                echo view('header', $dataHeader);
                echo view('unidades/nuevo', $data);
                echo view('footer');
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
                if (!isset($this -> permisosUser[10])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $unidad = $this -> unidades -> where('unidad_id', $id) -> where('unidad_state', 1) -> first();

            if (is_null($unidad)) 
            {
                return redirect() -> to(base_url() . '/unidades');
            }

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $data = ['title' => 'Editar Unidad', 'datos' => $unidad, 'validation' => $valid];
            }
            else
            {
                $data = ['title' => 'Editar Unidad', 'datos' => $unidad];
            }
            
            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('unidades/editar', $data);
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
                if (!isset($this -> permisosUser[10])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $id = $this -> request -> getPost('id');

            if (is_null($id)) 
            {
                return redirect() -> to(base_url() . '/unidades');
            }

            $unidad = $this -> unidades -> where('unidad_id', $id) -> where('unidad_state', 1) -> first();

            if (is_null($unidad)) 
            {
                return redirect() -> to(base_url() . '/unidades');
            }
            
            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {    
                $this -> unidades -> update(
                    $this -> request -> getPost('id'), 
                    [
                        'unidad_nombre' => $this -> request -> getPost('nombre'), 
                        'unidad_corto' => $this -> request -> getPost('nombre_corto')
                    ]
                );
                return redirect() -> to(base_url() . '/unidades');
            }
            else
            {
                return $this -> editar($this -> request -> getPost('id'), $this -> validator);
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
                if (!isset($this -> permisosUser[10])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $unidad = $this -> unidades -> where('unidad_id', $id) -> where('unidad_state', 1) -> first();

            if (is_null($unidad)) 
            {
                return redirect() -> to(base_url() . '/unidades');
            }
            
            $this -> unidades -> update($id, ['unidad_state' => 0]);

            return redirect() -> to(base_url() . '/unidades');
        }

        public function eliminados()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[10])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $unidades = $this -> unidades -> where('unidad_state', 0) -> findAll();
            $data = ['title' => 'Unidades Eliminadas', 'datos' => $unidades];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('unidades/eliminados', $data);
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
                if (!isset($this -> permisosUser[10])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $unidad = $this -> unidades -> where('unidad_id', $id) -> where('unidad_state', 0) -> first();

            if (is_null($unidad)) 
            {
                return redirect() -> to(base_url() . '/unidades');
            }
            
            $this -> unidades -> update($id, ['unidad_state' => 1]);

            return redirect() -> to(base_url() . '/unidades');
        }
    }