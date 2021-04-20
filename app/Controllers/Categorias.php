<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\CategoriasModel;
    use App\Models\DetallePermisosModel;
    use App\Models\ConfiguracionModel;

    class Categorias extends BaseController
    {
        protected $categorias;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;
        protected $configModel, $datosTienda;

        public function __construct()
        {
            $this -> categorias = new CategoriasModel();
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
                if (!isset($this -> permisosUser[11])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $categorias = $this -> categorias -> where('categoria_state', 1) -> findAll();

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Categorías',
                'datos' => $categorias
            ];

            echo view('header', $dataHeader);
            echo view('categorias/categorias');
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
                if (!isset($this -> permisosUser[11])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Agregar Categoría'
            ];

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $dataHeader['validation'] = $valid;
            }

            echo view('header', $dataHeader);
            echo view('categorias/nuevo');
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
                if (!isset($this -> permisosUser[11])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {
                $this -> categorias -> save(['categoria_nombre' => $this -> request -> getPost('nombre')]);

                return redirect() -> to(base_url() . '/categorias');
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
                if (!isset($this -> permisosUser[11])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $categoria = $this -> categorias -> where('categoria_id', $id) -> where('categoria_state', 1) -> first();

            if (is_null($categoria)) 
            {
                return redirect() -> to(base_url() . '/categorias');
            }

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Editar Categoría', 
                'datos' => $categoria
            ];

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $dataHeader['validation'] = $valid;
            }

            echo view('header', $dataHeader);
            echo view('categorias/editar');
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
                if (!isset($this -> permisosUser[11])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $id = $this -> request -> getPost('id');

            if (is_null($id)) 
            {
                return redirect() -> to(base_url() . '/categorias');
            }

            $categoria = $this -> categorias -> where('categoria_id', $id) -> where('categoria_state', 1) -> first();

            if (is_null($categoria)) 
            {
                return redirect() -> to(base_url() . '/categorias');
            }

            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {
                $this -> categorias -> update(
                    $this -> request -> getPost('id'), 
                    [
                        'categoria_nombre' => $this -> request -> getPost('nombre')
                    ]
                );

                return redirect() -> to(base_url() . '/categorias');
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
                if (!isset($this -> permisosUser[11])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $categoria = $this -> categorias -> where('categoria_id', $id) -> where('categoria_state', 1) -> first();

            if (is_null($categoria)) 
            {
                return redirect() -> to(base_url() . '/categorias');
            }
            
            $this -> categorias -> update($id, ['categoria_state' => 0]);

            return redirect() -> to(base_url() . '/categorias');
        }

        public function eliminados()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[11])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $categorias = $this -> categorias -> where('categoria_state', 0) -> findAll();

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Categorías Eliminadas', 
                'datos' => $categorias
            ];

            echo view('header', $dataHeader);
            echo view('categorias/eliminados');
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
                if (!isset($this -> permisosUser[11])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $categoria = $this -> categorias -> where('categoria_id', $id) -> where('categoria_state', 0) -> first();

            if (is_null($categoria)) 
            {
                return redirect() -> to(base_url() . '/categorias');
            }
            
            $this -> categorias -> update($id, ['categoria_state' => 1]);

            return redirect() -> to(base_url() . '/categorias');
        }
    }