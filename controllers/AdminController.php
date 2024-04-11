<?php 

namespace Controllers;

use Model\AdminTurno;
use MVC\Router;

class AdminController {
    public static function index( Router $router ) {
        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d'); // tomamos la fecha de la url, sino la del dia actual
        $fechas = explode('-', $fecha); // separamos la fecha separada por el guion medio

        if(!checkdate( $fechas[1], $fechas[2], $fechas[0])) {
            header('Location: /404');
        }

        // Consultar la BD
        $consulta = "SELECT turnos.id, turnos.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM turnos  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON turnos.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN turnosServicios ";
        $consulta .= " ON turnosServicios.turnosId=turnos.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=turnosServicios.serviciosId ";
        $consulta .= " WHERE fecha = '{$fecha}' ";

        $turnos = AdminTurno::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'turnos' => $turnos,
            'fecha' => $fecha
        ]);
    }
}

?>