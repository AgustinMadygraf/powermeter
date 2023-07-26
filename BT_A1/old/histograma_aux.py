import pymysql

# Configuración de la conexión a la base de datos
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '12345678',
    'db': 'powermeter',
}

def check_and_insert_histogram_data():
    try:
        # Conexión a la base de datos
        conn = pymysql.connect(**db_config)
        cursor = conn.cursor()

        # Consulta para obtener los valores mínimos y máximos de potencia_w
        sql_min_max = "SELECT MIN(potencia_w), MAX(potencia_w) FROM histograma_inst_bt_a1"
        cursor.execute(sql_min_max)
        min_max_data = cursor.fetchone()
        min_potencia_w, max_potencia_w = min_max_data if min_max_data else (0, 0)

        # Calcular los intervalos de 20 en 20 desde el mínimo hasta el máximo
        potencia_w_values = list(range(int(min_potencia_w), int(max_potencia_w) + 1, 20))

        # Consulta para obtener los valores de potencia_w ya existentes en la tabla
        sql_existing_potencia_w = "SELECT DISTINCT potencia_w FROM histograma_inst_bt_a1"
        cursor.execute(sql_existing_potencia_w)
        existing_potencia_w = [row[0] for row in cursor.fetchall()]

        # Filtrar los valores de potencia_w que no existen en la tabla
        missing_potencia_w_values = [value for value in potencia_w_values if value not in existing_potencia_w]

        # Insertar las filas faltantes con minutos = 0
        if missing_potencia_w_values:
            sql_insert_missing = "INSERT INTO histograma_inst_bt_a1 (potencia_w, minutos) VALUES (%s, 0)"
            data_to_insert = [(value,) for value in missing_potencia_w_values]
            cursor.executemany(sql_insert_missing, data_to_insert)
            conn.commit()
            print("Se han insertado las filas faltantes con minutos = 0")

        # Cerrar la conexión a la base de datos
        cursor.close()
        conn.close()

    except pymysql.Error as e:
        print("Error en la conexión o consulta:", e)

if __name__ == "__main__":
    check_and_insert_histogram_data()
