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
        //protected $useSoftUpdates = false;
        //protected $useSoftCreates = false;

        protected $allowedFields = ['configuracion_nombre', 'configuracion_valoe'];

        protected $useTimestamps = true;
        protected $createdField  = 'configuracion_creation';
        protected $updatedField  = 'configuracion_update';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }