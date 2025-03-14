<?php 

use FastRoute\RouteCollector;

return(function (RouteCollector $r) {

    $r->addRoute('GET', '/', ['App\Controller\UsuarioController', 'cargarLogin']);
    $r->addRoute('POST', '/', ['App\Controller\UsuarioController', 'login']);
    $r->addRoute('GET', '/logout', ['App\Controller\UsuarioController', 'logout']);
    $r->addRoute('GET', '/registro', ['App\Controller\UsuarioController', 'cargarRegistro']);
    $r->addRoute('POST', '/registro', ['App\Controller\UsuarioController', 'registro']);
    $r->addRoute('GET', '/validar', ['App\Controller\UsuarioController', 'validar']);
    $r->addRoute('GET', '/validate', ['App\Controller\UsuarioController', 'validate']);

    $r->addRoute('GET', '/listaPaises/{pagina:\d+}', ['App\\Controller\\PaisController', 'listarPaises']);
    $r->addRoute('GET', '/paises/{id:\d+}', ['App\\Controller\\PaisController', 'mostrarPais']);
    $r->addRoute('GET', '/paises/crear', ['App\\Controller\\PaisController', 'crearPais']);
    $r->addRoute('POST', '/paises/crear', ['App\\Controller\\PaisController', 'insertarPais']);
    $r->addRoute('GET', '/paises/{id:\d+}/modificar', ['App\\Controller\\PaisController', 'editarPais']);
    $r->addRoute('POST', '/paises/{id:\d+}/modificar', ['App\\Controller\\PaisController', 'modificarPais']);
    $r->addRoute('GET', '/paises/{id:\d+}/eliminar', ['App\\Controller\\PaisController', 'eliminarPais']);


    // Rutas para Distribuciones
    $r->addRoute('GET', '/listaDistribuciones/{pagina:\d+}', ['App\\Controller\\DistribucionController', 'listarDistribuciones']);
    $r->addRoute('GET', '/distribuciones/{id:\d+}', ['App\\Controller\\DistribucionController', 'mostrarDistribucion']);
    $r->addRoute('GET', '/distribuciones/crear', ['App\\Controller\\DistribucionController', 'crearDistribucion']);
    $r->addRoute('POST', '/distribuciones/insertar', ['App\\Controller\\DistribucionController', 'insertarDistribucion']);    
    $r->addRoute('GET', '/distribuciones/{id:\d+}/eliminar', ['App\\Controller\\DistribucionController', 'eliminarDistribucion']);
    $r->addRoute('GET', '/distribuciones/{id:\d+}/modificar', ['App\Controller\DistribucionController', 'editarDistribucion']);
    $r->addRoute('POST', '/distribuciones/{id:\d+}/modificar', ['App\Controller\DistribucionController', 'modificarDistribucion']);


    // Rutas para Productos
    $r->addRoute('GET', '/productos', ['App\Controller\ProductoController', 'listarProductos']);
    $r->addRoute('GET', '/productos/{id:\d+}', ['App\Controller\ProductoController', 'mostrarProducto']);
    $r->addRoute('GET', '/productos/crear', ['App\Controller\ProductoController', 'crearProducto']);
    $r->addRoute('POST', '/productos/crear', ['App\Controller\ProductoController', 'insertarProducto']);
    $r->addRoute('GET', '/productos/{id:\d+}/modificar', ['App\Controller\ProductoController', 'editarProducto']);
    $r->addRoute('POST', '/productos/{id:\d+}/modificar', ['App\Controller\ProductoController', 'modificarProducto']);
    $r->addRoute('GET', '/productos/{id:\d+}/eliminar', ['App\Controller\ProductoController', 'eliminarProducto']);

    // Rutas para Reportes
    $r->addRoute('GET', '/listaReportes/{pagina:\d+}', ['App\\Controller\\ReporteController', 'listarReportes']);

   
    });
    
?>