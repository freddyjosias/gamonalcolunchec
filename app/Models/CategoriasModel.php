<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class CategoriasModel extends Model 
    {
        protected $table      = 'categoria';
        protected $primaryKey = 'categoria_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['categoria_nombre', 'categoria_state'];

        protected $useTimestamps = true;
        protected $createdField  = 'categoria_creation';
        protected $updatedField  = 'categoria_update';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }