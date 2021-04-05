<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class DetalleVentasModel extends Model 
    {
        protected $table      = 'det_venta';
        protected $primaryKey = 'det_venta_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['venta_id', 'producto_id', 'det_venta_cantidad', 'det_venta_nombre', 'det_venta_precio'];

        protected $useTimestamps = true;
        protected $createdField  = 'det_venta_creation';
        protected $updatedField  = null;
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }