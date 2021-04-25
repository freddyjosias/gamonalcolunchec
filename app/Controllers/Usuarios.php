<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\UsuariosModel;
    use App\Models\CajasModel;
    use App\Models\RolesModel;
    use App\Models\ConfiguracionModel;
    use App\Models\DetallePermisosModel;
    use App\Models\PermisosModel;

    class Usuarios extends BaseController
    {
        protected $usuarios, $permisos;
        protected $cajas;
        protected $roles;
        protected $reglas, $reglasLogin, $reglasCambian;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;
        protected $configModel, $datosTienda;

        public function __construct()
        {
            $this -> usuarios = new UsuariosModel();
            $this -> cajas = new CajasModel();
            $this -> roles = new RolesModel();
            $this -> configModel = new ConfiguracionModel();
            $this -> detPermisos = new DetallePermisosModel();
            $this -> permisos = new PermisosModel();

            $this -> session = session();
            
            if (is_null($this -> session -> id_usuario)) 
            {
                $this -> isLogin = false;
            }
            else
            {
                $this -> permisosUser = $this -> detPermisos -> getPermisosPorUsuario($this -> session -> id_usuario);
            }
            
            $this -> datosTienda = $this -> configModel -> getDatosTienda();

            helper(['form']);

            $this -> reglas = [
                'usuario' => [
                    'rules' => 'required|is_unique[usuario.usuario_user]',
                    'errors' => [
                        'required' => 'El campo Usuario es obligatorio.',
                        'is_unique' => 'El campo Usuario debe ser unico.'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Contraseña es obligatorio.'
                    ]
                ],
                'repassword' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'El campo Confirmar Contraseña es obligatorio.',
                        'matches' => 'Las contraseñas no coinciden'
                    ]
                ],
                'nombre' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Nombre es obligatorio.'
                    ]
                ],
                'id_caja' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Caja es obligatorio.'
                    ]
                ],
                'id_rol' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Roles es obligatorio.'
                    ]
                ]
            ];

            $this -> reglasLogin = [
                'usuario' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.'
                    ]
                ]
            ];

            $this -> reglasCambian = [
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.'
                    ]
                ],
                'repassword' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.',
                        'matches' => 'Las contraseñas no coinciden'
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
                if (!isset($this -> permisosUser[1])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $usuarios = $this -> usuarios -> where('usuario_state', 1) -> findAll();

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Usuarios', 
                'datos' => $usuarios
            ];

            echo view('header', $dataHeader);
            echo view('usuarios/usuarios');
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
                if (!isset($this -> permisosUser[1])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $cajas = $this -> cajas -> where('caja_state', 1) -> findAll();
            $roles = $this -> roles -> where('rol_state', 1) -> findAll();
            $permisos = $this -> permisos -> orderBy('permiso_orden ASC') -> findAll();
            
            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Agregar Usuario', 
                'cajas' => $cajas, 
                'roles' => $roles,
                'css' => ['usuarios'],
                'permisos' => $permisos
            ];

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $dataHeader['validation'] = $valid;
            }

            echo view('header', $dataHeader);
            echo view('usuarios/nuevo');
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
                if (!isset($this -> permisosUser[1])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {
                $hash = password_hash($this -> request -> getPost('password'), PASSWORD_DEFAULT);
                
                $this -> usuarios -> save([
                    'usuario_user' => $this -> request -> getPost('usuario'), 
                    'usuario_nombre' => $this -> request -> getPost('nombre'), 
                    'usuario_password' => $hash,
                    'caja_id' => $this -> request -> getPost('id_caja'),
                    'rol_id' => $this -> request -> getPost('id_rol')
                ]);

                $lastIdUser = $this -> usuarios -> insertID();

                $permisos = $this -> permisos -> orderBy('permiso_orden ASC') -> findAll();
                
                foreach ($permisos as $key => $value) 
                {
                    $auxPermiso = $this -> request -> getPost('permiso_' . $value['permiso_id']);

                    if (!is_null($auxPermiso)) 
                    {
                        $this -> detPermisos -> save([
                            'permiso_id' => $value['permiso_id'], 
                            'usuario_id' => $lastIdUser
                        ]);
                    }
                }
                
                return redirect() -> to(base_url() . '/usuarios');
            }
            else
            {
                return $this -> nuevo($this -> validator);
            }

            
        }

        public function editar($id, $valid = null)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[1])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $usuario = $this -> usuarios -> where('usuario_id', $id) -> first();

            if ($valid != null) 
            {
                $data = ['title' => 'Editar Usuario', 'datos' => $usuario, 'validation' => $valid];
            }
            else
            {
                $data = ['title' => 'Editar Usuario', 'datos' => $usuario];
            }
            
            echo view('header');
            echo view('usuarios/editar', $data);
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
                if (!isset($this -> permisosUser[1])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {    
                $this -> usuarios -> update(
                    $this -> request -> getPost('id'), 
                    [
                        'usuario_nombre' => $this -> request -> getPost('nombre'), 
                        'usuario_corto' => $this -> request -> getPost('nombre_corto')
                    ]
                );
                return redirect() -> to(base_url() . '/usuarios');
            }
            else
            {
                return $this -> editar($this -> request -> getPost('id'), $this -> validator);
            }
            
        }

        public function eliminar($id)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[1])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $this -> usuarios -> update($id, ['usuario_state' => 0]);

            return redirect() -> to(base_url() . '/usuarios');
        }

        public function eliminados($state = 0)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[1])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $usuarios = $this -> usuarios -> where('usuario_state', $state) -> findAll();
            $data = ['title' => 'Usuarios Eliminados', 'datos' => $usuarios];

            echo view('header');
            echo view('usuarios/eliminados', $data);
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
                if (!isset($this -> permisosUser[1])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $this -> usuarios -> update($id, ['usuario_state' => 1]);

            return redirect() -> to(base_url() . '/usuarios');
        }

        public function login()
        {
            if ($this -> isLogin) 
            {
                return redirect() -> to(base_url() . '/productos');
            }

            $datosTienda = $this -> configModel -> getDatosTienda();

            $js = ['login'];
            $css = ['usuarios'];

            $data = [
                'nombreTienda' => $datosTienda['nombreTienda'], 
                'logoTienda' => $datosTienda['logoTienda'],
                'js' => $js,
                'css' => $css
            ];

            echo view('login', $data);
        }

        public function valida()
        {
            $datosTienda = $this -> configModel -> getDatosTienda();

            $js = ['login'];
            $css = ['usuarios'];

            $data = [
                'nombreTienda' => $datosTienda['nombreTienda'], 
                'logoTienda' => $datosTienda['logoTienda'],
                'js' => $js,
                'css' => $css
            ];

            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglasLogin)) 
            {    
                $usuario = $this -> request -> getPost('usuario');
                $password = $this -> request -> getPost('password');

                $datosUsuario = $this -> usuarios -> where('usuario_user', $usuario) -> first();

                if ($datosUsuario != null) 
                {
                    if (password_verify($password, $datosUsuario['usuario_password'])) 
                    {
                        $datosSesion = [
                            'id_usuario' => $datosUsuario['usuario_id'],
                            'nombre' => $datosUsuario['usuario_nombre'],
                            'id_caja' => $datosUsuario['caja_id'],
                            'id_rol' => $datosUsuario['rol_id']
                        ];

                        $session = session();
                        $session -> set($datosSesion);
                        return redirect() -> to(base_url() . '/productos');
                    }
                    else
                    {
                        $data['error'] = 'Contraseña Incorrecta';
                    }
                    echo view('login', $data);
                }
                else
                {
                    $data['error'] = 'El usuario no existe';
                    echo view('login', $data);
                }
            }
            else
            {
                $data['validation'] = $this -> validator;
                echo view('login', $data);
            }
        }

        public function logout()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }

            $session = session();
            $session -> destroy();
            return redirect() -> to(base_url());
        }

        public function cambiarpassword()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[1])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $session = session();

            $usuario = $this -> usuarios -> where('usuario_id', $session -> id_usuario) -> first();

            $data = ['title' => 'Cambiar contraseña', 'usuario' => $usuario];

            echo view('header');
            echo view('usuarios/cambiarpassword', $data);
            echo view('footer');
        }

        public function actualizarpassword()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[1])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $session = session();

            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglasCambian)) 
            {
                $hash = password_hash($this -> request -> getPost('password'), PASSWORD_DEFAULT);
                
                $idUsuario = $session -> id_usuario;

                $this -> usuarios -> update($idUsuario, ['usuario_password' => $hash]);

                $usuario = $this -> usuarios -> where('usuario_id', $session -> id_usuario) -> first();

                $data = ['title' => 'Cambiar contraseña', 'usuario' => $usuario, 'mensaje' => 'Contraseña actualizada'];

                echo view('header');
                echo view('usuarios/cambiarpassword', $data);
                echo view('footer');
            }
            else
            {
                $usuario = $this -> usuarios -> where('usuario_id', $session -> id_usuario) -> first();

                $data = ['title' => 'Cambiar contraseña', 'usuario' => $usuario, 'validation' => $this -> validator];

                echo view('header');
                echo view('usuarios/cambiarpassword', $data);
                echo view('footer');
            }
        }

    }