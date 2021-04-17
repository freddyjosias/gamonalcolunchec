<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\CategoriasModel;

    class Categorias extends BaseController
    {
        protected $categorias;

        public function __construct()
        {
            $this -> categorias = new CategoriasModel();
        }

        public function index($state = 1)
        {
            $categorias = $this -> categorias -> where('categoria_state', $state) -> findAll();
            $data = ['title' => 'Categorías', 'datos' => $categorias];

            echo view('header');
            echo view('categorias/categorias', $data);
            echo view('footer');
        }

        public function nuevo()
        {
            $data = ['title' => 'Agregar Categoría'];

            echo view('header');
            echo view('categorias/nuevo', $data);
            echo view('footer');
        }

        public function insertar()
        {
            $this -> categorias -> save(['categoria_nombre' => $this -> request -> getPost('nombre')]);

            return redirect() -> to(base_url() . '/categorias');
        }

        public function editar($id)
        {
            $categoria = $this -> categorias -> where('categoria_id', $id) -> first();
            $data = ['title' => 'Editar Categoría', 'datos' => $categoria];

            echo view('header');
            echo view('categorias/editar', $data);
            echo view('footer');
        }

        public function actualizar()
        {
            $this -> categorias -> update(
                $this -> request -> getPost('id'), 
                [
                    'categoria_nombre' => $this -> request -> getPost('nombre')
                ]
            );

            return redirect() -> to(base_url() . '/categorias');
        }

        public function eliminar($id)
        {
            $this -> categorias -> update($id, ['categoria_state' => 0]);

            return redirect() -> to(base_url() . '/categorias');
        }

        public function eliminados($state = 0)
        {
            $categorias = $this -> categorias -> where('categoria_state', $state) -> findAll();
            $data = ['title' => 'Categorías Eliminadas', 'datos' => $categorias];

            echo view('header');
            echo view('categorias/eliminados', $data);
            echo view('footer');
        }

        public function reingresar($id)
        {
            $this -> categorias -> update($id, ['categoria_state' => 1]);

            return redirect() -> to(base_url() . '/categorias');
        }
    }