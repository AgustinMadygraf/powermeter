CREATE TABLE resumen_tiros_generales_mes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    mes INT,
    año INT,
    sumatoria_tiros_generales_mes INT,
    fecha_inicio_mes DATE
);

INSERT INTO resumen_tiros_generales_mes (mes, año, sumatoria_tiros_generales_mes, fecha_inicio_mes)
SELECT
    mes,
    año,
    SUM(Tiros_Generales) AS sumatoria_tiros_generales_mes,
    STR_TO_DATE(CONCAT(año,'-',mes,'-01'), '%Y-%m-%d') AS fecha_inicio_mes
FROM
    grafica_offset
GROUP BY
    mes, año;
