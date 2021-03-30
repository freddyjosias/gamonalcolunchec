<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\UnidadesModel;

    class Unidades extends BaseController
    {
        protected $unidades;

        public function __construct()
        {
            $this -> unidades = new UnidadesModel();
        }

        public function index($state = 1)
        {
            $unidades = $this -> unidades -> where('unidad_state', $state) -> findAll();
            $data = ['title' => 'Unidades', 'datos' => $unidades];

            echo view('header');
            echo view('unidades/unidades', $data);
            echo view('footer');
        }

        public function nuevo()
        {
            $data = ['title' => 'Agregar Unidad'];

            echo view('header');
            echo view('unidades/nuevo', $data);
            echo view('footer');
        }

        public function insertar()
        {
            if ($this -> request -> getMethod() == 'POST' && $this -> validate(['nombre' => 'required', 'nombre_corto' => 'required'])) 
            {
                $this -> unidades -> save([
                    'unidad_nombre' => $this -> request -> getPost('nombre'), 
                    'unidad_corto' => $this -> request -> getPost('nombre_corto')
                ]);
                return redirect() -> to(base_url() . '/unidades');
            }
            else
            {
                $data = ['title' => 'Agregar Unidad'];

                echo view('header');
                echo view('unidades/nuevo', $data);
                echo view('footer');
            }

            
        }

        public function editar($id)
        {
            $unidad = $this -> unidades -> where('unidad_id', $id) -> first();
            $data = ['title' => 'Editar Unidad', 'datos' => $unidad];

            echo view('header');
            echo view('unidades/editar', $data);
            echo view('footer');
        }

        public function actualizar()
        {
            $this -> unidades -> update(
                $this -> request -> getPost('id'), 
                [
                    'unidad_nombre' => $this -> request -> getPost('nombre'), 
                    'unidad_corto' => $this -> request -> getPost('nombre_corto')
                ]
            );

            return redirect() -> to(base_url() . '/unidades');
        }

        public function eliminar($id)
        {
            $this -> unidades -> update($id, ['unidad_state' => 0]);

            return redirect() -> to(base_url() . '/unidades');
        }

        public function eliminados($state = 0)
        {
            $unidades = $this -> unidades -> where('unidad_state', $state) -> findAll();
            $data = ['title' => 'Unidades Eliminadas', 'datos' => $unidades];

            echo view('header');
            echo view('unidades/eliminados', $data);
            echo view('footer');
        }

        public function reingresar($id)
        {
            $this -> unidades -> update($id, ['unidad_state' => 1]);

            return redirect() -> to(base_url() . '/unidades');
        }
    }