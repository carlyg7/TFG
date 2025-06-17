<?php
session_start();
require_once __DIR__ . '\conexion.php';
include "header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php?accion=login");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM historico WHERE user_id = ? ORDER BY fecha DESC");
$stmt->execute([$_SESSION['user_id']]);
$registros = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial</title>
</head>
<div class="container mt-4">
    <h2 class="text-center text-primary mb-4">Histórico de sesiones</h2>

    <?php if (empty($registros)): ?>
        <div class="alert alert-info">Aún no has registrado ninguna sesión.</div>
    <?php else: ?>
        <?php 
            $grupos_cluster = [
                0 => "Grupo 0: Usuarios intermedios y constantes",
                1 => "Grupo 1: Usuarios delgados con grasa elevada",
                2 => "Grupo 2: Usuarios con obesidad y baja frecuencia"
            ];

            foreach ($registros as $fila): ?>
            <?php $datos = json_decode($fila['datos_json'], true); ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                <?php
                    echo $fila['fecha'] . " — Predicción: Método " . $fila['escenario'];
                    if (!is_null($fila['cluster']) && $fila['escenario'] === 'A') {
                        echo " | " . $grupos_cluster[$fila['cluster']] ?? "Cluster " . $fila['cluster'];
                    }
                ?>
                </div>
                <div class="card-body">
                    <p><strong>Calorías estimadas:</strong> <?= round($fila['calorias'], 2) ?> kcal</p>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Edad:</strong> <?= $datos['edad'] ?></li>
                                <li class="list-group-item"><strong>Peso:</strong> <?= $datos['peso'] ?> kg</li>
                                <li class="list-group-item"><strong>Altura:</strong> <?= $datos['altura'] ?> m</li>
                                <li class="list-group-item"><strong>% Grasa:</strong> <?= $datos['grasa'] ?> %</li>
                                <li class="list-group-item"><strong>Experiencia:</strong> <?= $datos['experiencia'] ?></li>
                                <li class="list-group-item"><strong>Frecuencia:</strong> <?= $datos['frecuencia'] ?> días/sem</li>
                                <li class="list-group-item"><strong>Duración:</strong> <?= $datos['duracion'] ?> h</li>
                                <li class="list-group-item"><strong>Agua:</strong> <?= $datos['agua'] ?> L</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Max BPM:</strong> <?= $datos['max_bpm'] ?></li>
                                <li class="list-group-item"><strong>Avg BPM:</strong> <?= $datos['avg_bpm'] ?></li>
                                <li class="list-group-item"><strong>Resting BPM:</strong> <?= $datos['resting_bpm'] ?></li>
                                <li class="list-group-item"><strong>Cardio:</strong> <?= $datos['cardio'] ? 'Sí' : 'No' ?></li>
                                <li class="list-group-item"><strong>HIIT:</strong> <?= $datos['hiit'] ? 'Sí' : 'No' ?></li>
                                <li class="list-group-item"><strong>Strength:</strong> <?= $datos['strength'] ? 'Sí' : 'No' ?></li>
                                <li class="list-group-item"><strong>Yoga:</strong> <?= $datos['yoga'] ? 'Sí' : 'No' ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="text-center mt-3">
        <a href="index.php">↩️ Volver al formulario</a>
    </div>
</div>
