#data_validator.py

# Función para validar los datos de una fila
def validate_row(data):
    """
    Valida los datos de una fila según las reglas específicas del archivo CSV.

    Args:
        data (dict): Un diccionario que representa una fila de datos con nombres de columna y valores.

    Returns:
        bool: True si los datos son válidos, False en caso contrario.
    """
    required_columns = ['timestamp', 'R:v', 'S:v', 'T:v', 'R:p', 'S:p', 'T:p']

    for column in required_columns:
        if column not in data:
            return False

        # Verificar que los datos sean numéricos
        try:
            float(data[column])
        except ValueError:
            return False

    # Si pasa todas las validaciones, los datos son válidos
    return True

# Ejemplo de uso
if __name__ == "__main__":
    # Ejemplo de una fila de datos que coincide con los nombres de columna en tu archivo CSV
    data = {
        'timestamp': '1234567890',
        'R:v': '10.5',
        'S:v': '20.3',
        'T:v': '15.7',
        'R:p': '220',
        'S:p': '220',
        'T:p': '220'
    }

    if validate_row(data):
        print("Los datos son válidos.")
    else:
        print("Los datos son inválidos.")




