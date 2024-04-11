<?php 

namespace Model; 

class TurnoServicio extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'turnosServicios';
    protected static $columnasDB = ['id', 'turnosId', 'serviciosId'];

    public $id;
    public $turnosId;
    public $serviciosId;

    public function __construct($args = []) 
    {
        $this->id = $args['id'] ?? null;
        $this->turnosId = $args['turnosId'] ?? '';
        $this->serviciosId = $args['serviciosId'] ?? '';
    }

}

?>