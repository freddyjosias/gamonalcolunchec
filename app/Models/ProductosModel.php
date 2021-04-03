<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class ProductosModel extends Model 
    {
        protected $table      = 'producto';
        protected $primaryKey = 'producto_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = [
            'producto_nombre', 
            'producto_codigo', 
            'producto_precioventa', 
            'producto_preciocompra', 
            'producto_stock', 
            'producto_stockminimo', 
            'producto_inventariable', 
            'unidad_id', 
            'categoria_id', 
            'producto_state'
        ];

        protected $useTimestamps = true;
        protected $createdField  = 'producto_creation';
        protected $updatedField  = null;
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];

        public function actualizaStock($idProducto, $cantidad)
        {
            $this -> set('producto_stock', 'producto_stock + ' . $cantidad, FALSE);
            $this -> where('producto_id', $idProducto);
            $this -> update();
        }
    }