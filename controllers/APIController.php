<?php 

namespace Controllers;


use Model\Servicios;
use Model\Turno;
use Model\TurnoServicio;

class APIController {
    public static function index() {
        $servicios = Servicios::all();

        echo json_encode($servicios);
    }

    public static function guardar() {
        
        // Almacena el turno y devuelve el Id
        $turno = new Turno($_POST);
        $resultado = $turno->guardar();

        $id = $resultado['id'];

        // Almacena los Servicios con el Id del Turno
        $idServicios = explode(",", $_POST['servicios']);

        foreach($idServicios as $idServicio) {
            $args = [
                'turnosId' => $id,
                'serviciosId' => $idServicio
            ];
            $turnoServicio = new TurnoServicio($args);
            $turnoServicio->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $turno = Turno::find($id);
            $turno->eliminar();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }


}



?>