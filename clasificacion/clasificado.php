<?php
include '../BD/conexion.php';

// Consulta a la base de datos
$sql = "SELECT num_parte, cve_prov, fraccion, cve_imp, mercancia FROM clasificado";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificado</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="../img/logo.jpg" alt="Logo">
            <span>Clasificación Arancelaria</span>
        </div>
        <button class="btn" onclick="window.location.href='CLAS.html'">REGRESAR</button>
    </nav>

    <h2>Clasificado</h2>

    <!-- Buscador y botón Exportar PDF en una fila -->
    <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-bottom: 10px;">
        <input type="text" id="buscador" placeholder="Buscar en la tabla...">
        <form action="../importar/exportarPDF.php" method="POST" style="display: flex; align-items: center;">
            <button type="submit" class="btn-submit">Exportar a PDF</button>
        </form>
    </div>

    <div class="container">
        <!-- Tabla de datos -->
        <table id="tablaDatos">
            <thead>
                <tr>
                    <th>Num Parte</th>
                    <th>Cve Prov</th>
                    <th>Fracción</th>
                    <th>Cve Imp</th>
                    <th>Mercancía</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".htmlspecialchars($row['num_parte'])."</td>
                                <td>".htmlspecialchars($row['cve_prov'])."</td>
                                <td>".htmlspecialchars($row['fraccion'])."</td>
                                <td>".htmlspecialchars($row['cve_imp'])."</td>
                                <td>".htmlspecialchars($row['mercancia'])."</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay datos</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('buscador').addEventListener('keyup', function() {
            var input = this.value.toLowerCase();
            var filas = document.querySelectorAll("#tablaDatos tbody tr");
            filas.forEach(function(fila) {
                var textoFila = fila.textContent.toLowerCase();
                fila.style.display = textoFila.includes(input) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
