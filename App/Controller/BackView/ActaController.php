<?php

namespace App\Controller\BackView;

use App\Model\Schools;
use System\Controller;
use App\Model\Students;
use App\Library\Mes\Mes;
use App\Model\Candidates;
use App\Library\FPDF\FPDF;
use App\Model\StartVoting;
use App\Model\VotingGroups;
use App\Library\PdfList\PdfList;

class ActaController extends Controller
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
        $user = session()->user();

        $mesas = VotingGroups::where('school_id', $user->school_id)->get();

        return view('actas.index', [
            'titleHead' => 'Actas de sufragio',
            'mesas' => $mesas
        ]);
    }

    public function create()
    {
        $id = session()->user()->school_id;

        $data = $this->request()->getInput();
        if ($data->mesa == '') {
            session()->flash('errordata', 'No ha seleccionado ninguna mesa');
            return redirect()->route('actas.index');
        }

        //VOTOS ================================================
        $query = "SELECT C.group_name, COUNT(E.candidate_id) maximo FROM candidates C INNER JOIN students E ON C.id = E.candidate_id WHERE C.school_id = $id AND E.votinggroup_id = $data->mesa GROUP BY C.group_name";
        $votos = Candidates::querySimple($query);
        if (is_object($votos)) {
            $votos = [$votos];
        }

        //CANDIDATOS ================================================
        $query = "SELECT fullname, group_name, logo FROM candidates WHERE school_id = $id";
        $candidatos = Candidates::querySimple($query);

        //Agregar votos a candidatos y si no existe el campo votos lo crea
        foreach ($candidatos as $key => $value) {
            $candidatos[$key]->votos = 0;
            foreach ($votos as $key2 => $value2) {
                if ($value->group_name == $value2->group_name) {
                    $candidatos[$key]->votos = $value2->maximo;
                }
            }
        }

        //SCHOOLS ================================================
        $school = Schools::where('id', $id)->get();
        $rutaLogo = DIR_IMG  . $school->photo;
        $rutaEscudo = DIR_IMG . 'escudo.png';
        $rutaOnpe = DIR_IMG . 'onpe.png';

        //STUDENTS ================================================
        $query = "SELECT COUNT(*) total FROM students WHERE votinggroup_id = $data->mesa";
        $totalStudents = Students::querySimple($query);

        //MESA
        $query = "SELECT group_name FROM votinggroups WHERE id = $data->mesa";
        $mesa = VotingGroups::querySimple($query);
        // dd($mesa->group_name);

        //MIEMBROS DE MESA ================================================
        //studentrol_id NOT NULL
        $query = "SELECT id, fullname, dni, studentrol_id FROM students WHERE votinggroup_id = $data->mesa AND studentrol_id IS NOT NULL";
        $miembros = Students::querySimple($query);
        if (is_object($miembros)) {
            $miembros = [$miembros];
        }

        $presidente = '';
        $presidenteDni = '';
        $secretario = '';
        $secretarioDni = '';
        $vocal = '';
        $vocalDni = '';

        foreach ($miembros as $key => $value) {
            if ($value->studentrol_id == 1) {
                $presidente = $value->fullname;
                $presidenteDni = $value->dni;
            } elseif ($value->studentrol_id == 2) {
                $secretario = $value->fullname;
                $secretarioDni = $value->dni;
            } elseif ($value->studentrol_id == 3) {
                $vocal = $value->fullname;
                $vocalDni = $value->dni;
            }
        }

        //presidente




        //FECHA ================================================
        //StartVoting id students studentrol_id = 1
        $queryXX = '';
        foreach ($miembros as $key => $value) {
            if ($value->studentrol_id == 1) {
                $queryXX = "SELECT date_start, date_end FROM start_voting WHERE student_id = $value->id";
            }
        }
        $fechaHora = StartVoting::querySimple($queryXX);
        //horaInicio Am o Pm
        $horaInicio = isset($fechaHora->date_start) ? date('h:i A', strtotime($fechaHora->date_start)) : '... : ...';
        //diaInicio
        $diaInicio = isset($fechaHora->date_start) ? date('d', strtotime($fechaHora->date_start)) : '.....';
        //mesInicio nombre español
        $mesInicio = isset($fechaHora->date_start) ? Mes::data(date('m', strtotime($fechaHora->date_start))) : '............................';

        //horaFin Am o Pm
        $horaFin = isset($fechaHora->date_end) ? date('h:i A', strtotime($fechaHora->date_end)) : '... : ...';
        //diaFin
        $diaFin = isset($fechaHora->date_end) ? date('d', strtotime($fechaHora->date_end)) : '.........';
        //mesFin nombre español
        $mesFin = isset($fechaHora->date_end) ? Mes::data(date('m', strtotime($fechaHora->date_end))) : '............................';

        $año = isset($fechaHora->date_start) ?  date('Y', strtotime($fechaHora->date_start)) : '............';


        //hora escrutinio ================================================
        //aumentar 10 minutos a horaFin
        $horaInicioEscrutinio = isset($fechaHora->date_end) ? date('h:i A', strtotime($fechaHora->date_end . '+10 minutes')) : '... : ...';

        //$horaFinEscrutinio aumentar 10 minutos
        $horaFinEscrutinio = isset($fechaHora->date_end) ? date('h:i A', strtotime($fechaHora->date_end . '+20 minutes')) : '';


        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->SetLineWidth(0.4);
        $pdf->SetFont('Arial', '', 10);
        $pdf->cell(190, 7, utf8_decode('ELECCIÓN DEL MUNICIPIO ESCOLAR ') . date('Y'), '', 1, 'C');
        $pdf->cell(190, 7, utf8_decode('INSTITUCIÓN EDUCATIVA ' . mb_strtoupper($school->name)), '', 1, 'C');
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->cell(190, 7, utf8_decode('ACTA ELECTORAL'), '', 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->cell(140, 7, utf8_decode(''), '', 0, 'C');
        $pdf->cell(20, 7, utf8_decode('MESA N°'), '', 0, 'C');
        $pdf->cell(30, 7, utf8_decode($mesa->group_name), 'RTLB', 1, 'C');
        //SALTO DE LINEA
        $pdf->Ln(2);

        // $pdf->SetDrawColor(0, 80, 180); //color de borde
        $pdf->SetFillColor(194, 194, 194); //color de fondo
        // $pdf->SetTextColor(220, 50, 50); //color de letra
        $pdf->cell(90, 7, utf8_decode('INSTALACIÓN'), 'RTLB', 0, 'C', 1);
        $pdf->cell(10, 7, utf8_decode(''), '', 0, 'C');
        $pdf->cell(90, 7, utf8_decode('SUFRAGIO O VOTACIÓN'), 'RTLB', 1, 'C', 1);

        $pdf->SetFont('Arial', '', 9);
        $pdf->cell(90, 7, utf8_decode("La mesa de votación se instala a las $horaInicio horas, del día"), 'LR', 0, 'J');
        $pdf->cell(10, 7, utf8_decode(''), '', 0, 'C');
        $pdf->cell(90, 7, utf8_decode("El sufragio concluyé a las $horaFin horas del día"), 'LR', 1, 'J');

        $pdf->cell(90, 7, utf8_decode("$diaInicio de $mesInicio de $año."), 'LR', 0, 'J');
        $pdf->cell(10, 7, utf8_decode(''), '', 0, 'C');
        $pdf->cell(90, 7, utf8_decode("$diaFin de $mesFin de $año."), 'LR', 1, 'J');

        $pdf->cell(90, 7, utf8_decode('Cantidad de cédulas de sufragio'), 'LR', 0, 'J');
        $pdf->cell(10, 7, utf8_decode(''), '', 0, 'C');
        $pdf->cell(90, 7, utf8_decode('Total de electores que'), 'LR', 1, 'J');

        $pdf->cell(90, 7, utf8_decode('recibida:'), 'LRB', 0, 'J');
        $pdf->cell(10, 7, utf8_decode(''), '', 0, 'C');
        $pdf->cell(90, 7, utf8_decode('votaron:'), 'RLB', 1, 'J');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->cell(190, 7, utf8_decode('ESCRUTINIO O CONTEO DE VOTOS'), '', 1, 'C');
        $pdf->SetFont('Arial', '', 9);

        $pdf->Ln(3);
        $pdf->cell(190, 7, utf8_decode("Siendo las $horaInicioEscrutinio horas del día $diaFin de $mesFin de $año, se da inicio al ESCRUTINIO"), '', 1, 'L');

        $pdf->Ln(4);
        $pdf->cell(120, 7, utf8_decode(''), '', 0, 'J');
        $pdf->cell(40, 7, utf8_decode(''), '', 0, 'C');
        $pdf->cell(30, 7, utf8_decode('Votos'), '', 1, 'C');

        //resultados candidatos
        $pdf->SetFont('Arial', '', 13);
        $total = 0;
        $x = 145;
        $y = 108;
        foreach ($candidatos as $cand) {
            $pdf->cell(120, 12, utf8_decode($cand->group_name), 'LRTB', 0, 'J');
            $pdf->cell(40, 12, utf8_decode(''), 'LRTB', 0, 'C');
            $pdf->cell(30, 12, utf8_decode($cand->votos), 'LRTB', 1, 'C');
            $total += $cand->votos;

            $ruta_qr = DIR_IMG  . $cand->logo;
            $pdf->Image($ruta_qr, $x, $y, 10);
            $y += 12;
        }

        //total
        $pdf->cell(120, 12, utf8_decode('   Total de votos'), 'LTB', 0, 'J');
        $pdf->cell(40, 12, utf8_decode(''), 'TB', 0, 'C');
        $pdf->cell(30, 12, utf8_decode($total), 'LRTB', 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        //hora fin
        $pdf->Ln(5);
        $pdf->cell(45, 7, utf8_decode('Hora de fin del escrutinio:'), '', 0, 'J');
        $pdf->cell(20, 7, utf8_decode($horaFinEscrutinio), 'LRTB', 1, 'C');

        //multicell
        $pdf->Ln(4);
        $pdf->MultiCell(190, 6, utf8_decode('OBSERVACIONES: _____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________'), '0', 'J');

        //FIRMAS DE MESA
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(10);
        $pdf->cell(60, 3, utf8_decode('____________________________________'), '', 0, 'C');
        $pdf->cell(5, 3, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 3, utf8_decode('___________________________________'), '', 0, 'C');
        $pdf->cell(5, 3, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 3, utf8_decode('___________________________________'), '', 1, 'C');

        $pdf->cell(60, 5, utf8_decode('Presidente(a) de mesa'), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode('Secretario(a) de mesa'), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode('Vocal de mesa'), '', 1, 'C');

        $pdf->cell(60, 5, utf8_decode($presidente), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode($secretario), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode($vocal), '', 1, 'C');

        $pdf->cell(60, 5, utf8_decode("DNI: $presidenteDni"), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode("DNI: $secretarioDni"), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode("DNI: $vocalDni"), '', 1, 'C');

        //PERSONEROS
        $pdf->Ln(10);
        $pdf->cell(60, 3, utf8_decode('____________________________________'), '', 0, 'C');
        $pdf->cell(5, 3, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 3, utf8_decode('___________________________________'), '', 0, 'C');
        $pdf->cell(5, 3, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 3, utf8_decode('___________________________________'), '', 1, 'C');

        $pdf->cell(60, 5, utf8_decode('Personero'), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode('Personero'), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode('Personero'), '', 1, 'C');

        $pdf->cell(60, 5, utf8_decode('............................................'), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode('............................................'), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode('............................................'), '', 1, 'C');

        $pdf->cell(60, 5, utf8_decode('DNI: '), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode('DNI: '), '', 0, 'C');
        $pdf->cell(5, 5, utf8_decode(''), '', 0, 'C');
        $pdf->cell(60, 5, utf8_decode('DNI: '), '', 1, 'C');

        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(65, 62);
        $pdf->cell(30, 10, utf8_decode($totalStudents->total), 'LRTB', 0, 'C');
        $pdf->SetXY(165, 62);
        $pdf->cell(30, 10, utf8_decode($total), 'LRTB', 0, 'C');



        //logos
        $pdf->Image($rutaLogo, 175, 10, 18);
        // $pdf->Image($rutaEscudo, 20, 10, 18);
        $pdf->Image($rutaOnpe, 10, 10, 40);

        $pdf->Output('I', "Acta-$mesa->group_name.pdf");

        // return redirect()->route('actas.index');
        dd($data->mesa);

        //return view('folder/file', [
        //   'var' => 'es una variable',
        //]);
    }

    public function mesas()
    {
        $user = session()->user();

        $mesas = VotingGroups::where('school_id', $user->school_id)->get();
        if (is_object($mesas)) {
            $mesas = [$mesas];
        }

        //SCHOOLS ================================================
        $query = "SELECT * FROM schools WHERE id = $user->school_id";
        $school = Schools::querySimple($query);

        // $school = Schools::where('id', $user->school_id)->get();
        $rutaLogo = DIR_IMG  . $school->photo;
        $rutaEscudo = DIR_IMG . 'escudo.png';
        $rutaOnpe = DIR_IMG . 'onpe.png';


        // dd($school);
        $pdf = new FPDF('L', 'mm', 'A4');

        //
        foreach ($mesas as $mesa) {
            $pdf->AddPage();
            $pdf->cell(0, 8, utf8_decode(''), 0, 1, 'C');
            $pdf->SetFont('Arial', 'B', 45);
            $pdf->cell(0, 10, utf8_decode('Mesa de votación'), 0, 1, 'C');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->cell(0, 10, utf8_decode('INSTITUCIÓN EDUCATIVA ' . mb_strtoupper($school->name)), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 14);
            $pdf->cell(0, 6, utf8_decode($school->message), 0, 1, 'C');
            $pdf->SetFont('Arial', 'B', 120);
            $pdf->cell(0, 130, utf8_decode('N° ' . $mesa->group_name), '', 1, 'C');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->cell(0, 10, utf8_decode('Voto Electrónico ' . date('Y')), '', 1, 'C');
            //logos
            $pdf->Image($rutaOnpe, 10, 10, 80);
            $pdf->Image($rutaLogo, 230, 10, 35);
        }

        $pdf->Output('I', 'Mesas-aula.pdf');
        // dd($mesas);
    }

    public function  wordproclamacion()
    {
        //Acta_proclamacion.docx

        $acta = DIR_IMG . 'Acta_proclamacion.docx';
        //descargar el archivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($acta));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($acta));
        readfile($acta);
        exit;
        // dd($acta);
    }

    public function credencial()
    {
        $data = $this->request()->getInput();

        if ($data->nameStudent == '' || $data->cargo == '' || $data->fecha == '') {
            session()->flash('errordata', 'no ha ingresado uno o mas datos, no se puede generar la credencial');
            return redirect()->route('actas.index');
        }

        $user = session()->user();

        $school = Schools::school($user->school_id);
        $rutaLogo = DIR_IMG  . $school->photo;
        $rutaEscudo = DIR_IMG . 'escudo.png';
        $rutaOnpe = DIR_IMG . 'onpe.png';
        $credencial = DIR_IMG . 'credencial.png';

        //fecha
        $fechaDia = date('d', strtotime($data->fecha));
        $fechaMes = Mes::data(date('m', strtotime($data->fecha)));
        $fechaAnio = date('Y', strtotime($data->fecha));
        //año siguiente
        $fechaAnioSiguiente = date('Y', strtotime($data->fecha . '+ 1 year'));

        $fecha = "$fechaDia de $fechaMes del $fechaAnio";

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->SetMargins(30, 14, 30);
        $pdf->AddPage();
        //agregar imagen credencial
        $pdf->Image($credencial, 2, 2, 293, 206);
        //salto de linea
        $pdf->cell(0, 14, utf8_decode(''), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->cell(237, 14, utf8_decode("I.E. " . mb_strtoupper($school->name)), '', 1, 'C');
        $pdf->ln(15);
        $pdf->SetFont('Times', 'B', 22);
        $pdf->cell(237, 14, utf8_decode("Otorga a:"), '', 1, 'C');
        $pdf->SetFont('Helvetica', 'I', 27);
        $pdf->cell(237, 14, utf8_decode($data->nameStudent), '', 1, 'C');

        //multicell
        $pdf->SetFont('Times', '', 21);
        $pdf->cell(237, 7, utf8_decode(""), '', 1, 'C');
        $pdf->MultiCell(0, 16, utf8_decode("La presente credencial como " . mb_strtoupper($data->cargo) . " del Municipio Escolar para el período $fechaAnioSiguiente."), '', 'J');
        $pdf->SetFont('Times', '', 16);
        $pdf->cell(237, 7, utf8_decode($fecha), '', 1, 'R');

        //$rutaLogo
        $pdf->Image($rutaOnpe, 11, 22, 70);
        $pdf->Image($rutaLogo, 239, 25, 30);

        $pdf->Output('I', 'Credencial.pdf');
    }

    public function material()
    {
        //materialElecciones.zip

        $material = DIR_IMG . 'materialElecciones.zip';
        //descargar el archivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($material));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($material));
        readfile($material);
        exit;
    }
}
