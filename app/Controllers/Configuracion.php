<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    //use App\Models\ClientesModel;
    use App\Models\ConfiguracionModel;

    class Configuracion extends BaseController
    {
        protected $configuracion;
        protected $reglas;

        public function __construct()
        {
            $this -> configuracion = new ConfiguracionModel();
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

        public function index($state = 1)
        {
            $data = $this -> configuracion -> getDatosTienda();

            $data['title'] = 'Configuración';
            
            //var_dump($nombre); die;
            echo view('header');
            echo view('configuracion/configuracion', $data);
            echo view('footer');
        }

        public function editar($id, $valid = null)
        {
            $unidad = $this -> configuracion -> where('unidad_id', $id) -> first();

            if ($valid != null) 
            {
                $data = ['title' => 'Editar Unidad', 'datos' => $unidad, 'validation' => $valid];
            }
            else
            {
                $data = ['title' => 'Editar Unidad', 'datos' => $unidad];
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