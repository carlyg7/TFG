#!/usr/bin/env python3
# predict_session.py

import sys
import os
import numpy as np
import joblib
import warnings

# ───────────────────────────────────────────────────────────────
# Forzar a que stdout use UTF-8 en lugar de cp1252 u otro encoding
import sys
sys.stdout.reconfigure(encoding='utf-8')
# ───────────────────────────────────────────────────────────────

def main(args):
    # 1. Verificar que recibimos 16 argumentos
    if len(args) != 16:
        print(f"Error: Se esperaban 16 argumentos, pero se recibieron {len(args)}.")
        print("Formato: age weight height bmi fat_pct experience freq max_bpm avg_bpm resting_bpm duration water cardio hiit strength yoga")
        sys.exit(1)

    # 2. Convertir argumentos a float
    try:
        age, weight, height, bmi, fat_pct, experience, freq, \
        max_bpm, avg_bpm, resting_bpm, duration, water, \
        cardio, hiit, strength, yoga = map(float, args)
    except ValueError:
        print("Error: Todos los argumentos deben ser números (float).")
        sys.exit(1)

    # 3. Definir rutas a los modelos
    base_dir = os.path.dirname(os.path.abspath(__file__))  # .../TFG/API/python_scripts
    models_dir = os.path.join(base_dir, "../models")

    scaler_cluster_path = os.path.join(models_dir, "scaler_cluster.pkl")
    kmeans_model_path   = os.path.join(models_dir, "kmeans_model.pkl")
    scaler_global_path  = os.path.join(models_dir, "scaler_global.pkl")
    gb_global_path      = os.path.join(models_dir, "gb_global.pkl")

    # 4. Cargar scaler y modelo de clustering (Escenario A)
    try:
        scaler_cluster = joblib.load(scaler_cluster_path)
        kmeans_model   = joblib.load(kmeans_model_path)
    except FileNotFoundError as e:
        print(f"Error: No se encontró un archivo de modelo de clustering. Detalles: {e}")
        sys.exit(1)

    # 5. Preparar vector de variables físicas y escalar, suprimiendo warnings de feature names
    physical_feats = np.array([[age, weight, height, bmi, fat_pct, experience, freq]])
    with warnings.catch_warnings():
        warnings.simplefilter("ignore", category=UserWarning)
        physical_scaled = scaler_cluster.transform(physical_feats)
    cluster_label = kmeans_model.predict(physical_scaled)[0]

    # Mapa de etiquetas Perfil grupo
    perfiles = {
        0: "0. Atletas avanzados de alto volumen:",
        1: "1. Principiantes de bajo volumen y enfoque general:",
        2: "2. Intermedios con énfasis en fuerza y equilibrio:",
        3: "3. Principiantes-Intermedios enfocados en la pérdida de peso:"
    }
    perfil_texto = perfiles.get(cluster_label, f"Cluster desconocido ({cluster_label})")

    # Mapa de etiquetas a descripciones del grupo
    perfiles2 = {
        0: "Al combinar un nivel de experiencia alto con sesiones prolongadas y frecuencia semanal muy elevada, este grupo entrena con gran volumen e intensidad.",
        1: "Al tratarse de usuarios con poca experiencia, baja frecuencia y sesiones cortas, con un enfoque más general (mezclan cardio y fuerza).",
        2: "Su experiencia intermedia y la alta proporción de entrenamiento, junto con frecuencia moderada, sugieren un grupo con base de fuerza y trabajo de flexibilidad/equilibrio.",
        3: "Al ser usuarios con sobrepeso/obesidad, experiencia limitada y con el objetivo principal de pérdida de peso."
    }
    perfil_desc = perfiles2.get(cluster_label, f"Cluster desconocido ({cluster_label})")

    # 6. Cargar scaler y modelo global (Escenario B)
    try:
        scaler_global = joblib.load(scaler_global_path)
        gb_global     = joblib.load(gb_global_path)
    except FileNotFoundError as e:
        print(f"Error: No se encontró un archivo de modelo global. Detalles: {e}")
        sys.exit(1)

    # 7. Preparar vector de todas las características y escalar, suprimiendo warnings
    all_feats = np.array([[age, weight, height, max_bpm, avg_bpm,
                           resting_bpm, duration, fat_pct,
                           water, freq, experience, bmi,
                           cardio, hiit, strength, yoga]])
    with warnings.catch_warnings():
        warnings.simplefilter("ignore", category=UserWarning)
        all_scaled = scaler_global.transform(all_feats)
    pred_calories = gb_global.predict(all_scaled)[0]

    # 8. Imprimir resultados formateados
    print(f"Grupo {perfil_texto}")
    print(f"{perfil_desc}")
    print(f"\nCalorías estimadas según tu sesión de entreno: {pred_calories:.2f}")

if __name__ == "__main__":
    main(sys.argv[1:])
