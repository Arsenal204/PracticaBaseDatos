<!DOCTYPE html>
<html lang="es">
    <?php 
    use App\utils\Utils;
    if(isset($_SESSION['user_id'])) Utils::redirect('/listaPaises/1');
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body{
            background-image: url("../img/fondo.jpg");
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="card align-self-center text-center border border-black" style="width: 18rem; margin: auto; margin-top: 10%;">
        <form method="POST" action="/" class="card-body">
            <h2 class="card-title">Iniciar Sesión</h2>
            <?php if (!empty($exito)) echo "<p style='color:green;'>$exito</p>"; ?>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <label for="correo" class="form-label card-text">Correo:</label>
            <input type="email" name="correo" id="correo" class="form-control border border-black" required>
            <br>
            <label for="contrasenia" class="form-label card-text">Contraseña:</label>
            <input type="password" name="contrasenia" id="contrasenia" class="form-control border border-black" required>
            <br>
            <button type="submit" class="btn btn-primary">Ingresar</button>
            <a href="/registro" class="btn btn-secondary">¿No tienes cuenta?</a>
        </form>
    </div>
</body>
</html>