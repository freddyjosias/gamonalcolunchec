<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\CajasModel;

    class Cajas extends BaseController
    {
        protected $cajas;

        public function __construct()
        {
            $this -> cajas = new CajasModel();
        }

        public function index($state = 1)
        {
            $cajas = $this -> cajas -> where('caja_state', $state) -> findAll();
            $data = ['title' => 'Cajas', 'datos' => $cajas];

            echo view('header');
            echo view('cajas/cajas', $data);
            echo view('footer');
        }

        public function nuevo()
        {
            $data = ['title' => 'Agregar Caja'];

            echo view('header');
            echo view('cajas/nuevo', $data);
            echo view('footer');
        }

        public function insertar()
        {
            $this -> cajas -> save(['caja_nombre' => $this -> request -> getPost('nombre')]);

            return redirect() -> to(base_url() . '/cajas');
        }

        public function editar($id)
        {
            $caja = $this -> cajas -> where('caja_id', $id) -> first();
            $data = ['title' => 'Editar Caja', 'datos' => $caja];

            echo view('header');
            echo view('cajas/editar', $data);
            echo view('footer');
        }

        public function actualizar()
        {
            $this -> cajas -> update(
                $this -> request -> getPost('id'), 
                [
                    'caja_nombre' => $this -> request -> getPost('nombre')
                ]
            );

            return redirect() -> to(base_url() . '/cajas');
        }

        public function eliminar($id)
        {
            $this -> cajas -> update($id, ['caja_state' => 0]);

            return redirect() -> to(base_url() . '/cajas');
        }

        public function eliminados($state = 0)
        {
            $cajas = $this -> cajas -> where('caja_state', $state) -> findAll();
            $data = ['title' => 'Cajas Eliminadas', 'datos' => $cajas];

            echo view('header');
            echo view('cajas/eliminados', $data);
            echo view('footer');
        }

        public function reingresar($id)
        {
            $this -> cajas -> update($id, ['caja_state' => 1]);

            return redirect() -> to(base_url() . '/cajas');
        }
    }