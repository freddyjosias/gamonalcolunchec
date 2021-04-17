<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\UsuariosModel;
    use App\Models\CajasModel;
    use App\Models\RolesModel;
    use App\Models\ConfiguracionModel;

    class Usuarios extends BaseController
    {
        protected $usuarios;
        protected $cajas;
        protected $roles;
        protected $reglas, $reglasLogin, $reglasCambian;
        protected $isLogin = true;

        public function __construct()
        {
            $session = session();
            
            if (is_null($session -> id_usuario)) 
            {
                $this -> isLogin = false;
            }

            $this -> usuarios = new UsuariosModel();
            $this -> cajas = new CajasModel();
            $this -> roles = new RolesModel();
            helper(['form']);

            $this -> reglas = [
                'usuario' => [
                    'rules' => 'required|is_unique[usuario.usuario_user]',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.',
                        'is_unique' => 'El campo {field} debe ser unico.'
                    ]
                ],
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
                ],
                'nombre' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.'
                    ]
                ],
                'id_caja' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.'
                    ]
                ],
                'id_rol' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.'
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

        public function index($state = 1)
        {
            $usuarios = $this -> usuarios -> where('usuario_state', $state) -> findAll();
            $data = ['title' => 'Usuarios', 'datos' => $usuarios];

            echo view('header');
            echo view('usuarios/usuarios', $data);
            echo view('footer');
        }

        public function nuevo()
        {
            $cajas = $this -> cajas -> where('caja_state', 1) -> findAll();
            $roles = $this -> roles -> where('rol_state', 1) -> findAll();

            $data = ['title' => 'Agregar Usuario', 'cajas' => $cajas, 'roles' => $roles];

            echo view('header');
            echo view('usuarios/nuevo', $data);
            echo view('footer');
        }

        public function insertar()
        {
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
                return redirect() -> to(base_url() . '/usuarios');
            }
            else
            {
                $cajas = $this -> cajas -> where('caja_state', 1) -> findAll();
                $roles = $this -> roles -> where('rol_state', 1) -> findAll();

                $data = ['title' => 'Agregar Usuario', 'validation' => $this -> validator, 'cajas' => $cajas, 'roles' => $roles];

                echo view('header');
                echo view('usuarios/nuevo', $data);
                echo view('footer');
            }

            
        }

        public function editar($id, $valid = null)
        {
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
            $this -> usuarios -> update($id, ['usuario_state' => 0]);

            return redirect() -> to(base_url() . '/usuarios');
        }

        public function eliminados($state = 0)
        {
            $usuarios = $this -> usuarios -> where('usuario_state', $state) -> findAll();
            $data = ['title' => 'Usuarios Eliminados', 'datos' => $usuarios];

            echo view('header');
            echo view('usuarios/eliminados', $data);
            echo view('footer');
        }

        public function reingresar($id)
        {
            $this -> usuarios -> update($id, ['usuario_state' => 1]);

            return redirect() -> to(base_url() . '/usuarios');
        }

        public function login()
        {
            if ($this -> isLogin) 
            {
                return redirect() -> to(base_url() . '/configuracion');
            }

            $configModel = new ConfiguracionModel();
            $datosTienda = $configModel -> getDatosTienda();

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
                        return redirect() -> to(base_url() . '/configuracion');
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
                $data = ['validation' => $this -> validator];
                echo view('login', $data);
            }
        }

        public function logout()
        {
            $session = session();
            $session -> destroy();
            return redirect() -> to(base_url());
        }

        public function cambiarpassword()
        {
            $session = session();

            $usuario = $this -> usuarios -> where('usuario_id', $session -> id_usuario) -> first();

            $data = ['title' => 'Cambiar contraseña', 'usuario' => $usuario];

            echo view('header');
            echo view('usuarios/cambiarpassword', $data);
            echo view('footer');
        }

        public function actualizarpassword()
        {
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