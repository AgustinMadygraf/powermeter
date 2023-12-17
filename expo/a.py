import openai
import requests
from io import BytesIO
import telegram
import os
import asyncio

async def generate_and_send_image(prompt):
    # Configurar la API de OpenAI
    openai.api_key = os.getenv('OPENAI_API_KEY')
    

    # Solicitar la generación de la imagen
    response = openai.Image.create(
        model="dall-e-3",
        prompt=prompt,
        size="1024x1024",
        quality="standard",
        n=1
    )

    # Obtener la URL de la imagen
    image_url = response.data[0].url

    # Descargar la imagen
    response = requests.get(image_url)
    image = BytesIO(response.content)

    # Enviar la imagen a través de Telegram
    token_telegram = os.getenv('telegram_token')
    chat_id = '593052206'
    bot = telegram.Bot(token_telegram)
    await bot.send_photo(chat_id=chat_id, photo=image)

if __name__ == "__main__":
    # Usar asyncio.run() para iniciar la función asíncrona
    asyncio.run(generate_and_send_image("un gatito feliz"))