<?php
// Cargar la librería PhpSpreadsheet desde la carpeta libs
require_once '../libs/PhpSpreadsheet/src/PhpSpreadsheet/IOFactory.php'; 

// Incluir la conexión a la base de datos
include '../BD/conexion.php';

// Usar la clase IOFactory para cargar el archivo Excel
use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo_excel'])) {
    // Obtener el archivo subido
    $archivo = $_FILES['archivo_excel']['tmp_name'];

    try {
        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($archivo);
        $sheet = $spreadsheet->getActiveSheet();

        // Leer los datos (asumiendo que los datos están en las primeras filas de la hoja)
        foreach ($sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Incluir celdas vacías

            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue(); // Obtener el valor de cada celda
            }

            // Inserción en la base de datos
            if (count($data) >= 5) { // Asegúrate de que haya suficientes columnas
                $num_parte = mysqli_real_escape_string($conn, $data[0]);
                $cve_prov = mysqli_real_escape_string($conn, $data[1]);
                $fraccion = mysqli_real_escape_string($conn, $data[2]);
                $cve_imp = mysqli_real_escape_string($conn, $data[3]);
                $mercancia = mysqli_real_escape_string($conn, $data[4]);

                $sql = "INSERT INTO noClasificado (num_parte, cve_prov, fraccion, cve_imp, mercancia)
                        VALUES ('$num_parte', '$cve_prov', '$fraccion', '$cve_imp', '$mercancia')";

                if (!$conn->query($sql)) {
                    echo "Error al insertar los datos: " . $conn->error;
                }
            }
        }

        echo "Archivo procesado y datos insertados correctamente.";
    } catch (Exception $e) {
        echo "Error al cargar el archivo: " . $e->getMessage();
    }
}
?>
