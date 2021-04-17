<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class MarcasModel extends Model 
    {
        protected $table      = 'marca';
        protected $primaryKey = 'marca_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['marca_nombre', 'marca_state'];

        protected $useTimestamps = true;
        protected $createdField  = 'marca_creation';
        protected $updatedField  = 'marca_update';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }