#ChatExplorerBot.py
import asyncio
import telegram
import os

def limpiar_pantalla():
    os.system('cls' if os.name == 'nt' else 'clear')

async def main():
    token_telegram = os.getenv('telegram_token')
    bot = telegram.Bot(token_telegram)

    async with bot:
        historial = await bot.get_updates()

        # Usaremos un diccionario para mapear los números a los IDs de chat con nombres y usernames
        chat_info_dict = {}

        for update in historial:
            if update.message:
                chat_id = update.message.chat.id
                first_name = update.message.chat.first_name
                last_name = update.message.chat.last_name or ''  
                username = update.message.chat.username or 'Sin username'  
                chat_info_dict[chat_id] = f"{first_name} {last_name} @{username}".strip()

        print("Chats disponibles:")
        for num, (chat_id, info) in enumerate(chat_info_dict.items(), start=1):
            print(f"{num}: Chat ID {chat_id} - {info}")

        #seleccion = int(input("Elige un número para ver el historial del chat correspondiente: "))
        seleccion = 2

        # Obtener el ID de chat basado en la selección
        if 0 < seleccion <= len(chat_info_dict):
            selected_id = list(chat_info_dict.keys())[seleccion - 1]
            print(f"Usted seleccionó el chat con ID {selected_id}")

            for update in historial:
                if update.message and update.message.chat.id == selected_id:
                    text = update.message.text
                    first_name = update.message.chat.first_name
                    last_name = update.message.chat.last_name or ''
                    username = update.message.chat.username or 'Sin username'
                    print(f"{first_name} {last_name} @{username}: {text}")
            if selected_id is not None:
                # ... [resto del código] ...
                return selected_id  # Devolver el selected_id
            else:
                print("Selección inválida.")
                return None
        else:
            print("Selección inválida.")

if __name__ == '__main__':
    limpiar_pantalla()
    asyncio.run(main())
