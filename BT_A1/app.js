// Datos para el gráfico
const labels = ["Tiempo Calendario", "Tiempo Programado Productivo", "Paro Programado", "Tiempo Operativo", "Paro No Programado"];
const data = [75, 65, 10, 55, 20];

// Colores de las barras
const colors = ["rgba(255, 99, 132, 0.8)", "rgba(54, 162, 235, 0.8)", "rgba(255, 206, 86, 0.8)", "rgba(75, 192, 192, 0.8)", "rgba(153, 102, 255, 0.8)"];

// Crear el gráfico
const ctx = document.getElementById("oeeChart").getContext("2d");
const myChart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: labels,
    datasets: [{
      data: data,
      backgroundColor: colors,
      borderColor: colors,
      borderWidth: 1,
    }],
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
