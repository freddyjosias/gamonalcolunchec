<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class UnidadesModel extends Model 
    {
        protected $table      = 'unidad';
        protected $primaryKey = 'unidad_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['unidad_nombre', 'unidad_corto', 'unidad_state'];

        protected $useTimestamps = true;
        protected $createdField  = 'unidad_creation';
        protected $updatedField  = 'unidad_update';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }