<?php

namespace App\Controller;

use App\Repository\CarSaleRepository;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController{
    #[Route('/download-report/pdf', name: 'report_pdf')]
    public function generatePdf(CarSaleRepository $repository): Response{
        $sales = $repository->getAllSales();
        $html = '<h1>Список продаж</h1><table border="1" style="width: 100%; border-collapse: collapse;"><tr><th>Марка</th><th>Модель</th><th>Цена</th><th>Цвет</th><th>Имя клиента</th><th>Телефон клиента</th></tr>';
        foreach ($sales as $sale) {
            $html .= '<tr>
                        <td>' . $sale->getCarBrand() . '</td>
                        <td>' . $sale->getCarModel() . '</td>
                        <td>' . $sale->getCarPrice() . '</td>
                        <td>' . $sale->getCarColor() . '</td>
                        <td>' . $sale->getClientName() . '</td>
                        <td>' . $sale->getClientPhone() . '</td>
                    </tr>';
        }
        $html .= '</table>';
        $mpdf = new Mpdf(['tempDir' => sys_get_temp_dir()]);
        $mpdf->WriteHTML($html);
        return new Response($mpdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="sales_report.pdf"',
        ]);
    }

    #[Route('/download-report/excel', name: 'report_excel')]
    public function generateExcel(CarSaleRepository $repository): Response{
        $sales = $repository->getAllSales();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray(['Марка', 'Модель', 'Цена', 'Цвет', 'Имя клиента', 'Телефон клиента'], null, 'A1');
        $row = 2;
        foreach ($sales as $sale) {
            $sheet->setCellValue('A' . $row, $sale->getCarBrand());
            $sheet->setCellValue('B' . $row, $sale->getCarModel());
            $sheet->setCellValue('C' . $row, $sale->getCarPrice());
            $sheet->setCellValue('D' . $row, $sale->getCarColor());
            $sheet->setCellValue('E' . $row, $sale->getClientName());
            $sheet->setCellValue('F' . $row, $sale->getClientPhone());
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'xlsx');
        $writer->save($tempFile);
        return new Response(file_get_contents($tempFile), 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="sales_report.xlsx"',
        ]);
    }

    #[Route('/download-report/csv', name: 'report_csv')]
    public function generateCsv(CarSaleRepository $repository): Response{
        $sales = $repository->getAllSales();
        $tempFile = fopen('php://temp', 'r+');
        fputcsv($tempFile, ['Марка', 'Модель', 'Цена', 'Цвет', 'Имя клиента', 'Телефон клиента']);
        foreach ($sales as $sale) {
            fputcsv($tempFile, [
                $sale->getCarBrand(),
                $sale->getCarModel(),
                $sale->getCarPrice(),
                $sale->getCarColor(),
                $sale->getClientName(),
                $sale->getClientPhone()
            ]);
        }
        rewind($tempFile);
        $csvContent = stream_get_contents($tempFile);
        fclose($tempFile);
        return new Response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sales_report.csv"',
        ]);
    }
}
