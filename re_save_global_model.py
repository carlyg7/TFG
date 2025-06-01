# re_save_cluster_models.py

import os
import joblib

# 1) Rutas a los .pkl originales (generados con sklearn 1.3.0)
orig_scaler_path = 'API/models/scaler_cluster.pkl'
orig_kmeans_path = 'API/models/kmeans_model.pkl'

# 2) Cargamos los objetos (seirializados con sklearn 1.3.0)
scaler_cluster = joblib.load(orig_scaler_path)
kmeans_model   = joblib.load(orig_kmeans_path)

# 3) Creamos la carpeta de salida por si no existe
os.makedirs('API/models', exist_ok=True)

# 4) Re‐guardamos los mismos objetos, ahora usando sklearn 1.6.1
joblib.dump(scaler_cluster, 'API/models/scaler_cluster.pkl')
joblib.dump(kmeans_model,   'API/models/kmeans_model.pkl')

print("→ scaler_cluster.pkl y kmeans_model.pkl re‐serializados con sklearn 1.6.1")
