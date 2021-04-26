<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\RolesModel;
    use App\Models\DetallePermisosModel;
    use App\Models\ConfiguracionModel;

    class Roles extends BaseController
    {
        protected $roles;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;
        protected $configModel, $datosTienda;

        public function __construct()
        {
            $this -> roles = new RolesModel();
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
                if (!isset($this -> permisosUser[13])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
            $roles = $this -> roles -> where('rol_state', 1) -> findAll();

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Roles', 
                'datos' => $roles
            ];

            echo view('header', $dataHeader);
            echo view('roles/roles');
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
                if (!isset($this -> permisosUser[13])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Agregar Rol'
            ];

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $dataHeader['validation'] = $valid;
            }

            echo view('header', $dataHeader);
            echo view('roles/nuevo');
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
                if (!isset($this -> permisosUser[13])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {
                $this -> roles -> save(['rol_nombre' => $this -> request -> getPost('nombre')]);

                return redirect() -> to(base_url() . '/roles');
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
                if (!isset($this -> permisosUser[13])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $rol = $this -> roles -> where('rol_id', $id) -> where('rol_state', 1) -> first();

            if (is_null($rol)) 
            {
                return redirect() -> to(base_url() . '/roles');
            }

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Editar Rol', 
                'datos' => $rol
            ];

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $dataHeader['validation'] = $valid;
            }

            echo view('header', $dataHeader);
            echo view('roles/editar');
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
                if (!isset($this -> permisosUser[13])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $id = $this -> request -> getPost('id');

            if (is_null($id)) 
            {
                return redirect() -> to(base_url() . '/roles');
            }

            $rol = $this -> roles -> where('rol_id', $id) -> where('rol_state', 1) -> first();

            if (is_null($rol)) 
            {
                return redirect() -> to(base_url() . '/roles');
            }
            
            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {
                $this -> roles -> update(
                    $this -> request -> getPost('id'), 
                    [
                        'rol_nombre' => $this -> request -> getPost('nombre')
                    ]
                );

                return redirect() -> to(base_url() . '/roles');
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
                if (!isset($this -> permisosUser[13])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $rol = $this -> roles -> where('rol_id', $id) -> where('rol_state', 1) -> first();

            if (is_null($rol)) 
            {
                return redirect() -> to(base_url() . '/roles');
            }
            
            $this -> roles -> update($id, ['rol_state' => 0]);

            return redirect() -> to(base_url() . '/roles');
        }

        public function eliminados()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[13])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $roles = $this -> roles -> where('rol_state', 0) -> findAll();

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Roles Eliminadas', 
                'datos' => $roles
            ];

            echo view('header', $dataHeader);
            echo view('roles/eliminados');
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
                if (!isset($this -> permisosUser[13])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $rol = $this -> roles -> where('rol_id', $id) -> where('rol_state', 0) -> first();

            if (is_null($rol)) 
            {
                return redirect() -> to(base_url() . '/roles');
            }
            
            $this -> roles -> update($id, ['rol_state' => 1]);

            return redirect() -> to(base_url() . '/roles');
        }
    }