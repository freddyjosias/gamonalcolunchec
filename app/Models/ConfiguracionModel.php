<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class ConfiguracionModel extends Model 
    {
        protected $table      = 'configuracion';
        protected $primaryKey = 'configuracion_id';

        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['configuracion_nombre', 'configuracion_valor'];

        protected $useTimestamps = true;
        protected $createdField  = null;
        protected $updatedField  = null;
        protected $deletedField  = 'deleted_at';

        protected $validationRules    = [];
        protected $validationMessages = [];

        public function getDatosTienda()
        {
            $nombre = $this -> where('configuracion_nombre', 'nombre_tienda') -> first();
            $rfl = $this -> where('configuracion_nombre', 'tienda_ruc') -> first();
            $telefono = $this -> where('configuracion_nombre', 'tienda_telefono') -> first();
            $email = $this -> where('configuracion_nombre', 'tienda_email') -> first();
            $direccion = $this -> where('configuracion_nombre', 'tienda_direccion') -> first();
            $leyenda = $this -> where('configuracion_nombre', 'ticket_leyenda') -> first();
            $logo = $this -> where('configuracion_nombre', 'tienda_logo') -> first();

            $data = [
                'nombreTienda' => $nombre['configuracion_valor'],
                'rucTienda' => $rfl['configuracion_valor'],
                'telefonoTienda' => $telefono['configuracion_valor'],
                'emailTienda' => $email['configuracion_valor'],
                'direccionTienda' => $direccion['configuracion_valor'],
                'leyendaTicket' => $leyenda['configuracion_valor'],
                'logoTienda' => $logo['configuracion_valor']
            ];

            return $data;
        }
    }