<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class RolesModel extends Model 
    {
        protected $table      = 'rol';
        protected $primaryKey = 'rol_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['rol_nombre', 'rol_state'];

        protected $useTimestamps = true;
        protected $createdField  = 'rol_creation';
        protected $updatedField  = 'rol_update';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }