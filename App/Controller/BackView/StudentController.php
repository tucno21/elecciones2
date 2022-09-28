<?php

namespace App\Controller\BackView;

use App\Model\Schools;
use System\Controller;
use App\Model\Students;
use App\Model\VotingGroups;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class StudentController extends Controller
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
        $schoolID = session()->user()->school_id;

        $students = Students::getStudents($schoolID);

        if (is_object($students)) {
            $students = [$students];
        }

        return view('students/index', [
            'titleHead' => 'lista de usuarios',
            'students' => $students
        ]);
    }

    public function destroy()
    {
        $data = $this->request()->getInput();
        $result = Students::delete((int)$data->id);
        session()->flash('succes_data',  'Estudiante eliminado correctamente');
        return redirect()->route('students.index');
    }

    public static function tablemodel()
    {
        $excel = new Spreadsheet();
        $hojaActiva = $excel->getActiveSheet();
        $hojaActiva->setTitle('datos');
        $hojaActiva->getTabColor()->setRGB('FF0000');

        $hojaActiva->getColumnDimension('A')->setWidth(30);
        $hojaActiva->setCellValue('A1', 'NOMBRE Y APELLIDOS');
        $hojaActiva->getColumnDimension('B')->setWidth(15);
        $hojaActiva->setCellValue('B1', 'DNI');
        $hojaActiva->getColumnDimension('C')->setWidth(10);
        $hojaActiva->setCellValue('C1', 'N° Mesa');

        $hojaActiva->setCellValue('A2', 'Juan Velarde Fajardo');
        $hojaActiva->setCellValue('B2', '44442222');
        $hojaActiva->setCellValue('C2', '632001');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ListaEstudiantes.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($excel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function uploaddatastore()
    {
        $data = $this->request()->getInput();

        $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        if (in_array($data->file["type"], $allowedFileType)) {
            //movel el archivo a la carpeta temporal
            $excelPath = DIR_IMG . $data->file['name'];
            move_uploaded_file($data->file['tmp_name'], $excelPath);

            $documentoExcel = IOFactory::load($excelPath);
            $hojaactual = $documentoExcel->getSheet(0);
            $numeroFilas = $hojaactual->getHighestDataRow();

            $school = session()->user();
            //codigo modular de la IE
            $codigoModular = Schools::first($school->id)->codigo_modular;
            if ($codigoModular === null) {
                session()->flash('error_code',  'No se ha registrado el codigo modular de la institución');
                return redirect()->route('students.index');
            };

            //mesas
            $mesas = VotingGroups::where('school_id', $school->school_id)->get();
            //['id'='group_name']
            $mesas = array_column($mesas, 'group_name', 'id');

            $dataStudents = [];

            for ($fila = 2; $fila <= $numeroFilas; $fila++) {
                $valorA = $hojaactual->getCellByColumnAndRow(1, $fila);
                $valorB = $hojaactual->getCellByColumnAndRow(2, $fila);
                $valorC = $hojaactual->getCellByColumnAndRow(3, $fila);

                if (array_search($valorC->getValue(), $mesas) === false) {
                    session()->flash('error_code',  'Revisa el archivo, la mesa ' . $valorC->getValue() . ' no existe');
                    return redirect()->route('students.index');
                };

                //array push
                array_push($dataStudents, [
                    'fullname' => $valorA->getValue(),
                    'dni' => $valorB->getValue(),
                    //buscar id en $mesas
                    'votinggroup_id' => array_search($valorC->getValue(), $mesas),
                    'school_id' => $school->school_id,
                    'password' => md5($valorB->getValue() . $codigoModular),
                ]);
            }

            $result = Students::createStudents($school->school_id, $dataStudents);
            //eliminar archivo excel
            unlink($excelPath);
            session()->flash('succes_data',  'Excelente se ha registrado todos los estudiantes');
            return redirect()->route('students.index');
        }
    }

    public static function report()
    {
        $resultados = Students::get();
        // dd($resultados);
        //cuando viene un solo objeto
        if (is_object($resultados)) {
            $resultados = [$resultados];
        }

        $excel = new Spreadsheet();
        $hojaActiva = $excel->getActiveSheet();
        $hojaActiva->setTitle('Participación');
        $hojaActiva->getTabColor()->setRGB('FF0000');

        $hojaActiva->getColumnDimension('A')->setWidth(5);
        $hojaActiva->setCellValue('A1', 'N');
        $hojaActiva->getColumnDimension('B')->setWidth(30);
        $hojaActiva->setCellValue('B1', 'NOMBRE Y APELLIDOS');
        $hojaActiva->getColumnDimension('C')->setWidth(10);
        $hojaActiva->setCellValue('C1', 'DNI');
        $hojaActiva->getColumnDimension('D')->setWidth(8);
        $hojaActiva->setCellValue('D1', 'PARTICPACIÓN');
        $hojaActiva->getColumnDimension('E')->setWidth(20);
        $hojaActiva->setCellValue('E1', 'FECHA Y HORA');


        $fila = 2;
        foreach ($resultados as $value) {
            $hojaActiva->setCellValue('A' . $fila, $fila - 1);
            $hojaActiva->setCellValue('B' . $fila, $value->fullname);
            $hojaActiva->setCellValue('C' . $fila, $value->dni);
            if ($value->candidate_id == null || $value->candidate_id == '' || $value->candidate_id == 0) {
                $hojaActiva->setCellValue('D' . $fila, 'no');
            } else {
                $hojaActiva->setCellValue('D' . $fila, 'si');
            }
            $hojaActiva->setCellValue('E' . $fila, $value->updated_at);
            $fila++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="estudiantes.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($excel, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function deleteStudentSchool()
    {
        $schoolID = session()->user()->school_id;

        Students::deleteStudentSchool($schoolID);

        return redirect()->route('students.index');
    }
}
