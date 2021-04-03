<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class ConfiguracionModel extends Model 
    {
        protected $table      = 'configuracion';
        protected $primaryKey = 'configuracion_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['configuracion_nombre', 'configuracion_valor'];

        protected $useTimestamps = true;
        protected $createdField  = null;
        protected $updatedField  = null;
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }