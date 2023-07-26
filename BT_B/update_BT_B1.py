import requests

url = 'http://localhost/mediciones/scada/update_BT_B1.php'
response = requests.get(url)

print(response.text)
input("presione una tecla para salir")
