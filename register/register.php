<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Clientes</title>
  <link rel="stylesheet" href="register.css">
</head>
<body>
  <div class="background">
    <div class="container">
      <div class="login-box">
        <div class="avatar">
          <img src="../imagenes/EasyLogo.png" alt="Logo">
        </div>
        <h1>Registro de Clientes</h1>
        <form id="registration-form">
          <input
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Nombre"
            required
          />
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Correo Electrónico"
            required
          />
          <input
            type="tel"
            id="celular"
            name="celular"
            placeholder="Celular"
            pattern="[0-9]{10}"
            required
          />
          <input
            type="password"
            id="contrasena"
            name="contrasena"
            placeholder="Contraseña"
            required
          />
          <button type="button"><a href="http://localhost/Easyjob_proyecto/Easyjob/index.html">Registrar</button>
          <button type="button"><a href="http://localhost/Easyjob_proyecto/Easyjob/login/login.php">Ir al Inicio de Sesión</a></button>
        </form>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
