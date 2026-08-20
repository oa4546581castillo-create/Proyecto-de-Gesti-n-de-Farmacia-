<?php
// Enrutador Front Controller
$controlador = $_GET['controlador'] ?? 'Producto';
$accion = $_GET['accion'] ?? 'index';

$nombreControlador = $controlador . 'Controller';
$archivoControlador = '../controllers/' . $nombreControlador . '.php';

if (file_exists($archivoControlador)) {
    require_once $archivoControlador;
    if (class_exists($nombreControlador)) {
        $objetoControlador = new $nombreControlador();
        if (method_exists($objetoControlador, $accion)) {
            $objetoControlador->$accion();
        } else {
            echo "Error 404: La acción '$accion' no existe.";
        }
    } else {
        echo "Error 404: La clase '$nombreControlador' no existe.";
    }
} else {
    echo "Error 404: El controlador '$nombreControlador' no fue encontrado.";
}