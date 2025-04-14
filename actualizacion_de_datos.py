import pandas as pd

# Cargar el dataset
file_path = 'gym_members_exercise_tracking.xlsx'  # Cambia esto por la ruta de tu archivo
df = pd.read_csv(file_path)

# Añadir una columna ID única
df['id'] = df.index + 1

# Convertir el género de string a int (0 o 1)
df['Gender'] = df['Gender'].apply(lambda x: 1 if x.lower() == 'male' else 0)

# Reordenar las columnas para que 'id' sea la primera
df = df[['id'] + [col for col in df.columns if col != 'id']]

# Guardar el dataframe modificado en un nuevo archivo CSV
df.to_csv('archivo_gym_members_exercise_tracking_version1.csv', index=False)

# Mostrar el dataframe (opcional)
print(df)
