<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\DetallePermisosModel;
    use App\Models\ConfiguracionModel;

    class Configuracion extends BaseController
    {
        protected $reglas;
        protected $configModel, $datosTienda;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;

        public function __construct()
        {
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

            helper(['form', 'upload']);

            $this -> reglas = [
                'tienda_nombre' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.'
                    ]
                ], 
                'tienda_rfc' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.'
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
                if (!isset($this -> permisosUser[3])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $dataHeader = $this -> configModel -> getDatosTienda();

            $dataHeader['permisos'] = $this -> permisosUser;
            $dataHeader['title'] = 'Configuración';
            $dataHeader['css'] = [
                'configuracion'
            ];

            echo view('header', $dataHeader);
            echo view('configuracion/configuracion');
            echo view('footer');
        }

        public function editar($id, $valid = null)
        {
            $unidad = $this -> configuracion -> where('unidad_id', $id) -> first();

            if ($valid != null) 
            {
                $data = [
                    'title' => 'Editar Unidad', 
                    'datos' => $unidad, 
                    'validation' => $valid
                ];
            }
            else
            {
                $data = [
                    'title' => 'Editar Unidad', 
                    'datos' => $unidad
                ];
            }
            
            echo view('header');
            echo view('configuracion/editar', $data);
            echo view('footer');
        }

        public function actualizar()
        {
            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {    
                $this -> configuracion -> whereIn('configuracion_nombre', ['nombre_tienda']) -> set(['configuracion_valor' => $this -> request -> getPost('tienda_nombre')]) -> update();

                $this -> configuracion -> whereIn('configuracion_nombre', ['tienda_rfc']) -> set(['configuracion_valor' => $this -> request -> getPost('tienda_rfc')]) -> update();

                $this -> configuracion -> whereIn('configuracion_nombre', ['tienda_telefono']) -> set(['configuracion_valor' => $this -> request -> getPost('tienda_telefono')]) -> update();

                $this -> configuracion -> whereIn('configuracion_nombre', ['tienda_email']) -> set(['configuracion_valor' => $this -> request -> getPost('tienda_correo')]) -> update();

                $this -> configuracion -> whereIn('configuracion_nombre', ['tienda_direccion']) -> set(['configuracion_valor' => $this -> request -> getPost('tienda_direccion')]) -> update();

                $this -> configuracion -> whereIn('configuracion_nombre', ['ticket_leyenda']) -> set(['configuracion_valor' => $this -> request -> getPost('leyenda_ticket')]) -> update();

                $validacion = $this -> validate([
                    'tienda_logo' => [
                        'uploaded[tienda_logo]'
                    ]
                ]);

                if ($validacion) 
                {
                    $imgLogo = $this -> request -> getFile('tienda_logo');
                    $imgLogo -> move('./img', 'logotienda.' . $imgLogo -> getExtension());
                }
                else
                {
                    echo 'ERROR en la validación';
                    die;
                }

                return redirect() -> to(base_url() . '/configuracion');
            }
            else
            {
                return $this -> editar($this -> request -> getPost('id'), $this -> validator);
            }
            
        }
    }