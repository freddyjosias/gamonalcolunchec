<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class CajasModel extends Model 
    {
        protected $table      = 'caja';
        protected $primaryKey = 'caja_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['caja_numero','caja_nombre', 'caja_folio', 'caja_state'];

        protected $useTimestamps = true;
        protected $createdField  = 'caja_creation';
        protected $updatedField  = 'caja_update';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }