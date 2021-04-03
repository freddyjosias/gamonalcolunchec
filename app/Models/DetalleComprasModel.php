<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class DetalleComprasModel extends Model 
    {
        protected $table      = 'det_compra';
        protected $primaryKey = 'det_compra_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['compra_id', 'producto_id', 'det_compra_cantidad', 'det_compra_nombre', 'det_compra_precio', 'det_compra_creation'];

        protected $useTimestamps = true;
        protected $createdField  = 'det_compra_creation';
        protected $updatedField  = null;
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }