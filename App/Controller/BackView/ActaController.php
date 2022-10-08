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
        $pdf->cell(190, 7, utf8_decode('INSTITUCIÓN EDUCATIVA ' . strtoupper($school->name)), '', 1, 'C');
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
        $pdf->Image($rutaLogo, 165, 10, 18);
        // $pdf->Image($rutaEscudo, 20, 10, 18);
        $pdf->Image($rutaOnpe, 20, 10, 40);

        $pdf->Output('I', 'CodigoIdentidad.pdf');

        // return redirect()->route('actas.index');
        dd($data->mesa);

        //return view('folder/file', [
        //   'var' => 'es una variable',
        //]);
    }

    public function store()
    {
        $data = $this->request()->getInput();
        dd($data);

        // $valid = $this->validate($data, [
        //     'name' => 'required',
        // ]);
        // if ($valid !== true) {
        //     return back()->route('route.name', [
        //         'err' =>  $valid,
        //         'data' => $data,
        //     ]);
        // } else {
        //     Model::create($data);
        //     return redirect()->route('route.name');
        // }
    }

    public function edit()
    {
        $id = $this->request()->getInput();

        // if (empty((array)$id)) {
        //     $rol = null;
        // } else {
        //     $rol = Model::first($id->id);
        // }
        // return view('folder.file', [
        //     'data' => $rol,
        // ]);
    }

    public function update()
    {
        $data = $this->request()->getInput();
        // $valid = $this->validate($data, [
        //     'name' => 'required',
        // ]);

        // if ($valid !== true) {
        //     return back()->route('route.name', [
        //         'err' =>  $valid,
        //         'data' => $data,
        //     ]);
        // } else {
        //     Model::update($data->id, $data);
        //     return redirect()->route('route.name');
        // }
    }

    public function destroy()
    {
        $data = $this->request()->getInput();
        //$result = Model::delete((int)$data->id);
        //return redirect()->route('route.name');
    }
}
