<?php
// predict.php
header('Content-Type: text/html; charset=UTF-8');

// 1. Recoger datos POST y convertir a float/entero
$age         = floatval($_POST['age']);
$weight      = floatval($_POST['weight']);
$height      = floatval($_POST['height']);
$bmi         = floatval($_POST['bmi']);
$fat_pct     = floatval($_POST['fat_pct']);
$experience  = floatval($_POST['experience']);
$freq        = floatval($_POST['freq']);

$max_bpm     = floatval($_POST['max_bpm']);
$avg_bpm     = floatval($_POST['avg_bpm']);
$resting_bpm = floatval($_POST['resting_bpm']);
$duration    = floatval($_POST['duration']);
$water       = floatval($_POST['water']);
$cardio      = intval($_POST['cardio']);
$hiit        = intval($_POST['hiit']);
$strength    = intval($_POST['strength']);
$yoga        = intval($_POST['yoga']);

// 2. Construir la ruta al script Python
$python = 'C:\\Users\\carlo\\AppData\\Local\\Programs\\Python\\Python310\\python.exe';
$script = __DIR__ . '/../python_scripts/predict_session.py';

// 3. Preparar argumentos: concatenar en orden
$args = escapeshellarg($age) . ' '
      . escapeshellarg($weight) . ' '
      . escapeshellarg($height) . ' '
      . escapeshellarg($bmi) . ' '
      . escapeshellarg($fat_pct) . ' '
      . escapeshellarg($experience) . ' '
      . escapeshellarg($freq) . ' '
      . escapeshellarg($max_bpm) . ' '
      . escapeshellarg($avg_bpm) . ' '
      . escapeshellarg($resting_bpm) . ' '
      . escapeshellarg($duration) . ' '
      . escapeshellarg($water) . ' '
      . escapeshellarg($cardio) . ' '
      . escapeshellarg($hiit) . ' '
      . escapeshellarg($strength) . ' '
      . escapeshellarg($yoga);

// 4. Ejecutar el comando y capturar la salida
$cmd = "\"$python\" \"$script\" $args 2>&1";
$output = shell_exec($cmd);

// 5. Mostrar la respuesta formateada
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Resultado de Predicción</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; background: #f9f9f9; }
    h1 { text-align: center; }
    .result { 
      max-width: 825px; 
      margin: 20px auto; 
      padding: 20px; 
      background: #fff; 
      border: 1px solid #ddd; 
      border-radius: 4px; 
    }
    .form-header {
      text-align: center;
      margin-bottom: 25px;
    }
    pre { white-space: pre-wrap; font-size: 1em; }
    a { display: block; margin-top: 20px; text-align: center; color: #007bff; text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
<div class="container">
  <div class="form-container">
    <h2 class="form-header text-primary fw-bold">Resultado de Predicción</h2>
    <div class="result">
      <pre><?php echo htmlspecialchars($output); ?></pre>
    </div>
    <a href="index.php">&larr; Volver al formulario</a>
  </div>
</div>  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
