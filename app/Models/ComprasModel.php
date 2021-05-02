<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class ComprasModel extends Model 
    {
        protected $table      = 'compra';
        protected $primaryKey = 'compra_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['compra_folio', 'compra_total', 'usuario_id', 'compra_ustate'];

        protected $useTimestamps = true;
        protected $createdField  = 'compra_creation';
        protected $updatedField  = null;
        protected $deletedField  = '';

        protected $validationRules    = [];
        protected $validationMessages = [];

        public function insertaCompra($idCompra, $total, $idUsuario)
        {
            $this -> insert([
                'compra_folio' => $idCompra, 
                'compra_total' => $total,
                'usuario_id' => $idUsuario
            ]);

            return $this -> insertId();
        }
    }