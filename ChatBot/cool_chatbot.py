# cool_chatbot.py
from chatterbot import ChatBot
from cool_adapter import MyCustomLogicAdapter
import training_chatbot

# Crear una nueva instancia del ChatBot
chatbot = ChatBot(
    'IndustrialAssistant',
    storage_adapter =   'chatterbot.storage.SQLStorageAdapter',                                     #determina cómo y dónde se almacenará la información que el chatbot necesita para operar
    database_uri    =   'mysql+mysqlconnector://root:12345678@localhost:3306/chatterbotdatabase',   #especifica la Uniform Resource Identifier (URI) que se utiliza para conectarse a la base de datos que el chatbot usará para almacenar y recuperar información.
    logic_adapters=[
        {
            'import_path': 'chatterbot.logic.BestMatch',
            'default_response': 'Lo siento, pero no entiendo.',
            'maximum_similarity_threshold': 0.90
        },
        # Aquí puedes agregar otros adaptadores lógicos personalizados más adelante
         #'import_path': 'cool_adapter.MyLogicAdapter',
    ]
)

# Entrenar al chatbot con datos de ingeniería industrial

# Aquí deberías entrenarlo con archivos de corpus específicos de ingeniería industrial si los tienes
# trainer.train('data/industrial_engineering_corpus.json')

# Función para obtener una respuesta del chatbot para su uso en la interfaz web
def get_bot_response(user_input):
    return chatbot.get_response(user_input)

# Esta función se conectará a tu interfaz web
