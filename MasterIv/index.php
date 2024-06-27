
<?php
  session_start();

  // Validamos si la sesión está activa
  if ($_SESSION['activo'] ?? false) {
    header("Location:panel.php");
    exit;
  }

  // Incluir la conexión
  require_once("Conexion/conexionsql.php");;

  if (isset($_POST["ingresar"])) {
    $email = $_POST["email"] ?? "";
    $pass = ($_POST["password"] ?? "");

    if ($email && $pass) {
      $query = "SELECT id, email, nombre, telefono, password, es_admin FROM Usuario 
                WHERE email=:email AND password=:password";

      $stmt = $conn->prepare($query);
      $stmt->execute([
        ":email" => $email,
        ":password" => $pass,
      ]);

      $registro = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$registro) {
        $error = "Error, acceso inválido";
      } else {
        // Aquí creamos sesiones
        $_SESSION['activo'] = true;
        $_SESSION['idUsuario'] = $registro['id'];
        $_SESSION['nombre'] = $registro['nombre'];
        $_SESSION['email'] = $registro['email'];
        $_SESSION['esAdmin'] = $registro['es_admin'];

        // Después de crear las sesiones, redirigimos al panel.php
        header("Location:panel.php");
        exit;
      }      
    } else {
      $error = "Error, algunos campos están vacíos";
    }
  }
?>


<!doctype html>
<html lang="es">
  <head>

    <meta charset="utf-8">

		
    <title>Citas Médicas UCE</title>

    <link rel="stylesheet" href="Estilos/loginst.css">
  </head>

<header>

<h3>WELCOME </h3>


</header>


  <body >

  <div class="error">
    
            <?php if(isset($error)) : ?>
              <div  role="alert">
                  <strong><?php echo $error; ?></strong> 
                  <button type="button" >
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          <?php endif; ?>      
    </div>
     

      <div class="login-container">

           <h2>Iniciar sesión</h2>

  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">

    <label for="username">Nombre de usuario</label>

    <input type="email" id="username" name="email" required placeholder="Ingrese su correo electrónico">

    <label for="password">Contraseña</label>

    <input type="password" id="password" name="password" required placeholder="Ingrese su contraseña">

    
             <button type="submit" name="ingresar">
              <i class="fas fa-user"></i> Ingresar
            </button>

  </form>
</div>

</body>
</html>