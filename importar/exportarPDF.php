<?php
require_once '../libs/TCPDF-main/tcpdf.php';
include '../BD/conexion.php';

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

$pdf->Cell(0, 10, 'Lista de Clasificados', 0, 1, 'C');

$html = '<table border="1" cellpadding="5">
            <thead>
                <tr style="background-color:#f2f2f2;">
                    <th><b>Num Parte</b></th>
                    <th><b>Cve Prov</b></th>
                    <th><b>Fracción</b></th>
                    <th><b>Cve Imp</b></th>
                    <th><b>Mercancía</b></th>
                </tr>
            </thead>
            <tbody>';

$sql = "SELECT num_parte, cve_prov, fraccion, cve_imp, mercancia FROM clasificado";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . htmlspecialchars($row['num_parte']) . '</td>
                    <td>' . htmlspecialchars($row['cve_prov']) . '</td>
                    <td>' . htmlspecialchars($row['fraccion']) . '</td>
                    <td>' . htmlspecialchars($row['cve_imp']) . '</td>
                    <td>' . htmlspecialchars($row['mercancia']) . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="5">No hay datos</td></tr>';
}

$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');

$fecha = date("Y-m-d_H-i-s");
$pdf->Output("clasificado_$fecha.pdf", 'D');
?>
