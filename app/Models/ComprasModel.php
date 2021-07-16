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

        protected $allowedFields = [
            'compra_folio', 
            'compra_total', 
            'usuario_id', 
            'compra_ustate', 
            'compra_proveedor', 
            'compra_tipodoc', 
            'compra_numerodoc',
            'compra_fechadoc',
            'compra_igv'
        ];

        protected $useTimestamps = true;
        protected $createdField  = 'compra_creation';
        protected $updatedField  = null;
        protected $deletedField  = '';

        protected $validationRules    = [];
        protected $validationMessages = [];

        public function insertaCompra($idCompra, $total, $idUsuario, $proveedor, $numerodoc, $fechadoc, $tipodoc, $igv)
        {
            $this -> insert([
                'compra_folio' => $idCompra, 
                'compra_total' => $total,
                'usuario_id' => $idUsuario,
                'compra_tipodoc' => $tipodoc,
                'compra_numerodoc' => $numerodoc,
                'compra_fechadoc' => $fechadoc,
                'compra_proveedor' => $proveedor,
                'compra_igv' => $igv
            ]);

            return $this -> insertId();
        }
    }