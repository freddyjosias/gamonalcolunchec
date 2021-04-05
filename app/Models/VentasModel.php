<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class VentasModel extends Model 
    {
        protected $table      = 'venta';
        protected $primaryKey = 'venta_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['venta_folio', 'venta_total', 'usuario_id', 'venta_state', 'caja_id', 'cliente_id', 'venta_formapago'];

        protected $useTimestamps = true;
        protected $createdField  = 'venta_creation';
        protected $updatedField  = null;
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];

        public function insertaVenta($idVenta, $total, $idUsuario, $idCaja, $idCliente, $formaPago)
        {
            $this -> insert([
                'venta_folio' => $idVenta, 
                'venta_total' => $total,
                'usuario_id' => $idUsuario,
                'caja_id' => $idCaja,
                'cliente_id' => $idCliente,
                'venta_formapago' => $formaPago
            ]);

            return $this -> insertId();
        }
    }