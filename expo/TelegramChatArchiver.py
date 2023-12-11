#ChatCollectorBot      # ya no duplica pero sobre escribe en lugar de agregar
import asyncio
import telegram
import os
import json

def limpiar_pantalla():
    os.system('cls' if os.name == 'nt' else 'clear')

async def main():
    token_telegram = os.getenv('telegram_token')
    bot = telegram.Bot(token_telegram)

    async with bot:
        historial = await bot.get_updates()

        chat_histories = {}
        user_info = {}

        for update in historial:
            if update.message:
                chat_id = update.message.chat.id
                text = update.message.text
                update_id = update.update_id

                if chat_id not in chat_histories:
                    chat_histories[chat_id] = []

                chat_histories[chat_id].append({
                    "role": "user",
                    "content": text,
                    "update_id": update_id
                })

                user = update.message.from_user
                if user.id not in user_info:
                    user_info[user.id] = {
                        "username": user.username or 'Sin username',
                        "first_name": user.first_name,
                        "last_name": user.last_name or '',
                        "id": user.id
                    }

        data_to_save = {
            "chat_histories": chat_histories,
            "user_info": user_info
        }

        with open("context_window_telegram.json", "w", encoding="utf-8") as file:
            json.dump(data_to_save, file, indent=4, ensure_ascii=False)



if __name__ == '__main__':
    limpiar_pantalla()
    asyncio.run(main())
