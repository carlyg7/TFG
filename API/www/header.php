<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<!-- Bootstrap CSS (si no está ya incluido en tu layout principal) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" href='data:image/svg+xml;utf8,
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
      <text y="0.9em" font-size="90">🏋️‍♀️</text>
    </svg>'>
<style>
    body {
        margin: 0;
        padding: 0;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-2">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-white" href="index.php">🏋️‍♀️ FitPredictor</a>
    <div class="d-flex ms-auto">
      <?php if (isset($_SESSION['username'])): ?>
        <span class="text-white me-3">👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="auth.php?accion=logout" class="text-white text-decoration-none ms-3">🚪Cerrar sesión</a>
        <?php else: ?>
        <a href="auth.php?accion=login" class="text-white text-decoration-none">👤 Iniciar sesión</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
