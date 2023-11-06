#ChatBot_OpenAI.py
print("Inicializando...")

import os
import openai

# Limpiar la pantalla de la terminal antes de comenzar (funciona en Windows).
os.system('cls' if os.name == 'nt' else 'clear')


# Función para obtener la API key de un archivo.
def get_api_key(file_path):
    print(f"Leyendo API key desde {file_path}...")
    with open(file_path, 'r') as file:
        return file.readline().strip()

api_key_path = "path_al_archivo_con_tu_clave.txt"
openai.api_key = get_api_key(api_key_path)

chat_history = []

while True:
    prompt = input("Enter a prompt: ")
    if prompt == "exit":
        break
    else:
        chat_history.append({"role": "user", "content": prompt})

        response_iterator = openai.ChatCompletion.create(
            model="gpt-3.5-turbo",
            messages = chat_history,
            stream=True,
        )

        collected_messages = []

        for chunk in response_iterator:
            chunk_message = chunk['choices'][0]['delta']  # extract the message
            collected_messages.append(chunk_message)  # save the message
            full_reply_content = ''.join([m.get('content', '') for m in collected_messages])
            print(full_reply_content)

            # clear the terminal
            print("\033[H\033[J", end="")

        chat_history.append({"role": "assistant", "content": full_reply_content})
        # print the time delay and text received
        full_reply_content = ''.join([m.get('content', '') for m in collected_messages])
        print(f"GPT: {full_reply_content}")