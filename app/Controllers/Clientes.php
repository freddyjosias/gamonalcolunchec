<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ClientesModel;
    use App\Models\DetallePermisosModel;
    use App\Models\ConfiguracionModel;

    class Clientes extends BaseController
    {
        protected $clientes;
        protected $reglas, $reglasDni;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;
        protected $configModel, $datosTienda;

        public function __construct()
        {
            $this -> clientes = new ClientesModel();
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
                        'required' => 'El campo Nombres es obligatorio.'
                    ]
                ]
            ];

            $this -> reglasDni = [
                'nombre' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Nombres es obligatorio.'
                    ]
                ],
                'documento' => [
                    'rules' => 'required|in_list[DNI,RUC]',
                    'errors' => [
                        'required' => 'El campo Tipo de Documento es obligatorio cuando se ingresa un valor en el campo DNI/RUC.',
                        'in_list' => 'El campo Tipo de Documento solo puede tener valor DNI o RUC cuando se ingresa un valor en el campo DNI/RUC.'
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
                if (!isset($this -> permisosUser[9])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $clientes = $this -> clientes -> where('cliente_state', 1) -> findAll();

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Clientes', 
                'datos' => $clientes
            ];

            echo view('header', $dataHeader);
            echo view('clientes/clientes');
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
                if (!isset($this -> permisosUser[9])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Agregar Cliente'
            ];

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $dataHeader['validation'] = $valid;
            }

            echo view('header', $dataHeader);
            echo view('clientes/nuevo');
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
                if (!isset($this -> permisosUser[9])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $documento = '';
            $dni = $this -> request -> getPost('dni');
            
            if ($dni != '') 
            {
                $documento = $this -> request -> getPost('documento');
                $validate = $this -> validate($this -> reglasDni);
            }

            if (!isset($validate)) 
            {
                $validate = $this -> validate($this -> reglas);
            }

            if ($this -> request -> getMethod() == 'post' && $validate) 
            {
                $this -> clientes -> save([
                    'cliente_nombre' => $this -> request -> getPost('nombre'), 
                    'cliente_apellido' => $this -> request -> getPost('apellido'), 
                    'cliente_direccion' => $this -> request -> getPost('direccion'), 
                    'cliente_dni' => $dni, 
                    'cliente_telefono' => $this -> request -> getPost('telefono'), 
                    'cliente_correo' => $this -> request -> getPost('correo'),
                    'cliente_documento' => $documento
                ]);
                return redirect() -> to(base_url() . '/clientes');
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
                if (!isset($this -> permisosUser[9])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $cliente = $this -> clientes -> where('cliente_id', $id) -> where('cliente_state', 1) -> first();

            if (is_null($cliente)) 
            {
                return redirect() -> to(base_url() . '/clientes');
            }

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Editar Cliente', 
                'cliente' => $cliente
            ];

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $dataHeader['validation'] = $valid;
            }

            echo view('header', $dataHeader);
            echo view('clientes/editar');
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
                if (!isset($this -> permisosUser[9])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $id = $this -> request -> getPost('id');

            if (is_null($id)) 
            {
                return redirect() -> to(base_url() . '/clientes');
            }

            $cliente = $this -> clientes -> where('cliente_id', $id) -> where('cliente_state', 1) -> first();

            if (is_null($cliente)) 
            {
                return redirect() -> to(base_url() . '/clientes');
            }

            $documento = '';
            $dni = $this -> request -> getPost('dni');
            
            if ($dni != '') 
            {
                $documento = $this -> request -> getPost('documento');
                $validate = $this -> validate($this -> reglasDni);
            }

            if (!isset($validate)) 
            {
                $validate = $this -> validate($this -> reglas);
            }

            if ($this -> request -> getMethod() == 'post' && $validate) 
            {
                $this -> clientes -> update(
                    $this -> request -> getPost('id'), 
                    [
                        'cliente_nombre' => $this -> request -> getPost('nombre'), 
                        'cliente_apellido' => $this -> request -> getPost('apellido'), 
                        'cliente_direccion' => $this -> request -> getPost('direccion'), 
                        'cliente_dni' => $dni, 
                        'cliente_telefono' => $this -> request -> getPost('telefono'), 
                        'cliente_correo' => $this -> request -> getPost('correo'),
                        'cliente_documento' => $documento
                    ]
                );

                return redirect() -> to(base_url() . '/clientes');
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
                if (!isset($this -> permisosUser[9])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $cliente = $this -> clientes -> where('cliente_id', $id) -> where('cliente_state', 1) -> first();

            if (is_null($cliente)) 
            {
                return redirect() -> to(base_url() . '/clientes');
            }

            $this -> clientes -> update($id, ['cliente_state' => 0]);

            return redirect() -> to(base_url() . '/clientes');
        }

        public function eliminados()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[9])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $clientes = $this -> clientes -> where('cliente_state', 0) -> findAll();

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Clientes Eliminadas', 
                'datos' => $clientes
            ];

            echo view('header', $dataHeader);
            echo view('clientes/eliminados');
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
                if (!isset($this -> permisosUser[9])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $cliente = $this -> clientes -> where('cliente_id', $id) -> where('cliente_state', 0) -> first();

            if (is_null($cliente)) 
            {
                return redirect() -> to(base_url() . '/clientes');
            }
            
            $this -> clientes -> update($id, ['cliente_state' => 1]);

            return redirect() -> to(base_url() . '/clientes');
        }

        public function autocompleteData()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[9])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $returnData = array();

            $valor = $this->request->getGet('term');
            
            $clientes = $this->clientes->like('cliente_nombre', $valor)->where('cliente_state', 1)->findAll();

            if (!empty($clientes)) 
            {
                foreach ($clientes as $key => $value) 
                {
                    $data['id'] = $value['cliente_id'];
                    $data['value'] = $value['cliente_nombre'];
                    array_push($returnData, $data);
                }
            }

            echo json_encode($returnData);
        }
    }