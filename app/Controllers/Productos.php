<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ProductosModel;
    use App\Models\UnidadesModel;
    use App\Models\CategoriasModel;
    use App\Models\MarcasModel;
    use App\Models\DetallePermisosModel;

    class Productos extends BaseController
    {
        protected $productos, $categorias, $marcas;
        protected $reglas;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;

        public function __construct()
        {
            $this -> productos = new ProductosModel();
            $this -> unidades = new UnidadesModel();
            $this -> categorias = new CategoriasModel();
            $this -> marcas = new MarcasModel();
            $this -> detPermisos = new DetallePermisosModel();

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
        }

        public function index()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[2])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
            $productos = $this -> productos -> where('producto_state', 1) -> findAll();

            $dataHeader = ['permisos' => $this -> permisosUser];

            $data = [
                'title' => 
                'Productos', 
                'datos' => $productos
            ];

            echo view('header', $dataHeader);
            echo view('productos/productos', $data);
            echo view('footer');
        }

        public function nuevo()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[2])) 
                {
                    return redirect() -> to(base_url() . '/usuarios');
                }
            }

            $unidades = $this -> unidades -> where('unidad_state', 1) -> findAll();
            $categorias = $this -> categorias -> where('categoria_state', 1) -> findAll();
            $marcas = $this -> marcas -> where('marca_state', 1) -> findAll();

            $data = [
                'title' => 'Agregar Producto', 
                'unidades' => $unidades, 
                'categorias' => $categorias,
                'marcas' => $marcas
            ];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('productos/nuevo', $data);
            echo view('footer');
        }

        public function insertar()
        {
            $reglas = [
                'codigo' => [
                    'rules' => 'required|is_unique[producto.producto_codigo]',
                    'errors' => [
                        'required' => 'El campo Código es obligatorio.',
                        'is_unique' => 'El campo Código debe ser único.'
                    ]
                ], 
                'id_unidad' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Unidad es obligatorio.'
                    ]
                ],
                'id_categoria' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Categoría es obligatorio.'
                    ]
                ],
                'id_marca' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Marca es obligatorio.'
                    ]
                ]
            ];

            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[2])) 
                {
                    return redirect() -> to(base_url() . '/usuarios');
                }
            }
            
            if ($this -> request -> getMethod() == 'post' && $this -> validate($reglas)) 
            {
                $this -> productos -> save([
                    'producto_codigo' => $this -> request -> getPost('codigo'), 
                    'producto_nombre' => $this -> request -> getPost('nombre'), 
                    'producto_precioventa' => $this -> request -> getPost('precio_venta'), 
                    'producto_preciocompra' => $this -> request -> getPost('pracio_compra'), 
                    'producto_stockminimo' => $this -> request -> getPost('stock_minimo'), 
                    'unidad_id' => $this -> request -> getPost('id_unidad'), 
                    'categoria_id' => $this -> request -> getPost('id_categoria'),
                    'marca_id' => $this -> request -> getPost('id_marca')
                ]);
                
                return redirect() -> to(base_url() . '/productos');
            }
            else
            {
                $unidades = $this -> unidades -> where('unidad_state', 1) -> findAll();
                $categorias = $this -> categorias -> where('categoria_state', 1) -> findAll();
                $marcas = $this -> marcas -> where('marca_state', 1) -> findAll();

                $data = [
                    'title' =>'Agregar Producto', 
                    'unidades' => $unidades, 
                    'categorias' => $categorias,
                    'marcas' => $marcas,
                    'validation' => $this -> validator
                ];

                $dataHeader = ['permisos' => $this -> permisosUser];
            
                echo view('header', $dataHeader);
                echo view('productos/nuevo', $data);
                echo view('footer');
            }

        }

        public function editar($id = 0)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[2])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
            $unidades = $this -> unidades -> where('unidad_state', 1) -> findAll();
            $categorias = $this -> categorias -> where('categoria_state', 1) -> findAll();
            $producto = $this -> productos -> where('producto_id', $id) -> where('producto_state', 1) -> first();
            $marcas = $this -> marcas -> where('marca_state', 1) -> findAll();
            
            if (is_null($producto)) 
            {
                return redirect() -> to(base_url() . '/productos');
            }

            $data = [
                'title' => 'Editar Producto', 
                'unidades' => $unidades, 
                'categorias' => $categorias, 
                'producto' => $producto,
                'marcas' => $marcas
            ];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('productos/editar', $data);
            echo view('footer');
        }

        public function actualizar()
        {
            $reglas = [
                'codigo' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Código es obligatorio.'
                    ]
                ], 
                'id_unidad' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Unidad es obligatorio.'
                    ]
                ],
                'id_categoria' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Categoría es obligatorio.'
                    ]
                ],
                'id_marca' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo Marca es obligatorio.'
                    ]
                ]
            ];

            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[2])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
            $id = $this -> request -> getPost('id');

            if (is_null($id)) 
            {
                return redirect() -> to(base_url() . '/productos');
            }

            $producto = $this -> productos -> where('producto_id', $id) -> where('producto_state', 1) -> first();
            
            if (is_null($producto)) 
            {
                return redirect() -> to(base_url() . '/productos');
            }

            if ($this -> request -> getMethod() == 'post' && $this -> validate($reglas)) 
            {
                $this -> productos -> update(
                    $this -> request -> getPost('id'), 
                    [
                        'producto_codigo' => $this -> request -> getPost('codigo'), 
                        'producto_nombre' => $this -> request -> getPost('nombre'), 
                        'producto_precioventa' => $this -> request -> getPost('precio_venta'), 
                        'producto_preciocompra' => $this -> request -> getPost('pracio_compra'), 
                        'producto_stockminimo' => $this -> request -> getPost('stock_minimo'), 
                        'unidad_id' => $this -> request -> getPost('id_unidad'), 
                        'categoria_id' => $this -> request -> getPost('id_categoria'), 
                        'marca_id' => $this -> request -> getPost('id_marca')
                    ]
                );
                
                return redirect() -> to(base_url() . '/productos');
            }
            else
            {
                $unidades = $this -> unidades -> where('unidad_state', 1) -> findAll();
                $categorias = $this -> categorias -> where('categoria_state', 1) -> findAll();
                $producto = $this -> productos -> where('producto_id', $id) -> first();
                $marcas = $this -> marcas -> where('marca_state', 1) -> findAll();

                $data = [
                    'title' => 'Editar Producto', 
                    'unidades' => $unidades, 
                    'categorias' => $categorias, 
                    'producto' => $producto,
                    'marcas' => $marcas,
                    'validation' => $this -> validator
                ];

                $dataHeader = ['permisos' => $this -> permisosUser];
            
                echo view('header', $dataHeader);
                echo view('productos/editar', $data);
                echo view('footer');
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
                if (!isset($this -> permisosUser[2])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $producto = $this -> productos -> where('producto_id', $id) -> where('producto_state', 1) -> first();
            
            if (is_null($producto)) 
            {
                return redirect() -> to(base_url() . '/productos');
            }
            
            $this -> productos -> update($id, ['producto_state' => 0]);

            return redirect() -> to(base_url() . '/productos');
        }

        public function eliminados()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[2])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $productos = $this -> productos -> where('producto_state', 0) -> findAll();
            $data = ['title' => 'Productos Eliminadas', 'datos' => $productos];

            $dataHeader = ['permisos' => $this -> permisosUser];
            
            echo view('header', $dataHeader);
            echo view('productos/eliminados', $data);
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
                if (!isset($this -> permisosUser[2])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $producto = $this -> productos -> where('producto_id', $id) -> where('producto_state', 0) -> first();
            
            if (is_null($producto)) 
            {
                return redirect() -> to(base_url() . '/productos');
            }
            
            $this -> productos -> update($id, ['producto_state' => 1]);

            return redirect() -> to(base_url() . '/productos');
        }

        public function buscarporcodigo($codigo = 0)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[2])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }

            $this -> productos -> select('*');
            $this -> productos -> where('producto_codigo', $codigo);
            $this -> productos -> where('producto_state', 1);
            $datos = $this -> productos -> get() -> getRow();

            $res['existe'] = false;
            $res['datos'] = '';
            $res['error'] = '';

            if ($datos) 
            {
                $res['datos'] = $datos;
                $res['existe'] = true;
            }
            else
            {
                $res['error'] = 'No existe el producto';
            }

            echo json_encode($res);
        }

        public function autocompleteData()
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[2])) 
                {
                    return redirect() -> to(base_url() . '/dashboard');
                }
            }
            
            $returnData = array();

            $valor = $this -> request -> getGet('term');
            
            $productos = $this -> productos -> like('producto_codigo', $valor) -> where('producto_state', 1) -> findAll();
            
            if (!empty($productos)) 
            {
                foreach ($productos as $key => $value) 
                {
                    $data['id'] = $value['producto_id'];
                    $data['value'] = $value['producto_codigo'];
                    $data['label'] = $value['producto_codigo'] . ' - ' . $value['producto_nombre'];
                    array_push($returnData, $data);
                }
            }

            echo json_encode($returnData);
        }
        
    }