print("Inicializando...")
import os
os.system('cls' if os.name == 'nt' else 'clear')
import openai



def obtener_api_key(file_path_API_key):
    try:
        print(f"Leyendo API key desde {file_path_API_key}...")
        with open(file_path_API_key, 'r') as file:
            return file.readline().strip()
    except FileNotFoundError:
        print(f"No se encontró el archivo: {file_path_API_key}. Por favor verifica la ruta.")
        print("Escribe 'exit' para salir o presiona cualquier tecla para continuar.")
        decision = input()
        return None if decision.lower() == 'exit' else "continuar"


api_key_path = "C://API_key.txt"
clave_api = obtener_api_key(api_key_path)
openai.api_key = clave_api

chat_history = [({"role": "user", "content": "Quiero que te comportes como un profesor de electrónica" })]






while True:
    prompt = input("Enter a prompt: ")
    if prompt == "exit":
        break
    else:
        chat_history.append({"role": "user", "content": prompt})

        try:
            response_iterator = openai.ChatCompletion.create(
                model="gpt-3.5-turbo",
                messages=chat_history,
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
        except openai.error.AuthenticationError as e:
            print("")
            print("Error de autenticación:")
            print(e)
            print("Por favor verifica que tu API key sea válida")
            print("")