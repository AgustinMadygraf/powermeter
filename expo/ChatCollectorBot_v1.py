import asyncio
import telegram
import os
from tabulate import tabulate

def limpiar_pantalla():
    os.system('cls' if os.name == 'nt' else 'clear')

async def main():
    token_telegram = os.getenv('telegram_token')
    bot = telegram.Bot(token_telegram)

    async with bot:
        historial = await bot.get_updates()

        # Diccionario para almacenar la información de los chats
        chat_info_dict = {}

        for update in historial:
            if update.message:
                chat_id = update.message.chat.id
                first_name = update.message.chat.first_name
                last_name = update.message.chat.last_name or ''
                username = update.message.chat.username or 'Sin username'
                # Almacenar la información del chat solo si no está ya en el diccionario
                if chat_id not in chat_info_dict:
                    chat_info_dict[chat_id] = [first_name, last_name, username]

        # Lista para la tabla
        chat_info_list = [[num, chat_id] + info for num, (chat_id, info) in enumerate(chat_info_dict.items(), start=1)]

        # Mostrar la tabla de chats
        print(tabulate(chat_info_list, headers=["#", "Chat ID", "Nombre", "Username"], tablefmt="grid"))

        seleccion = int(input("Elige el número para ver el historial del chat correspondiente: "))

        # Buscar el ID de chat basado en la selección
        if 0 < seleccion <= len(chat_info_list):
            selected_id, first_name, last_name, username = chat_info_list[seleccion - 1][1:]
            print(f"Usted seleccionó el chat {selected_id} que corresponde a {first_name} {last_name}, @{username}")
            print("")
            for update in historial:
                if update.message and update.message.chat.id == selected_id:
                    text = update.message.text
                    print(f"{first_name} {last_name} @{username}: {text}")
        else:
            print("Selección inválida.")

if __name__ == '__main__':
    limpiar_pantalla()
    asyncio.run(main())
