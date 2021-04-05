<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ClientesModel;

    class Clientes extends BaseController
    {
        protected $clientes;
        protected $reglas;

        public function __construct()
        {
            $this -> clientes = new ClientesModel();
            helper(['form']);

            $this -> reglas = [
                'nombre' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.'
                    ]
                ]
            ];
        }

        public function index($state = 1)
        {
            $clientes = $this -> clientes -> where('cliente_state', $state) -> findAll();

            $data = ['title' => 'Clientes', 'datos' => $clientes];

            echo view('header');
            echo view('clientes/clientes', $data);
            echo view('footer');
        }

        public function nuevo()
        {
            $data = ['title' => 'Agregar Cliente'];

            echo view('header');
            echo view('clientes/nuevo', $data);
            echo view('footer');
        }

        public function insertar()
        {
            if ($this -> request -> getMethod() == 'post' && $this -> validate($this -> reglas)) 
            {
                $this -> clientes -> save([
                    'cliente_nombre' => $this -> request -> getPost('nombre'), 
                    'cliente_direccion' => $this -> request -> getPost('direccion'), 
                    'cliente_telefono' => $this -> request -> getPost('telefono'), 
                    'cliente_correo' => $this -> request -> getPost('correo')
                ]);
                return redirect() -> to(base_url() . '/clientes');
            }
            else
            {
                $data = ['title' => 'Agregar Cliente', 'validation' => $this -> validator];

                echo view('header');
                echo view('clientes/nuevo', $data);
                echo view('footer');
            }

        }

        public function editar($id)
        {
            $cliente = $this -> clientes -> where('cliente_id', $id) -> first();
            $data = ['title' => 'Editar Cliente', 'cliente' => $cliente];

            echo view('header');
            echo view('clientes/editar', $data);
            echo view('footer');
        }

        public function actualizar()
        {
            $this -> clientes -> update(
                $this -> request -> getPost('id'), 
                [
                    'cliente_nombre' => $this -> request -> getPost('nombre'), 
                    'cliente_corto' => $this -> request -> getPost('nombre_corto')
                ]
            );

            $this -> clientes -> update(
                $this -> request -> getPost('id'), 
                [
                    'cliente_nombre' => $this -> request -> getPost('nombre'), 
                    'cliente_direccion' => $this -> request -> getPost('direccion'), 
                    'cliente_telefono' => $this -> request -> getPost('telefono'), 
                    'cliente_correo' => $this -> request -> getPost('correo')
                ]
            );
            return redirect() -> to(base_url() . '/clientes');
        }

        public function eliminar($id)
        {
            $this -> clientes -> update($id, ['cliente_state' => 0]);

            return redirect() -> to(base_url() . '/clientes');
        }

        public function eliminados($state = 0)
        {
            $clientes = $this -> clientes -> where('cliente_state', $state) -> findAll();
            $data = ['title' => 'Clientes Eliminadas', 'datos' => $clientes];

            echo view('header');
            echo view('clientes/eliminados', $data);
            echo view('footer');
        }

        public function reingresar($id)
        {
            $this -> clientes -> update($id, ['cliente_state' => 1]);

            return redirect() -> to(base_url() . '/clientes');
        }

        public function autocompleteData()
        {
            $returnData = array();

            $valor = $this -> request -> getGet('term');
            
            $clientes = $this -> clientes -> like('cliente_nombre', $valor) -> where('cliente_state', 1) -> findAll();

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