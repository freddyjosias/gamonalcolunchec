<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class DetallePermisosModel extends Model 
    {
        protected $table      = 'det_permiso';
        protected $primaryKey = 'det_permiso_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['permiso_id', 'usuario_id', 'det_permiso_state', 'det_permiso_creation', 'det_permiso_update'];

        protected $useTimestamps = true;
        protected $createdField  = 'det_permiso_creation';
        protected $updatedField  = 'det_permiso_update';
        protected $deletedField  = '';

        protected $validationRules    = [];
        protected $validationMessages = [];

        public function getPermisosPorUsuario($idUser, $state = 1)
        {
            $this -> select('det_permiso.*, permiso_nombre');
            $this -> join('permiso', 'det_permiso.permiso_id = permiso.permiso_id');
            $this -> where('usuario_id', $idUser);

            if ($state != 3) 
            {
                $this -> where('det_permiso_state', $state);
            }
            
            $this -> orderBy('permiso_orden', 'ASC');
            $datos = $this -> findAll();
            $newDatos = array();

            foreach ($datos as $key => $value) 
            {
                $auxPermiso = $value['permiso_id'];
                $auxPermiso = intval($auxPermiso);

                $newDatos[$auxPermiso] = $value;
            }       
                 
            return $newDatos;
        }

        public function getPermisosPorUsuarioPorModulo($idUser, $idPermiso)
        {
            $this -> select('det_permiso.*, permiso_nombre');
            $this -> join('permiso', 'det_permiso.permiso_id = permiso.permiso_id');
            $this -> where('usuario_id', $idUser);
            $this -> where('det_permiso.permiso_id', $idPermiso);
            $this -> where('det_permiso_state', 1);
            $this -> orderBy('permiso_orden', 'ASC');
            $datos = $this -> first();
            
            if (is_null($datos)) 
            {
                return false;
            }
            else
            {
                return true;
            }            
        }
    }