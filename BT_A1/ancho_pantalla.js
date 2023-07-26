// Función para obtener el ancho de la pantalla
function obtenerAnchoPantalla() {
    var ancho = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    return ancho;
  }
  
  // Función para actualizar el ancho de la pantalla en el elemento
  function actualizarAnchoPantalla() {
    var anchoPantalla = obtenerAnchoPantalla();
    var elementoAnchoPantalla = document.getElementById("anchoPantalla");
    elementoAnchoPantalla.innerHTML = "El ancho de la pantalla es: " + anchoPantalla + " píxeles";
  }
  
  // Llamamos a la función para que se ejecute por primera vez
  actualizarAnchoPantalla();
  
  // Actualizamos el ancho de pantalla cada 10 milisegundos)
  setInterval(actualizarAnchoPantalla, 10);