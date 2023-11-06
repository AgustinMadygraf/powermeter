#ChatBot_OpenAI.py
import os
import openai
import consulta_MySQL

# Function to clear the terminal screen
def clear_screen():
    os.system('cls' if os.name == 'nt' else 'clear')

# Function to obtain the API key from a file
def get_api_key(file_path):
    try:
        with open(file_path, 'r') as file:
            return file.readline().strip()
    except IOError as e:
        print(f"Unable to read the API key file: {e}")
        exit(1)

# The main function to run the chatbot
def main(api_key_path="path_al_archivo_con_tu_clave.txt"):
    print("Inicializando...")
    prompt = "Hola Necesitos que me digas si la siguiente table es coherente"
    prompt = prompt+consulta_MySQL.main()
    clear_screen()

    openai.api_key = get_api_key(api_key_path)

    response = openai.ChatCompletion.create(
    model="gpt-3.5-turbo",
    messages = [
        {
            "role": "user",
            "content": prompt
        }
    ],)

  
    
    print(response['choices'][0]['message']['content'])
    

# Ensure that the main function is called only when the script is run directly
if __name__ == "__main__":
    main()
