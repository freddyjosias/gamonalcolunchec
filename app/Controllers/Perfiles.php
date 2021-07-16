<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\RolesModel;
    use App\Models\DetallePermisosModel;
    use App\Models\ConfiguracionModel;
    use App\Models\PermisosModel;

    class Perfiles extends BaseController
    {
        protected $roles;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;
        protected $configModel, $datosTienda;

        public function __construct()
        {
            $this -> roles = new RolesModel();
            $this -> detPermisos = new DetallePermisosModel();
            $this -> configModel = new ConfiguracionModel();
            $this -> permisos = new PermisosModel();

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
                'title' => 'Perfiles', 
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

            $permisos = $this -> permisos -> orderBy('permiso_orden ASC') -> findAll();

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Agregar Perfil',
                'permisosEdit' => $permisos
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
                $this -> roles -> save([
                    'rol_nombre' => $this -> request -> getPost('nombre')
                ]);

                $lastIdPerfil = $this -> roles -> insertID();
                //var_dump($lastIdPerfil); die;
                $permisos = $this -> permisos -> orderBy('permiso_orden ASC') -> findAll();

                foreach ($permisos as $key => $value) 
                {
                    $auxPermiso = $this -> request -> getPost('permiso_' . $value['permiso_id']);
                    
                    if (!is_null($auxPermiso)) 
                    {
                        $this -> detPermisos -> save([
                            'permiso_id' => $value['permiso_id'], 
                            'rol_id' => $lastIdPerfil
                        ]);
                    }
                }

                return redirect() -> to(base_url() . '/perfiles');
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
                return redirect() -> to(base_url() . '/perfiles');
            }

            $permisos = $this -> permisos -> orderBy('permiso_orden ASC') -> findAll();
            $userEditPermisos = $this -> detPermisos -> getPermisoPorPerfil($id);

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Editar Perfil', 
                'datos' => $rol,
                'permisosEdit' => $permisos,
                'userEditPermisos' => $userEditPermisos
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
                return redirect() -> to(base_url() . '/perfiles');
            }

            $rol = $this -> roles -> where('rol_id', $id) -> where('rol_state', 1) -> first();

            if (is_null($rol)) 
            {
                return redirect() -> to(base_url() . '/perfiles');
            }
            
            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {
                $this -> roles -> update(
                    $this -> request -> getPost('id'), 
                    [
                        'rol_nombre' => $this -> request -> getPost('nombre')
                    ]
                );

                $userEditPermisos = $this -> detPermisos -> getPermisoPorPerfil($id);
                $permisos = $this -> permisos -> orderBy('permiso_orden ASC') -> findAll();
                
                foreach ($permisos as $key => $value) 
                {
                    $auxPermiso = $this -> request -> getPost('permiso_' . $value['permiso_id']);
                    
                    if (isset($userEditPermisos[$value['permiso_id']])) 
                    {
                        if ($userEditPermisos[$value['permiso_id']]['det_permiso_state'] == 0 && !is_null($auxPermiso))
                        {
                            $this -> detPermisos -> where('rol_id', $id) -> where('permiso_id', $value['permiso_id']) -> set(['det_permiso_state' => 1]) -> update();
                        }
                        else if($userEditPermisos[$value['permiso_id']]['det_permiso_state'] == 1 && is_null($auxPermiso))
                        {
                            $this -> detPermisos -> where('rol_id', $id) -> where('permiso_id', $value['permiso_id']) -> set(['det_permiso_state' => 0]) -> update();
                        }
                    }
                    else if (!is_null($auxPermiso)) 
                    {
                        $this -> detPermisos -> save([
                            'permiso_id' => $value['permiso_id'], 
                            'rol_id' => $id
                        ]);
                    }
                }

                return redirect() -> to(base_url() . '/perfiles');
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
                return redirect() -> to(base_url() . '/perfiles');
            }
            
            $this -> roles -> update($id, ['rol_state' => 0]);

            return redirect() -> to(base_url() . '/perfiles');
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
                'title' => 'Perfiles Eliminados', 
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
                return redirect() -> to(base_url() . '/perfiles');
            }
            
            $this -> roles -> update($id, ['rol_state' => 1]);

            return redirect() -> to(base_url() . '/perfiles');
        }
    }