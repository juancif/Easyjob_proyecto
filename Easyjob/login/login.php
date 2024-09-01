<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="background">
    <div class="container">
      <div class="login-box">
        <div class="avatar">
          <img src="../imagenes/EasyLogo.png" alt="Lock Icon">
        </div>
        <h1>Ingreso</h1>
        <form id="login-form">
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Correo Electrónico"
            required
          />
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Contraseña"
            required
          />
          <button type="button" onclick="handleLogin()">Ingresar</button>
        </form>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
