<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Empleados</title>
  <link rel="stylesheet" href="register_work.css">
</head>
<body>
  <div class="background">
    <div class="container">
      <div class="login-box">
        <div class="avatar">
          <img src="../imagenes/EasyLogo.png" alt="Logo">
        </div>
        <h1>Registro de Empleados</h1>
        <form id="register-form">
          <input
            type="text"
            id="identificacion"
            name="identificacion"
            placeholder="Identificación"
            required
          />
          <input
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Nombre"
            required
          />
          <input
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Apellido"
            required
          />
          <input
            type="text"
            id="direccion"
            name="direccion"
            placeholder="Dirección"
            required
          />
          <input
            type="text"
            id="telefono"
            name="telefono"
            placeholder="Teléfono"
            required
          />
          <input
            type="date"
            id="fecha_nacimiento"
            name="fecha_nacimiento"
            placeholder="Fecha de Nacimiento"
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
