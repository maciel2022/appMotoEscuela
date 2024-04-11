<?php 

namespace Controllers;

use Model\Servicios;
use MVC\Router;

class ServicioController {
    public static function index(Router $router) {
        isAdmin();

        $servicios = Servicios::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router) {
        isAdmin();

        $servicio = new Servicios;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router) {
        isAdmin();
        
        if(!is_numeric($_GET['id'])) return;

        $servicio = Servicios::find($_GET['id']);
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }

        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar() {
        isAdmin();  
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicio =  Servicios::find($id);
            $servicio->eliminar();
            header('Location: /servicios');
        }
    }
}
?>