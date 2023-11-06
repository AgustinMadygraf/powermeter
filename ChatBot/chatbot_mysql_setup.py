#chatbot_mysql_setup.py
print("Inicializando..")
import os
from chatterbot import ChatBot
import training_chatbot
from cool_adapter import MyCustomLogicAdapter



chatbot = ChatBot(
                        'MadyBot',                                                                  #Nombre del ChatBot
    storage_adapter =   'chatterbot.storage.SQLStorageAdapter',                                     #determina cómo y dónde se almacenará la información que el chatbot necesita para operar
    database_uri    =   'mysql+mysqlconnector://root:12345678@localhost:3306/chatterbotdatabase',   #especifica la Uniform Resource Identifier (URI) que se utiliza para conectarse a la base de datos que el chatbot usará para almacenar y recuperar información.
    logic_adapters  =[                                                                             #lista de adaptadores de lógica que el bot puede usar para determinar cómo responder a una entrada dada
                    {   'import_path': 'chatterbot.logic.BestMatch'},
                    {   'import_path': 'chatterbot.logic.SpecificResponseAdapter', 
                        'input_text': 'Help me!',
                        'output_text': 'Ok, here is a link: http://chatterbot.rtfd.org'
                    }
    ]
)                                          
    

os.system('cls')
#print("MadyBot: ¿En qué puedo ayudarte?")
#while True:
#    try:
#        user_input = input("Usuario: ")
#
#        if user_input:  # Verificar que 'user_input' no esté vacío.
#            bot_response = chatbot.get_response(user_input)  # Obtener la respuesta del bot.
#        else:
#            bot_response = chatbot.get_response("[null]")  # Obtener la respuesta del bot.
#       
#        print(F"Madybot: {bot_response}")  # Imprimir la respuesta.


    # Press ctrl-c or ctrl-d on the keyboard to exit
#    except (KeyboardInterrupt, EOFError, SystemExit):
#        break