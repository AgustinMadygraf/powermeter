import pymysql

# Configuración de la conexión a la base de datos
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '12345678',
    'db': 'powermeter',
}

def update_histogram_table():
    try:
        # Conexión a la base de datos
        conn = pymysql.connect(**db_config)
        cursor = conn.cursor()

        # Consulta para obtener los datos agrupados de inst_bt_a1
        sql = "SELECT FLOOR(potencia_III / 20) * 20 AS potencia_w, COUNT(*) * 5 AS minutos FROM inst_bt_a1 GROUP BY FLOOR(potencia_III / 20)"
        cursor.execute(sql)
        result = cursor.fetchall()

        # Truncate de la tabla histograma_inst_bt_a1 antes de actualizarla
        sql_truncate = "TRUNCATE TABLE histograma_inst_bt_a1"
        cursor.execute(sql_truncate)

        # Insertar los nuevos datos en la tabla histograma_inst_bt_a1
        sql_insert = "INSERT INTO histograma_inst_bt_a1 (potencia_w, minutos) VALUES (%s, %s)"
        if result:
            cursor.executemany(sql_insert, result)

        # Confirmar los cambios en la base de datos y cerrar la conexión
        conn.commit()
        cursor.close()
        conn.close()
        print("Tabla histograma_inst_bt_a1 actualizada correctamente.")
    except pymysql.Error as e:
        print("Error en la conexión o consulta:", e)

if __name__ == "__main__":
    update_histogram_table()
