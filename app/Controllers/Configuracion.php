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
                        'required' => 'El campo Nombre de la tienda es obligatorio.'
                    ]
                ], 
                'tienda_rfc' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo RUC es obligatorio.'
                    ]
                ], 
                'tienda_telefono' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Teléfono de la Tienda es obligatorio.'
                    ]
                ], 
                'tienda_correo' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Correo de la Tienda es obligatorio.'
                    ]
                ], 
                'leyenda_ticket' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Leyenda del Ticket es obligatorio.'
                    ]
                ], 
                'tienda_direccion' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Dirección de la tienda es obligatorio.'
                    ]
                ]
            ];
        }

        public function index($valid = null)
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
            $dataHeader['js'] = [
                'configuracion'
            ];

            if ($valid != null && method_exists($valid,'listErrors')) 
            {
                $dataHeader['validation'] = $valid;
            }

            echo view('header', $dataHeader);
            echo view('configuracion/configuracion');
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
                if (!isset($this -> permisosUser[3])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
            $imgLogo = $this -> request -> getFile('tienda_logo');

            if ($imgLogo -> isValid()) 
            {
                $this -> reglas['tienda_logo'] = [
                    'rules' => 'uploaded[tienda_logo]|ext_in[tienda_logo,png,jpg,jpeg]',
                    'errors' => [
                        'uploaded' => 'Ocurrió un problema en la subida de la imagen.',
                        'ext_in' => 'La imagen solo puede tener extensión png, jpg o jpeg.'
                    ]
                ];
            }

            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            { 
                $this -> configModel -> whereIn('configuracion_nombre', ['nombre_tienda']) -> set(['configuracion_valor' => $this -> request -> getPost('tienda_nombre')]) -> update();

                $this -> configModel -> whereIn('configuracion_nombre', ['tienda_ruc']) -> set(['configuracion_valor' => $this -> request -> getPost('tienda_rfc')]) -> update();

                $this -> configModel -> whereIn('configuracion_nombre', ['tienda_telefono']) -> set(['configuracion_valor' => $this -> request -> getPost('tienda_telefono')]) -> update();

                $this -> configModel -> whereIn('configuracion_nombre', ['tienda_email']) -> set(['configuracion_valor' => $this -> request -> getPost('tienda_correo')]) -> update();

                $this -> configModel -> whereIn('configuracion_nombre', ['tienda_direccion']) -> set(['configuracion_valor' => $this -> request -> getPost('tienda_direccion')]) -> update();

                $this -> configModel -> whereIn('configuracion_nombre', ['ticket_leyenda']) -> set(['configuracion_valor' => $this -> request -> getPost('leyenda_ticket')]) -> update();

                if ($imgLogo -> isValid()) 
                {
                    $dataLogo = $this -> configModel -> getDatosTienda();
                    
                    unlink(__DIR__ .  '/../../public/img/' . $dataLogo['logoTienda']);

                    $imgLogo = $this -> request -> getFile('tienda_logo');
                    $imgName = date('Ymd_His_') . 'logotienda.' . $imgLogo -> getExtension();
                    $imgLogo -> move('./img', $imgName);

                    $this -> configModel -> whereIn('configuracion_nombre', ['tienda_logo']) -> set(['configuracion_valor' => $imgName]) -> update();
                }

                return redirect() -> to(base_url() . '/configuracion');
            }
            else
            {
                return $this -> index($this -> validator);
            }
            
        }
    }