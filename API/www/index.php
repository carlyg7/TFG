<?php
// index.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Predicción de Calorías y Cluster</title>
  <!-- Bootstrap 5 CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f9f9f9;
      font-family: Arial, sans-serif;
      padding-top: 20px;
    }
    .form-container {
      background: #fff;
      padding: 20px 30px;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .form-header {
      text-align: center;
      margin-bottom: 25px;
    }
    .radio-inline-group .form-check {
      display: inline-block;
      margin-right: 15px;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="form-container">
      <h2 class="form-header text-primary fw-bold">Predicción de Calorías y Cluster</h2>
      <form action="predict.php" method="post">

        <!-- Dividimos en 3 columnas en pantallas md+ -->
        <div class="row g-4">

          <!-- ─────────────── Columna 1 ─────────────── -->
          <div class="col-md-4">
            <!-- Edad -->
            <div class="mb-3">
              <label for="age" class="form-label fw-bold">Edad (años):</label>
              <input type="number" class="form-control" id="age" name="age" min="18" max="100" step="1" required>
            </div>

            <!-- Peso -->
            <div class="mb-3">
              <label for="weight" class="form-label fw-bold">Peso (kg):</label>
              <input type="number" class="form-control" id="weight" name="weight" step="0.1" required>
            </div>

            <!-- Altura -->
            <div class="mb-3">
              <label for="height" class="form-label fw-bold">Altura (m):</label>
              <input type="number" class="form-control" id="height" name="height" step="0.01" required>
            </div>

            <!-- BMI -->
            <div class="mb-3">
              <label for="bmi" class="form-label fw-bold">BMI:</label>
              <input type="number" class="form-control" id="bmi" name="bmi" step="0.1" required>
            </div>
            <!-- % Grasa Corporal -->
            <div class="mb-3">
              <label for="fat_pct" class="form-label fw-bold">% Grasa Corporal:</label>
              <input type="number" class="form-control" id="fat_pct" name="fat_pct" step="0.1" required>
            </div>
            <!-- Nivel de Experiencia (SELECT) -->
            <div class="mb-3">
              <label for="experience" class="form-label fw-bold">Nivel de Experiencia:</label>
              <select class="form-select" id="experience" name="experience" required>
                <option value="" disabled selected>Selecciona nivel (1-5)</option>
                <option value="1">1 - Principiante</option>
                <option value="2">2 - Básico</option>
                <option value="3">3 - Intermedio</option>
                <option value="4">4 - Avanzado</option>
                <option value="5">5 - Experto</option>
              </select>
            </div>
          </div>
          <!-- ─────────────── Columna 2 ─────────────── -->
          <div class="col-md-4">
            <!-- Frecuencia de Entrenamiento (SELECT) -->
            <div class="mb-3">
              <label for="freq" class="form-label fw-bold">Frecuencia Entreno (días/sem):</label>
              <select class="form-select" id="freq" name="freq" required>
                <option value="" disabled selected>Selecciona (0-7)</option>
                <?php
                  for ($i = 0; $i <= 7; $i++) {
                    echo "<option value=\"$i\">$i días/semana</option>";
                  }
                ?>
              </select>
            </div>

            <!-- Max BPM -->
            <div class="mb-3">
              <label for="max_bpm" class="form-label fw-bold">Max BPM:</label>
              <input type="number" class="form-control" id="max_bpm" name="max_bpm" step="1" required>
            </div>

            <!-- Avg BPM -->
            <div class="mb-3">
              <label for="avg_bpm" class="form-label fw-bold">Avg BPM:</label>
              <input type="number" class="form-control" id="avg_bpm" name="avg_bpm" step="1" required>
            </div>

            <!-- Resting BPM -->
            <div class="mb-3">
              <label for="resting_bpm" class="form-label fw-bold">Resting BPM:</label>
              <input type="number" class="form-control" id="resting_bpm" name="resting_bpm" step="1" required>
            </div>

            <!-- Duración de la Sesión (SELECT) -->
            <div class="mb-3">
              <label for="duration" class="form-label fw-bold">Duración Sesión (horas):</label>
              <select class="form-select" id="duration" name="duration" required>
                <option value="" disabled selected>Selecciona duración</option>
                <option value="0.5">0.5 horas</option>
                <option value="1">1 hora</option>
                <option value="1.5">1.5 horas</option>
                <option value="2">2 horas</option>
                <option value="2.5">2.5 horas</option>
                <option value="3">3 horas</option>
              </select>
            </div>

            <!-- Ingesta de Agua -->
            <div class="mb-3">
              <label for="water" class="form-label fw-bold">Ingesta Agua (litros):</label>
              <input type="number" class="form-control" id="water" name="water" step="0.1" required>
            </div>
          </div>

          <!-- ─────────────── Columna 3 ─────────────── -->
          <div class="col-md-4">
            <label class="form-label fw-bold">Entrenamientos Realizados:</label>

            <!-- Cardio -->
            <div class="radio-inline-group mb-2">
              <span class="me-3">Cardio:</span>
              <br>
              <div class="form-check ">
                <input class="form-check-input" type="radio" name="cardio" id="cardio1" value="1" required>
                <label class="form-check-label" for="cardio1">Sí</label>
              </div>
              <div class="form-check ">
                <input class="form-check-input" type="radio" name="cardio" id="cardio0" value="0">
                <label class="form-check-label" for="cardio0">No</label>
              </div>
            </div>

            <!-- HIIT -->
            <div class="radio-inline-group mb-2">
              <span class="me-3">HIIT:</span>
              <br>
              <div class="form-check ">
                <input class="form-check-input" type="radio" name="hiit" id="hiit1" value="1" required>
                <label class="form-check-label" for="hiit1">Sí</label>
              </div>
              <div class="form-check ">
                <input class="form-check-input" type="radio" name="hiit" id="hiit0" value="0">
                <label class="form-check-label" for="hiit0">No</label>
              </div>
            </div>

            <!-- Strength -->
            <div class="radio-inline-group mb-2">
              <span class="me-3">Strength:</span>
              <br>
              <div class="form-check ">
                <input class="form-check-input" type="radio" name="strength" id="strength1" value="1" required>
                <label class="form-check-label" for="strength1">Sí</label>
              </div>
              <div class="form-check ">
                <input class="form-check-input" type="radio" name="strength" id="strength0" value="0">
                <label class="form-check-label" for="strength0">No</label>
              </div>
            </div>

            <!-- Yoga -->
            <div class="radio-inline-group mb-2">
              <span class="me-3">Yoga:</span>
              <br>
              <div class="form-check ">
                <input class="form-check-input" type="radio" name="yoga" id="yoga1" value="1" required>
                <label class="form-check-label" for="yoga1">Sí</label>
              </div>
              <div class="form-check ">
                <input class="form-check-input" type="radio" name="yoga" id="yoga0" value="0">
                <label class="form-check-label" for="yoga0">No</label>
              </div>
            </div>
          </div>
        </div> <!-- end row -->

        <!-- BOTÓN SUBMIT centrado -->
        <div class="row mt-2">
          <div class="col text-center">
            <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
          </div>
        </div>

      </form>
    </div> <!-- end form-container -->
  </div> <!-- end container -->

  <!-- Bootstrap 5 JS (CDN) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
