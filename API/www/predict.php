<?php
session_start();
include 'header.php';
header('Content-Type: text/html; charset=UTF-8');

if (!isset($_SESSION['form_data'])) {
  echo "Error: No se han recibido datos del formulario.";
  exit;
}

$form = $_SESSION['form_data'];

// Recuperar escenario
$escenario = $_POST['escenario'] ?? 'A';

// Recoger datos
$age         = floatval($form['age']);
$weight      = floatval($form['weight']);
$height      = floatval($form['height']);
$bmi         = floatval($form['bmi']);
$fat_pct     = floatval($form['fat_pct']);
$experience  = floatval($form['experience']);
$freq        = floatval($form['freq']);

$max_bpm     = floatval($form['max_bpm']);
$avg_bpm     = floatval($form['avg_bpm']);
$resting_bpm = floatval($form['resting_bpm']);
$duration    = floatval($form['duration']);
$water       = floatval($form['water']);
$cardio      = intval($form['cardio']);
$hiit        = intval($form['hiit']);
$strength    = intval($form['strength']);
$yoga        = intval($form['yoga']);

// Ejecutar script Python
$python = 'C:\\Users\\carlo\\AppData\\Local\\Programs\\Python\\Python310\\python.exe';
$script = __DIR__ . '/../python_scripts/predict_session.py';

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

$cmd = "\"$python\" \"$script\" $args 2>&1";
$output = shell_exec($cmd);
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
    body { font-family: Arial, sans-serif; margin: 0; background: #f9f9f9; }
    h1 { text-align: center; }
    .result { max-width: 825px; margin: 20px auto; padding: 20px; background: #fff; border: 1px solid #ddd; border-radius: 4px; }
    .form-header { text-align: center; margin-bottom: 25px; }
    pre { white-space: pre-wrap; font-size: 1em; }
    a#enlace_form { display: block; margin-top: 20px; text-align: center; color: #007bff; text-decoration: none; }
    a#enlace_form:hover { text-decoration: underline; }
  </style>
</head>
<body>
<div class="container">
  <div class="form-container">
    <h2 class="form-header text-primary fw-bold">Resultado de Predicción</h2>
    <div class="result">
      <?php
        if ($escenario === 'A') {
          echo '<pre>' . htmlspecialchars($output) . '</pre>';
        } else {
          preg_match('/Calorías estimadas.+?: (.+)/', $output, $match);
          $solo_calorias = $match[0] ?? 'Calorías no disponibles.';
          echo '<pre>' . htmlspecialchars($solo_calorias) . '</pre>';
        }
      ?>
    </div>

    <h4 class="text-center text-primary">🏅 Tu sesión de entrenamiento 🏅</h4>
    <div class="mb-10">
      <div class="row">
        <div class="col-md-6">
          <table class="table table-striped">
            <tbody>
              <tr><th scope="row">Edad (años)</th><td><?= htmlspecialchars($age) ?></td></tr>
              <tr><th scope="row">Peso (kg)</th><td><?= htmlspecialchars($weight) ?></td></tr>
              <tr><th scope="row">Altura (m)</th><td><?= htmlspecialchars($height) ?></td></tr>
              <tr><th scope="row">BMI</th><td><?= htmlspecialchars($bmi) ?></td></tr>
              <tr><th scope="row">% Grasa Corporal</th><td><?= htmlspecialchars($fat_pct) ?></td></tr>
              <tr><th scope="row">Nivel de Experiencia</th><td><?= htmlspecialchars($experience) ?></td></tr>
              <tr><th scope="row">Frecuencia Entreno</th><td><?= htmlspecialchars($freq) ?></td></tr>
              <tr><th scope="row">Max BPM</th><td><?= htmlspecialchars($max_bpm) ?></td></tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-6">
          <table class="table table-striped">
            <tbody>
              <tr><th scope="row">Avg BPM</th><td><?= htmlspecialchars($avg_bpm) ?></td></tr>
              <tr><th scope="row">Resting BPM</th><td><?= htmlspecialchars($resting_bpm) ?></td></tr>
              <tr><th scope="row">Duración (h)</th><td><?= htmlspecialchars($duration) ?></td></tr>
              <tr><th scope="row">Agua (L)</th><td><?= htmlspecialchars($water) ?></td></tr>
              <tr><th scope="row">Cardio</th><td><?= ($cardio === 1) ? 'Sí' : 'No' ?></td></tr>
              <tr><th scope="row">HIIT</th><td><?= ($hiit === 1) ? 'Sí' : 'No' ?></td></tr>
              <tr><th scope="row">Strength</th><td><?= ($strength === 1) ? 'Sí' : 'No' ?></td></tr>
              <tr><th scope="row">Yoga</th><td><?= ($yoga === 1) ? 'Sí' : 'No' ?></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php if (isset($_SESSION['user_id'])): ?>
  <div class="text-center mt-3">
    <a href="historico.php" class="btn btn-outline-primary">📊 Ver historial de sesiones</a>
  </div>
<?php endif; ?>
    <a id="enlace_form" href="index.php">↩️ Volver al formulario</a> 
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// ─── GUARDAR HISTÓRICO ───
if (isset($_SESSION['user_id'])) {
    require_once "conexion.php";

    // Extraer calorías del resultado
    preg_match('/Calorías estimadas.+?: ([\d.]+)/', $output, $match);
    $calorias = isset($match[1]) ? floatval($match[1]) : null;

    // Extraer cluster si aplica
    $cluster = null;
    if ($escenario === 'A') {
        preg_match('/Grupo\s+(\d)/', $output, $grupo);
        $cluster = isset($grupo[1]) ? intval($grupo[1]) : null;
    }

    // Datos de entrada como JSON
    $datos = [
        'edad' => $age, 'peso' => $weight, 'altura' => $height,
        'bmi' => $bmi, 'grasa' => $fat_pct, 'experiencia' => $experience,
        'frecuencia' => $freq, 'max_bpm' => $max_bpm, 'avg_bpm' => $avg_bpm,
        'resting_bpm' => $resting_bpm, 'duracion' => $duration, 'agua' => $water,
        'cardio' => $cardio, 'hiit' => $hiit, 'strength' => $strength, 'yoga' => $yoga
    ];
    $json = json_encode($datos);

    if ($calorias !== null) {
        $stmt = $conn->prepare("INSERT INTO historico (user_id, escenario, cluster, calorias, datos_json) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user_id'],
            $escenario,
            $cluster,
            $calorias,
            $json
        ]);
    }
}
?>
