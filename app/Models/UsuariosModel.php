<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class UsuariosModel extends Model 
    {
        protected $table      = 'usuario';
        protected $primaryKey = 'usuario_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['usuario_user', 'usuario_password', 'usuario_nombre', 'caja_id', 'rol_id', 'usuario_state'];

        protected $useTimestamps = true;
        protected $createdField  = 'usuario_creation';
        protected $updatedField  = 'usuario_update';
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];
    }