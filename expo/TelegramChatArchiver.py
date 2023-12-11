#TelegramChatArchiver.py
import asyncio
import telegram
import os
import json
import time

def limpiar_pantalla():
    os.system('cls' if os.name == 'nt' else 'clear')

async def main():
    print("Hola mundo")
    time.sleep(5)
    token_telegram = os.getenv('telegram_token')
    bot = telegram.Bot(token_telegram)

    async with bot:
        historial = await bot.get_updates()

        # Diccionario para almacenar el historial de cada chat
        chat_histories = {}
        user_info = {}

        for update in historial:
            if update.message:
                chat_id = update.message.chat.id
                text = update.message.text

                # Crear una nueva entrada en el diccionario si no existe
                if chat_id not in chat_histories:
                    chat_histories[chat_id] = []

                # Agregar el mensaje al historial del chat
                chat_histories[chat_id].append({
                    "role": "user",
                    "content": text
                })

                # Recolectar la información del usuario
                user = update.message.from_user
                if user.id not in user_info:
                    user_info[user.id] = {
                        "username": user.username or 'Sin username',
                        "first_name": user.first_name,
                        "last_name": user.last_name or '',
                        "id": user.id
                    }

        # Guardar el historial de cada chat y la información del usuario en un archivo JSON
        data_to_save = {
            "user_info": user_info,
            "chat_histories": chat_histories
        }

        with open("context_window_telegram.json", "w", encoding="utf-8") as file:
            json.dump(data_to_save, file, indent=4, ensure_ascii=False)

if __name__ == '__main__':
    limpiar_pantalla()
    asyncio.run(main())
