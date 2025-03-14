<?php namespace App\Controller;

use App\Utils\Utils;
use App\Model\Model;
use App\Model\Usuario;
use PDO;

class UsuarioController
{
    /**
     * Funcion que carga el formulario de login
     * @return void (carga la vista)
     */
    public function cargarLogin() {
        Utils::render('login');
    }

    /**
     * Funcion que verifica que el usuario exista y si es correcto lo redirige a la pagina de organizaciones
     * @return void
     */
    public function login(){
        //Iniciamos la sesion
        session_start();
        //Nos conectamos a la bd
        $con = Utils::getConnection();

        //Guardamos los datos del formulario de login
        $correo = $_POST['correo'];
        $contrasenia = $_POST['contrasenia'];

        //Creamos el modelo y llamamos a la funcion para cargar el id y la contraseña del usuario
        $usuarioM = new Usuario($con);
        $usuario = $usuarioM->cargarUsuario($con, $correo);

        if ($usuario['validado'] == 0) { 
            $error = "Debes validar tu cuenta. Revisa tu correo.";
            Utils::render('login', compact('error'));
            return;
        }else{
            //Comprobamos si el miembro existe y si la contraseña es correcta
            if (!password_verify(trim($contrasenia), trim($usuario['contrasenia']))) {
                error_log("Error: La contraseña no coincide.");
                //Guardamos el id del miembro en la sesion
                $_SESSION['user_id'] = $usuario['id_usuario'];
                //Redirigimos a la pagina de organizaciones
                Utils::redirect('/listaPaises/1');
                exit;
            } else {
                //Si no existe o la contraseña es incorrecta mostramos un error y recargamos la vista
                $error = "Credenciales incorrectas";
                Utils::render('login', compact('error'));
            }
        }
        
    }

    /**
     * Funcion que carga el formulario de registro
     * @return void (carga la vista)
     */
    public function cargarRegistro()
    {
        //Cargamos la vista con los datos
        Utils::render('registro');
    }

    /**
     * Funcion que recibe los datos del formulario de registro y los inserta en la bd
     * @return void
     */
    public function registro() {
        //Nos conectamos a la bd
        $con = Utils::getConnection();

        //Creamos el modelo
        $usuarioM = new Usuario($con);

        //Guardamos los datos del formulario
        $usuario=$_POST;

        //Miramos si el email es valido
        if ($usuarioM->buscarEmail($con, $usuario["correo"])) {
            $error = "El correo ya esta registrado";
            Utils::render('registro', compact('error'));
            exit;
        }

        //Encriptamos la contraseña
        $usuario["contrasenia"] = password_hash($usuario["contrasenia"], PASSWORD_DEFAULT);

        // Generamos un código único de validación
        $usuario["codigovalidacion"] = bin2hex(random_bytes(16));
        
        // Inicializamos el usuario como no validado
        $usuario["validado"] = 0;

        // Enviar el correo de validación
        $usuarioM->enviarCorreoValidacion($usuario["correo"], $usuario["codigovalidacion"]);

        //Insertamos el miembro
        $usuario = $usuarioM->insertar($usuario);

        //Redirigimos a la pagina de validar
        Utils::redirect('/validar');
    }

    function validar() {
        Utils::render('validar');
    }

    function validate() {
        $con = Utils::getConnection();
    
        if (!isset($_GET["codigo"])) {
            $error = "No se recibió ningún código de validación.";
            Utils::render('registro', compact('error'));
            return;
        }
    
        $codigo = $_GET["codigo"];
        
        $usuarioM = new Usuario($con);
        $existe = $usuarioM->buscarCodigo($con, $codigo);
    
        if ($existe) {
            $usuarioM->validarUsuario($con, $codigo);
            $exito = "Cuenta validada con éxito.";
            Utils::render('login', compact('exito'));
        } else {
            $error = "Error: Código de validación inválido o ya utilizado.";
            Utils::render('registro', compact('error')); // Se pasa correctamente como array
        }
    }

    /**
     * Funcion que cierra la sesion
     * @return void (Redirige al login)
     */
    public function logout() {
        //Iniciamos la sesion
        session_start();
        //Destruimos la sesion
        session_unset();
        session_destroy();
        //Redirigimos al login
        Utils::redirect('/');
        exit;
    }

}
?>