import pandas as pd
import mysql.connector
from sqlalchemy import create_engine

# Reemplaza 'username', 'password', 'host' y 'database' con tus propios detalles de la base de datos MySQL
username = 'root'
password = '12345678'
host = 'localhost'
database = 'novus'

# Crea una conexión a la base de datos
engine = create_engine(f'mysql+mysqlconnector://{username}:{password}@{host}/{database}')

# Consulta SQL para obtener la descripción de la tabla
describe_table_query = "DESCRIBE `maq_bolsas`"

# Ejecuta la consulta y guarda el resultado en un DataFrame de pandas
df = pd.read_sql(describe_table_query, engine)

# Exporta el DataFrame a un archivo CSV
csv_file_path = 'maq_bolsas.csv'
df.to_csv(csv_file_path, index=False)

print(f"La descripción de la tabla ha sido guardada en '{csv_file_path}'")
