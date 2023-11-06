# gui.py
import tkinter as tk
from tkinter import simpledialog
import tkinter
from chatbot_mysql_setup import chatbot  


class ChatbotGUI:
    def __init__(self, master):
        self.master = master
        master.title("Asistente de Ingeniería Industrial - MadyBot")

        self.label = tk.Label(master, text="MadyBot: ¿En qué puedo ayudarte?")
        self.label.pack()

        self.conversation_frame = tk.Frame(master)
        self.conversation_frame.pack()

        self.text_scroll = tk.Scrollbar(self.conversation_frame)
        self.text_scroll.pack(side=tk.RIGHT, fill=tk.Y)

        self.conversation = tk.Text(self.conversation_frame, height=20, width=75, yscrollcommand=self.text_scroll.set)
        self.conversation.pack(side=tk.LEFT, fill=tk.BOTH)
        self.text_scroll.config(command=self.conversation.yview)

        self.user_input = tk.Entry(master)
        self.user_input.pack()

        self.send_button = tk.Button(master, text="Enviar", command=self.get_response)
        self.send_button.pack()

        self.master.bind('<Return>', self.get_response)

    def get_response(self, event=None):
        user_text = self.user_input.get()
        self.conversation.insert(tk.END, "Tú: " + user_text + "\n")

        if user_text:  # Verificar que 'user_input' no esté vacío.
            bot_response = chatbot.get_response(user_text)
        else:
            bot_response = chatbot.get_response("[null]")

        self.conversation.insert(tk.END, "MadyBot: " + str(bot_response) + "\n\n")
        self.user_input.delete(0, tk.END)

root = tk.Tk()
my_gui = ChatbotGUI(root)
root.mainloop()
