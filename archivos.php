<?php
require 'vendor/autoload.php'; 

use Dompdf\Dompdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$file = 'usuario.json';
if (!file_exists($file)) {
    die("No hay datos de usuarios.");
}
$usuarios = json_decode(file_get_contents($file), true);


$html = '<h1>Usuarios Registrados</h1><ul>';
foreach ($usuarios as $email => $datos) {
    $html .= "<li><strong>Nombre:</strong> {$datos['nombre']}<br><strong>Correo:</strong> {$email}</li><br>";
}
$html .= '</ul>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
file_put_contents('usuarios.pdf', $dompdf->output()); // Guardar PDF


$phpWord = new PhpWord();
$section = $phpWord->addSection();
$section->addText("Usuarios Registrados", ['bold' => true, 'size' => 16]);

foreach ($usuarios as $email => $datos) {
    $section->addText("Nombre: " . $datos['nombre']);
    $section->addText("Correo: " . $email);
    $section->addText(""); // línea vacía
}

$writerWord = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$writerWord->save('usuarios.docx');


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Nombre');
$sheet->setCellValue('B1', 'Correo');

$row = 2;
foreach ($usuarios as $email => $datos) {
    $sheet->setCellValue('A' . $row, $datos['nombre']);
    $sheet->setCellValue('B' . $row, $email);
    $row++;
}

$writerXlsx = new Xlsx($spreadsheet);
$writerXlsx->save('usuarios.xlsx');


echo "<p>Archivos generados exitosamente:</p>";
echo "<ul>
        <li><a href='usuarios.pdf' download>Descargar PDF</a></li>
        <li><a href='usuarios.docx' download>Descargar DOCX</a></li>
        <li><a href='usuarios.xlsx' download>Descargar XLSX</a></li>
      </ul>";
echo "<br><button onclick=\"window.location.href='registro.php';\">Volver</button>";
?>