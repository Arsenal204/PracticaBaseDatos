<?php
session_start();
use App\Utils\Utils;

$tiempoInactividad = 120; // 2 minutos (120 segundos)

if (isset($_SESSION['ultimoAcceso'])) {
    $tiempoTranscurrido = time() - $_SESSION['ultimoAcceso'];
    if ($tiempoTranscurrido > $tiempoInactividad) {
        session_destroy();

        // Si la petición es AJAX, devolver un código de error 401 y no redirigir
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            http_response_code(401);
            echo json_encode(["error" => "Sesión expirada"]);
            exit;
        }else{
            //Si no es AJAX, se redirige normalmente
            Utils::redirect('/');
            exit();
        }
    }
}

$_SESSION['ultimoAcceso'] = time();

if (!isset($_SESSION['user_id'])) {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        // Si la petición es AJAX, devolver un código de error (401 o 403)
        http_response_code(401);
        echo json_encode(["error" => "Sesión expirada"]);
        exit;
    } else {
        // Si no es AJAX, redirigir al login
        Utils::redirect("/");
        exit;
    }
}
?>