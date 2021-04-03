<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class TemporalCompraModel extends Model 
    {
        protected $table      = 'tem_compra';
        protected $primaryKey = 'tem_compra_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['tem_compra_folio', 'tem_compra_subtotal', 'producto_id', 'tem_compra_codigo', 'tem_compra_nombre', 'tem_compra_precio', 'tem_compra_cantidad'];

        protected $useTimestamps = false;
        protected $createdField  = null;
        protected $updatedField  = null;
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];

        public function porIdProductoCompra($idProducto, $folio)
        {
            $this -> select('*');
            $this -> where('tem_compra_folio', $folio);
            $this -> where('producto_id', $idProducto);
            $datos = $this -> get() -> getRow();
            return $datos;
        }

        public function porCompra($folio)
        {
            $this -> select('*');
            $this -> where('tem_compra_folio', $folio);
            $datos = $this -> findAll();
            return $datos;
        }

        public function actualizarProductoCompra($idProducto, $folio, $cantidad, $subTotal)
        {
            $this -> set('tem_compra_cantidad', $cantidad);
            $this -> set('tem_compra_subtotal', $subTotal);
            $this -> where('producto_id', $idProducto);
            $this -> where('tem_compra_folio', $folio);
            $this -> update();
        }

        public function eliminarProductoCompra($idProducto, $folio)
        {
            $this -> where('producto_id', $idProducto);
            $this -> where('tem_compra_folio', $folio);
            $this -> delete();
        }

        public function eliminarCompra($folio)
        {
            $this -> where('tem_compra_folio', $folio);
            $this -> delete();
        }
    }