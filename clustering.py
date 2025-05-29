'''
Paso 1: Preparar los datos para clustering

Seleccionar solo las variables propuestas.

Escalar las variables numéricas para que todas tengan igual peso (usaremos StandardScaler).

Comprobar que los datos estén limpios (sin nulos).
'''

from sklearn.preprocessing import StandardScaler
import pandas as pd

# Cargar el dataset
dataset = pd.read_csv('archivo_gym_members_exercise_tracking_version2.csv')

# Selección variables
vars_cluster = [
    'Age',
    'Gender',
    'Weight (kg)',
    'Height (m)',
    'BMI',
    'Fat_Percentage',
    'Experience_Level',
    'Workout_Frequency (days/week)'
]

df_cluster = dataset[vars_cluster].copy()

# Escalado (salvo Gender que es binaria)
scaler = StandardScaler()
cols_to_scale = ['Age', 'Weight (kg)', 'Height (m)', 'BMI', 'Fat_Percentage', 'Experience_Level', 'Workout_Frequency (days/week)']

df_cluster[cols_to_scale] = scaler.fit_transform(df_cluster[cols_to_scale])



''' Paso 2: Aplicar clustering KMeans con k=4 '''
from sklearn.cluster import KMeans

kmeans = KMeans(n_clusters=4, random_state=42)
df_cluster['cluster'] = kmeans.fit_predict(df_cluster)



'''
Paso 3: Analizar cada cluster

Ver la cantidad de usuarios en cada cluster.

Calcular las medias de cada variable por cluster para interpretar perfiles.

Visualizar resultados con boxplots o gráficos de radar.
'''

print(df_cluster['cluster'].value_counts())

cluster_means = df_cluster.groupby('cluster').mean()
print(cluster_means)



'''Paso 4: Visualización sencilla'''

import seaborn as sns
import matplotlib.pyplot as plt

# Ejemplo: Boxplot de peso por cluster
sns.boxplot(x='cluster', y='Weight (kg)', data=df_cluster)
plt.title('Distribución del peso por cluster')
plt.show()
