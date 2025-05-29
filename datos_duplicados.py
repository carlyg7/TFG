import pandas as pd

# Cargar el dataset
df = pd.read_csv('archivo_gym_members_exercise_tracking_version2.csv')

# Verificar número de filas originales
print(f"Filas originales: {df.shape[0]}")

# Identificar duplicados exactos en todas las columnas
df_sin_duplicados = df.drop_duplicates(keep='first')

# Verificar número de filas finales
print(f"Filas tras eliminar duplicados exactos: {df_sin_duplicados.shape[0]}")

# Ver ejemplos eliminados (opcional)
duplicados = df[df.duplicated(keep=False)]
print("\nEjemplos de sesiones duplicadas:")
print(duplicados.head())

# Guardar el nuevo dataset si quieres
# df_sin_duplicados.to_csv('dataset_sin_sesiones_duplicadas.csv', index=False)
