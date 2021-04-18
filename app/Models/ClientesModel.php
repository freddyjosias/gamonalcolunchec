<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class ClientesModel extends Model 
    {
        protected $table      = 'cliente';
        protected $primaryKey = 'cliente_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = [
            'cliente_nombre', 
            'cliente_apellido', 
            'cliente_direccion', 
            'cliente_dni', 
            'cliente_telefono', 
            'cliente_correo', 
            'cliente_state',
            'cliente_documento'
        ];

        protected $useTimestamps = true;
        protected $createdField  = 'cliente_creation';
        protected $updatedField  = 'cliente_update';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }