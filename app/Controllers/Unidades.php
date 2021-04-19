<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\UnidadesModel;
    use App\Models\DetallePermisosModel;
    use App\Models\ConfiguracionModel;

    class Unidades extends BaseController
    {
        protected $unidades;
        protected $reglas;
        protected $configModel, $datosTienda;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;

        public function __construct()
        {
            $this -> unidades = new UnidadesModel();
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

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Unidades', 
                'datos' => $unidades
            ];

            echo view('header', $dataHeader);
            echo view('unidades/unidades');
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

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Agregar Unidad'
            ];

            echo view('header', $dataHeader);
            echo view('unidades/nuevo');
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
                $dataHeader = [
                    'permisos' => $this -> permisosUser,
                    'nombreTienda' => $this -> datosTienda['nombreTienda'],
                    'title' => 'Agregar Unidad', 
                    'validation' => $this -> validator
                ];

                echo view('header', $dataHeader);
                echo view('unidades/nuevo');
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

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'datos' => $unidad, 
                'title' => 'Dashboard'
            ];

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $dataHeader['validation'] = $valid;
            }

            echo view('header', $dataHeader);
            echo view('unidades/editar');
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

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Unidades Eliminadas', 
                'datos' => $unidades
            ];

            echo view('header', $dataHeader);
            echo view('unidades/eliminados');
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