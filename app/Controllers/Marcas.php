<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\MarcasModel;

    class Marcas extends BaseController
    {
        protected $marcas;

        public function __construct()
        {
            $this -> marcas = new MarcasModel();
        }

        public function index($state = 1)
        {
            $marcas = $this -> marcas -> where('marca_state', $state) -> findAll();
            $data = ['title' => 'Marcas', 'datos' => $marcas];

            echo view('header');
            echo view('marcas/marcas', $data);
            echo view('footer');
        }

        public function nuevo()
        {
            $data = ['title' => 'Agregar Marca'];

            echo view('header');
            echo view('marcas/nuevo', $data);
            echo view('footer');
        }

        public function insertar()
        {
            $this -> marcas -> save(['marca_nombre' => $this -> request -> getPost('nombre')]);

            return redirect() -> to(base_url() . '/marcas');
        }

        public function editar($id)
        {
            $marca = $this -> marcas -> where('marca_id', $id) -> first();
            $data = ['title' => 'Editar Marca', 'datos' => $marca];

            echo view('header');
            echo view('marcas/editar', $data);
            echo view('footer');
        }

        public function actualizar()
        {
            $this -> marcas -> update(
                $this -> request -> getPost('id'), 
                [
                    'marca_nombre' => $this -> request -> getPost('nombre')
                ]
            );

            return redirect() -> to(base_url() . '/marcas');
        }

        public function eliminar($id)
        {
            $this -> marcas -> update($id, ['marca_state' => 0]);

            return redirect() -> to(base_url() . '/marcas');
        }

        public function eliminados($state = 0)
        {
            $marcas = $this -> marcas -> where('marca_state', $state) -> findAll();
            $data = ['title' => 'Marcas Eliminadas', 'datos' => $marcas];

            echo view('header');
            echo view('marcas/eliminados', $data);
            echo view('footer');
        }

        public function reingresar($id)
        {
            $this -> marcas -> update($id, ['marca_state' => 1]);

            return redirect() -> to(base_url() . '/marcas');
        }
    }