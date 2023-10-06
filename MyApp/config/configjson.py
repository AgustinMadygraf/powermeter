#config.py
import json
import os


def load_config(script_directory):
    config_directory = os.path.abspath(os.path.join(script_directory, '../config'))
    config_file_path = os.path.join(config_directory, 'config.json')
    print("Config File Path:", config_file_path)

    try:
        with open(config_file_path, 'r') as config_file:
            config_data = json.load(config_file)
            return config_data
    except (FileNotFoundError, json.JSONDecodeError):
        return None
