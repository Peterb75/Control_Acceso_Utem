<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\ViewsDB\VW_SolInvitados_Pendientes; // Asegúrate de usar el modelo correcto

class ExcelController extends Controller
{
    public function exportSolicitudes()
    {
        // Obtener todos los datos de la vista
        $solicitudes = VW_SolInvitados_Pendientes::all();

        // Crear una nueva hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Escribir los encabezados
        $headers = [
            'A1' => 'ID Solicitudes',
            'B1' => 'ID Invitado',
            'C1' => 'ID Persona',
            'D1' => 'Nombre',
            'E1' => 'Correo electrónico',
            'F1' => 'Tipo Invitado',
            'G1' => 'Edificio',
            'H1' => 'Cantidad Visitas',
            'I1' => 'Motivo Visita',
            'J1' => 'Fecha Solicitada'
        ];

        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
            // Aplicar estilos a los encabezados
            $sheet->getStyle($cell)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFF00'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF0000FF']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ]);
        }

        // Escribir los datos
        $row = 2;
        foreach ($solicitudes as $solicitud) {
            $sheet->setCellValue('A' . $row, $solicitud->Id_Solicitud);
            $sheet->setCellValue('B' . $row, $solicitud->FK_Id_Invitados);
            $sheet->setCellValue('C' . $row, $solicitud->FK_Id_Persona);
            $sheet->setCellValue('D' . $row, $solicitud->Nombres . ' ' . $solicitud->ApellidoP . ' ' . $solicitud->ApellidoM); // Concatenar nombres
            $sheet->setCellValue('E' . $row, $solicitud->Correo);
            $sheet->setCellValue('F' . $row, $solicitud->FK_TipoInvitado);
            $sheet->setCellValue('G' . $row, $solicitud->Edificio);
            $sheet->setCellValue('H' . $row, $solicitud->CantVis);
            $sheet->setCellValue('I' . $row, $solicitud->MotivoVisit);
            $sheet->setCellValue('J' . $row, $solicitud->FechaSolicitada);
            $row++;
        }

        // Aplicar estilo a las celdas de datos
        $sheet->getStyle('A2:J' . ($row - 1))->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Ajustar el ancho de las columnas automáticamente
        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generar el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'solicitudes.xlsx';

        // Enviar el archivo como una respuesta de descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
