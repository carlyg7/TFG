import pandas as pd

# Cargar el dataset
file_path = 'gym_members_exercise_tracking.csv'  # Cambia esto por la ruta de tu archivo
df = pd.read_csv(file_path)

#Tipos de entrenamiento
print(df['Workout_Type'].value_counts())

# Añadir una columna ID única
df['id'] = df.index + 1

# Reordenar las columnas para que 'id' sea la primera
df = df[['id'] + [col for col in df.columns if col != 'id']]

# Convertir el género de string a int (0 o 1) Masculino 1 | Femenino 0
df['Gender'] = df['Gender'].apply(lambda x: 1 if x.lower() == 'male' else 0)

# Aplicar One Hot Encoding a 'Workout_Type' y pasarlo a binario 0 y 1
dummies = pd.get_dummies(df['Workout_Type'], prefix='Workout', dtype=int, drop_first=False)

# Concatenar las nuevas columnas y eliminar la columna original
df = pd.concat([df.drop(columns=['Workout_Type']), dummies], axis=1)







# Guardar el dataframe modificado en un nuevo archivo CSV
df.to_csv('archivo_gym_members_exercise_tracking_version2.csv', index=False)
