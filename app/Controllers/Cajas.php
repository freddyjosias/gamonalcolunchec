<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\CajasModel;
    use App\Models\DetallePermisosModel;
    use App\Models\ConfiguracionModel;

    class Cajas extends BaseController
    {
        protected $cajas;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;
        protected $configModel, $datosTienda;

        public function __construct()
        {
            $this -> cajas = new CajasModel();
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
        }

        public function index()
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

            $cajas = $this -> cajas -> where('caja_state', 1) -> whereNotIn('caja_id', array(0)) -> findAll();

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Cajas', 
                'datos' => $cajas
            ];

            echo view('header', $dataHeader);
            echo view('cajas/cajas');
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
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Agregar Caja'
            ];

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $dataHeader['validation'] = $valid;
            }

            echo view('header', $dataHeader);
            echo view('cajas/nuevo');
            echo view('footer');
        }

        public function insertar()
        {
            $reglas = [
                'nombre' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Nombre es obligatorio.'
                    ]
                ],
                'numero' => [
                    'rules' => 'required|is_unique[caja.caja_numero]',
                    'errors' => [
                        'required' => 'El campo Número es obligatorio.',
                        'is_unique' => 'El campo Número debe ser unico.'
                    ]
                ]
            ];

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

            if ($this -> request -> getMethod() == 'post' && $this -> validate($reglas)) 
            {
                $this -> cajas -> save([
                    'caja_nombre' => $this -> request -> getPost('nombre'),
                    'caja_numero' => $this -> request -> getPost('numero')
                ]);

                return redirect() -> to(base_url() . '/cajas');
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
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $caja = $this -> cajas -> where('caja_id', $id) -> where('caja_state', 1) -> whereNotIn('caja_id', array(0)) -> first();

            if (is_null($caja)) 
            {
                return redirect() -> to(base_url() . '/cajas');
            }

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Editar Caja', 
                'datos' => $caja
            ];

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $dataHeader['validation'] = $valid;
            }

            echo view('header', $dataHeader);
            echo view('cajas/editar');
            echo view('footer');
        }

        public function actualizar()
        {
            $reglas = [
                'nombre' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Nombre es obligatorio.'
                    ]
                ],
                'numero' => [
                    'rules' => 'required|is_unique[caja.caja_numero,caja.caja_id,{id}]',
                    'errors' => [
                        'required' => 'El campo Número es obligatorio.',
                        'is_unique' => 'El campo Número debe ser unico.'
                    ]
                ]
            ];

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
            
            $id = $this -> request -> getPost('id');

            if (is_null($id)) 
            {
                return redirect() -> to(base_url() . '/cajas');
            }

            $caja = $this -> cajas -> where('caja_id', $id) -> where('caja_state', 1) -> whereNotIn('caja_id', array(0)) -> first();

            if (is_null($caja)) 
            {
                return redirect() -> to(base_url() . '/cajas');
            }
        
            if ($this -> request -> getMethod() == 'post' && $this -> validate($reglas)) 
            {
                $this -> cajas -> update(
                    $this -> request -> getPost('id'), 
                    [
                        'caja_nombre' => $this -> request -> getPost('nombre'),
                        'caja_numero' => $this -> request -> getPost('numero')
                    ]
                );

                return redirect() -> to(base_url() . '/cajas');
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
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $caja = $this -> cajas -> where('caja_id', $id) -> where('caja_state', 1) -> whereNotIn('caja_id', array(0)) -> first();

            if (is_null($caja)) 
            {
                return redirect() -> to(base_url() . '/cajas');
            }
            
            $this -> cajas -> update($id, ['caja_state' => 0]);

            return redirect() -> to(base_url() . '/cajas');
        }

        public function eliminados()
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

            $cajas = $this -> cajas -> where('caja_state', 0) -> whereNotIn('caja_id', array(0)) -> findAll();

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Cajas Eliminadas', 
                'datos' => $cajas
            ];

            echo view('header', $dataHeader);
            echo view('cajas/eliminados');
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
                if (!isset($this -> permisosUser[4])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $caja = $this -> cajas -> where('caja_id', $id) -> where('caja_state', 0) -> whereNotIn('caja_id', array(0)) -> first();

            if (is_null($caja)) 
            {
                return redirect() -> to(base_url() . '/cajas');
            }
            
            $this -> cajas -> update($id, ['caja_state' => 1]);

            return redirect() -> to(base_url() . '/cajas');
        }
    }