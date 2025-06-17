<?php
session_start();
include 'header.php';
$_SESSION['form_data'] = $_POST;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Seleccionar Escenario</title>
  <link rel="icon" href='data:image/svg+xml;utf8,
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
      <text y="0.9em" font-size="90">🏋️‍♀️</text>
    </svg>'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f9f9;
      font-family: Arial, sans-serif;
    }
    .card {
      max-width: 600px;
      margin: 0 auto;
      padding: 30px;
      border-radius: 8px;
    }
    .btn-lg {
      padding: 14px 20px;
      font-size: 1.2rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card shadow">
      <h2 class="text-center text-primary fw-bold mb-4">Selecciona el método de Predicción</h2>

      <form action="predict.php" method="post" class="d-grid gap-3">
        <input type="hidden" name="escenario" value="A">
        <button type="submit" class="btn btn-outline-dark btn-lg">⚫ Opción A: Solo variables físicas</button>
      </form>

      <form action="predict.php" method="post" class="d-grid gap-3 mt-2">
        <input type="hidden" name="escenario" value="B">
        <button type="submit" class="btn btn-outline-danger btn-lg">🔴 Opción B: Todas las variables</button>
      </form>

      <form action="predict.php" method="post" class="d-grid gap-3 mt-2">
        <input type="hidden" name="escenario" value="C">
        <button type="submit" class="btn btn-outline-success btn-lg">🟢 Opción C: Solo variables de entreno</button>
      </form>

      <div class="text-center mt-4">
        <a href="index.php" class="text-decoration-none">↩️ Volver al formulario</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
