# cool_adapter.py
from chatterbot.logic import LogicAdapter

class MyCustomLogicAdapter(LogicAdapter):
    def __init__(self, chatbot, **kwargs):
        super().__init__(chatbot, **kwargs)

    def can_process(self, statement):
        """
        Define si el adaptador puede procesar el enunciado.
        Aquí puedes incluir lógica para filtrar solo las declaraciones
        relacionadas con ingeniería industrial.
        """
        # Por ejemplo, verifica si el enunciado tiene palabras clave de ingeniería
        # Esta es una lógica simplista, tendrías que expandirla
        words = ['proceso', 'sistema', 'operación', 'mantenimiento']
        if any(word in statement.text.split() for word in words):
            return True
        return False

    def process(self, input_statement, additional_response_selection_parameters):
        """
        Procesa el enunciado de entrada y genera una respuesta.
        Aquí puedes personalizar la lógica de respuesta.
        """
        from chatterbot.conversation import Statement
        import random

        # Por ahora, solo genera una confianza aleatoria y devuelve la entrada
        confidence = random.uniform(0, 1)
        response_statement = Statement(text='Vamos a discutir tu pregunta sobre ingeniería industrial.')
        response_statement.confidence = confidence

        return response_statement
