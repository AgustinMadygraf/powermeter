import json

def load_config():
    config_file_path = "C:/config_python/config.json"  # Ruta al archivo config.json
    print("Config File Path:", config_file_path)

    try:
        with open(config_file_path, 'r') as config_file:
            config_data = json.load(config_file)
            return config_data
    except (FileNotFoundError, json.JSONDecodeError):
        return None
