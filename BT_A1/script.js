$(function() {
  // Función para actualizar la celda con la fecha y hora actual
  function updateCurrentDateTime() {
    var currentDateTimeCell = document.getElementById("currentDateTime");
    var now = new Date();
    var formattedDateTime = now.toLocaleString("es-AR", {
      day: "numeric",
      month: "numeric",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit",
      second: "2-digit"
    });
    currentDateTimeCell.innerHTML = formattedDateTime;
  }

  // Actualizar cada 1 segundo (1000 milisegundos)
  setInterval(updateCurrentDateTime, 1000);
});
