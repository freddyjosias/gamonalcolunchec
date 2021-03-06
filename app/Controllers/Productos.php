<?php

    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\ProductosModel;
    use App\Models\UnidadesModel;
    use App\Models\CategoriasModel;
    use App\Models\MarcasModel;
    use App\Models\ConfiguracionModel;
    use App\Models\DetallePermisosModel;

    class Productos extends BaseController
    {
        protected $productos, $categorias, $marcas;
        protected $reglas;
        protected $configModel, $datosTienda;
        protected $isLogin = true, $detPermisos, $session, $permisosUser;

        public function __construct()
        {
            $this -> productos = new ProductosModel();
            $this -> unidades = new UnidadesModel();
            $this -> categorias = new CategoriasModel();
            $this -> marcas = new MarcasModel();
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

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'title' => 'Productos', 
                'datos' => $productos,
                'nombreTienda' => $this -> datosTienda['nombreTienda']
            ];

            echo view('header', $dataHeader);
            echo view('productos/productos');
            echo view('footer');
        }

        public function nuevo($idCompra = null)
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

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'title' => 'Agregar Producto', 
                'unidades' => $unidades, 
                'categorias' => $categorias,
                'marcas' => $marcas,
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'idCompra' => $idCompra
            ];

            echo view('header', $dataHeader);
            echo view('productos/nuevo');
            echo view('footer');
        }

        public function insertar($idCompra = null)
        {
            $reglas = [
                'codigo' => [
                    'rules' => 'required|is_unique[producto.producto_codigo]',
                    'errors' => [
                        'required' => 'El campo C??digo es obligatorio.',
                        'is_unique' => 'El campo C??digo debe ser ??nico.'
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
                        'required' => 'El campo Categor??a es obligatorio.'
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
                
                if (is_null($idCompra)) {
                    return redirect() -> to(base_url() . '/productos');
                } else {
                    return redirect() -> to(base_url() . '/compras/nuevo/' . $idCompra . '/' . $this -> request -> getPost('codigo'));
                }
                
            }
            else
            {
                $unidades = $this -> unidades -> where('unidad_state', 1) -> findAll();
                $categorias = $this -> categorias -> where('categoria_state', 1) -> findAll();
                $marcas = $this -> marcas -> where('marca_state', 1) -> findAll();

                $dataHeader = [
                    'permisos' => $this -> permisosUser,
                    'logoTienda' => $this -> datosTienda['logoTienda'],
                    'title' => 'Agregar Producto', 
                    'unidades' => $unidades, 
                    'categorias' => $categorias,
                    'marcas' => $marcas,
                    'validation' => $this -> validator,
                    'nombreTienda' => $this -> datosTienda['nombreTienda'],
                    'idCompra' => $idCompra
                ];
    
                echo view('header', $dataHeader);
                echo view('productos/nuevo');
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

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'title' => 'Editar Producto', 
                'unidades' => $unidades, 
                'categorias' => $categorias, 
                'producto' => $producto,
                'marcas' => $marcas,
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
            ];

            echo view('header', $dataHeader);
            echo view('productos/editar');
            echo view('footer');
        }

        public function actualizar()
        {
            $reglas = [
                'codigo' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'El campo C??digo es obligatorio.'
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
                        'required' => 'El campo Categor??a es obligatorio.'
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

                $dataHeader = [
                    'permisos' => $this -> permisosUser,
                    'logoTienda' => $this -> datosTienda['logoTienda'],
                    'title' => 'Editar Producto', 
                    'unidades' => $unidades, 
                    'categorias' => $categorias, 
                    'producto' => $producto,
                    'marcas' => $marcas,
                    'validation' => $this -> validator,
                    'nombreTienda' => $this -> datosTienda['nombreTienda'],
                ];
    
                echo view('header', $dataHeader);
                echo view('productos/editar');
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

            $dataHeader = [
                'permisos' => $this -> permisosUser,
                'logoTienda' => $this -> datosTienda['logoTienda'],
                'nombreTienda' => $this -> datosTienda['nombreTienda'],
                'title' => 'Productos Eliminadas', 
                'datos' => $productos
            ];

            echo view('header', $dataHeader);
            echo view('productos/eliminados');
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

        public function buscarporcodigo($codigo = 0, $idCompra = null)
        {
            if (!$this -> isLogin) 
            {
                return redirect() -> to(base_url());
            }
            else
            {
                if (!isset($this -> permisosUser[6])) 
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
                if (!isset($this -> permisosUser[2])) 
                {
                    $res['error'] = 'No existe el producto';
                }
                else 
                {
                    $res['error'] = 'No existe el producto';
                    //$res['error'] = 'No existe el producto <a href="' . base_url() . '/productos/nuevo/' . $idCompra . '" class="color-primary">Agregar</a>';
                }
                
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