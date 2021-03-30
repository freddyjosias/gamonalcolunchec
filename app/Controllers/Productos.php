<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ProductosModel;
    use App\Models\UnidadesModel;
    use App\Models\CategoriasModel;

    class Productos extends BaseController
    {
        protected $productos;
        //protected $unidades;
        //protected $categorias;

        public function __construct()
        {
            $this -> productos = new ProductosModel();
            $this -> unidades = new UnidadesModel();
            $this -> categorias = new CategoriasModel();
        }

        public function index($state = 1)
        {
            $productos = $this -> productos -> where('producto_state', $state) -> findAll();

            $data = ['title' => 'Productos', 'datos' => $productos];

            echo view('header');
            echo view('productos/productos', $data);
            echo view('footer');
        }

        public function nuevo()
        {
            $unidades = $this -> unidades -> where('unidad_state', 1) -> findAll();
            $categorias = $this -> categorias -> where('categoria_state', 1) -> findAll();

            $data = ['title' => 'Agregar Producto', 'unidades' => $unidades, 'categorias' => $categorias];

            echo view('header');
            echo view('productos/nuevo', $data);
            echo view('footer');
        }

        public function insertar()
        {
            if ($this -> request -> getMethod() == 'post') 
            {
                $this -> productos -> save([
                    'producto_codigo' => $this -> request -> getPost('codigo'), 
                    'producto_nombre' => $this -> request -> getPost('nombre'), 
                    'producto_precioventa' => $this -> request -> getPost('precio_venta'), 
                    'producto_preciocompra' => $this -> request -> getPost('pracio_compra'), 
                    //'producto_stock' => $this -> request -> getPost('nombre'), 
                    'producto_stockminimo' => $this -> request -> getPost('stock_minimo'), 
                    'unidad_id' => $this -> request -> getPost('id_unidad'), 
                    'categoria_id' => $this -> request -> getPost('id_categoria'), 
                    'producto_inventariable' => $this -> request -> getPost('inventariable')
                ]);
                return redirect() -> to(base_url() . '/productos');
            }
            else
            {
                $data = ['title' => 'Agregar Unidad'];

                echo view('header');
                echo view('productos/nuevo', $data);
                echo view('footer');
            }

            
        }

        public function editar($id)
        {
            $producto = $this -> productos -> where('producto_id', $id) -> first();
            $data = ['title' => 'Editar Unidad', 'datos' => $producto];

            echo view('header');
            echo view('productos/editar', $data);
            echo view('footer');
        }

        public function actualizar()
        {
            $this -> productos -> update(
                $this -> request -> getPost('id'), 
                [
                    'producto_nombre' => $this -> request -> getPost('nombre'), 
                    'producto_corto' => $this -> request -> getPost('nombre_corto')
                ]
            );

            return redirect() -> to(base_url() . '/productos');
        }

        public function eliminar($id)
        {
            $this -> productos -> update($id, ['producto_state' => 0]);

            return redirect() -> to(base_url() . '/productos');
        }

        public function eliminados($state = 0)
        {
            $productos = $this -> productos -> where('producto_state', $state) -> findAll();
            $data = ['title' => 'Productos Eliminadas', 'datos' => $productos];

            echo view('header');
            echo view('productos/eliminados', $data);
            echo view('footer');
        }

        public function reingresar($id)
        {
            $this -> productos -> update($id, ['producto_state' => 1]);

            return redirect() -> to(base_url() . '/productos');
        }
    }