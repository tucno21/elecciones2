<?php

namespace App\Controller\BackView;

use App\Model\Schools;
use System\Controller;
use App\Model\Students;
use App\Model\Candidates;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DashboardController extends Controller
{
    public function __construct()
    {
        //enviar 'auth' si ha creado session sin clave de lo contrario enviar la clave
        $this->middleware('auth');
        //enviar el nombre de la ruta
        //$this->except(['users', 'users.create'])->middleware('loco');
    }

    public function index()
    {
        $id = session()->user()->school_id;
        $school = Schools::first($id);
        // dd(session()->user());

        $candidatos = Candidates::where('school_id', $id)->get();
        $estudiantes = Students::where('school_id', $id)->get();

        $votos = Candidates::AllVotos($id);
        $resul = [];
        foreach ($votos as $key => $value) {
            array_push($resul, $value->fullname);
        }
        $resul2 = array_count_values($resul);
        $resultados = (object)$resul2;

        //ganador
        $max = 0;
        $ganador = '';
        foreach ($resultados as $key => $value) {
            if ($value > $max) {
                $max = $value;
                $ganador = $key;
            }
        }

        $alcalde = ['cant' => $max, 'name' => $ganador];

        // dd($resultados);

        return view('dashboard/index', [
            'titleHead' => 'Elecciones Panel',
            'school' => $school,
            'candidatos' => $candidatos,
            'estudiantes' => $estudiantes,
            'votos' => $votos,
            // 'resultados' => $resultados,
            'alcalde' => (object)$alcalde
        ]);
    }

    public function charts()
    {
        $id = session()->user()->school_id;

        $votos = Candidates::AllVotos($id);

        $resul = [];
        foreach ($votos as $key => $value) {
            array_push($resul, $value->fullname);
        }
        $resul2 = array_count_values($resul);

        //array = [candidatos => [], votos => []]
        $data = ['candidatos' => [], 'votos' => []];

        foreach ($resul2 as $key => $value) {
            array_push($data['candidatos'], $key);
            array_push($data['votos'], $value);
        }

        $response = ['status' => false, 'data' => ''];
        if (!empty($data)) {
            $response['status'] = true;
            $response['data'] = $data;
        }

        echo json_encode($response);
    }

    public function excel()
    {
        $id = session()->user()->school_id;

        $query = "SELECT C.fullname, C.group_name, COUNT(E.candidate_id) maximo FROM candidates C INNER JOIN students E ON C.id = E.candidate_id WHERE C.school_id = $id GROUP BY candidate_id ORDER BY maximo DESC";

        $resultados = Candidates::querySimple($query);
        // dd($resultados);

        $excel = new Spreadsheet();
        $hojaActiva = $excel->getActiveSheet();
        $hojaActiva->setTitle('resultados_voto_electoral');
        $hojaActiva->getTabColor()->setRGB('FF0000');

        $hojaActiva->getColumnDimension('A')->setWidth(5);
        $hojaActiva->setCellValue('A1', 'N');
        $hojaActiva->getColumnDimension('B')->setWidth(30);
        $hojaActiva->setCellValue('B1', 'NOMBRE GRUPO');
        $hojaActiva->getColumnDimension('C')->setWidth(30);
        $hojaActiva->setCellValue('C1', 'NOMBRE CANDIDATO');
        $hojaActiva->getColumnDimension('D')->setWidth(8);
        $hojaActiva->setCellValue('D1', 'VOTOS TOTAL');


        $fila = 2;
        foreach ($resultados as $value) {
            $hojaActiva->setCellValue('A' . $fila, $fila - 1);
            $hojaActiva->setCellValue('B' . $fila, $value->group_name);
            $hojaActiva->setCellValue('C' . $fila, $value->fullname);
            $hojaActiva->setCellValue('D' . $fila, $value->maximo);
            $fila++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="resultados.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($excel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
