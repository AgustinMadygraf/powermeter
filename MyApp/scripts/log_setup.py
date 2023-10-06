#log_setup.py
import logging
import os

log_directory = "logs"

if not os.path.exists(log_directory):
    os.makedirs(log_directory)

log_file = os.path.join(log_directory, "myapp.log")
logging.basicConfig(filename=log_file, level=logging.INFO, format="%(asctime)s - %(levelname)s - %(message)s")

try:
    # Código que puede generar una excepción
    result = 1 / 0
except Exception as e:
    logging.exception("Excepción capturada: %s", str(e))
