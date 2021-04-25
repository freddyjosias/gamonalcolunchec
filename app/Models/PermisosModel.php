<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class PermisosModel extends Model 
    {
        protected $table      = 'permiso';
        protected $primaryKey = 'permiso_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['permiso_nombre', 'permiso_orden'];

        protected $useTimestamps = true;
        protected $createdField  = '';
        protected $updatedField  = '';
        protected $deletedField  = '';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }