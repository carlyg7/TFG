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
  <link rel="icon" href='data:image/svg+xml;utf8,
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
      <text y="0.9em" font-size="90">🏋️‍♀️</text>
    </svg>'>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f9f9f9; }
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
    <h4 class="text-center text-primary">🏅 Tu sesión de entrenamiento 🏅</h4>
    <!-- Zona con la tabla de valores ingresados -->
    <div class="mb-10">
      <div class="row">
        <!-- Primera columna -->
        <div class="col-md-6">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th scope="row">Edad (años)</th>
                <td><?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
              <tr>
                <th scope="row">Peso (kg)</th>
                <td><?php echo htmlspecialchars($weight, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
              <tr>
                <th scope="row">Altura (m)</th>
                <td><?php echo htmlspecialchars($height, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
              <tr>
                <th scope="row">BMI</th>
                <td><?php echo htmlspecialchars($bmi, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
              <tr>
                <th scope="row">% Grasa Corporal</th>
                <td><?php echo htmlspecialchars($fat_pct, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
              <tr>
                <th scope="row">Nivel de Experiencia</th>
                <td><?php echo htmlspecialchars($experience, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
              <tr>
                <th scope="row">Frecuencia Entreno (días/sem)</th>
                <td><?php echo htmlspecialchars($freq, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
              <tr>
                <th scope="row">Max BPM</th>
                <td><?php echo htmlspecialchars($max_bpm, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Segunda columna -->
        <div class="col-md-6">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th scope="row">Avg BPM</th>
                <td><?php echo htmlspecialchars($avg_bpm, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
              <tr>
                <th scope="row">Resting BPM</th>
                <td><?php echo htmlspecialchars($resting_bpm, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
              <tr>
                <th scope="row">Duración Sesión (horas)</th>
                <td><?php echo htmlspecialchars($duration, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
              <tr>
                <th scope="row">Ingesta Agua (litros)</th>
                <td><?php echo htmlspecialchars($water, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
              <tr>
                <th scope="row">Entrenamiento Cardio</th>
                <td><?php echo ($cardio === 1) ? 'Sí' : 'No'; ?></td>
              </tr>
              <tr>
                <th scope="row">Entrenamiento HIIT</th>
                <td><?php echo ($hiit === 1) ? 'Sí' : 'No'; ?></td>
              </tr>
              <tr>
                <th scope="row">Entrenamiento Strength</th>
                <td><?php echo ($strength === 1) ? 'Sí' : 'No'; ?></td>
              </tr>
              <tr>
                <th scope="row">Entrenamiento Yoga</th>
                <td><?php echo ($yoga === 1) ? 'Sí' : 'No'; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Enlace para volver al formulario -->
    <a href="index.php">↩️ Volver al formulario</a> 
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
