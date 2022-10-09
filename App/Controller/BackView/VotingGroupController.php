<?php

namespace App\Controller\BackView;

use App\Model\Schools;
use System\Controller;
use App\Model\Students;
use App\Library\FPDF\FPDF;
use App\Model\VotingGroups;
use App\Library\PdfList\PdfList;
use App\Library\PdfList\PdfListWall;

class VotingGroupController extends Controller
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
        $school = session()->user();

        $mesas = VotingGroups::where('school_id', $school->school_id)->get();

        //cuando viene un solo objeto
        if (is_object($mesas)) {
            $mesas = [$mesas];
        }

        // dd($mesas);

        return view('votinggroups/index', [
            'titleHead' => 'lista de mesas de sufragio',
            'mesas' => $mesas
        ]);
    }

    public function store()
    {
        $data = $this->request()->getInput();

        $valid = $this->validate($data, [
            'number_mesa' => 'required|integer',
        ]);
        if ($valid !== true) {
            return back()->route('votinggroups.index', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {
            //eliminar mesas
            $school_id = session()->user()->school_id;
            $school = Schools::select('codigo_modular')->where('id', $school_id)->get();

            if ($school->codigo_modular === null) {
                session()->flash('error_code',  'No se ha registrado el codigo modular de su colegio');
                return redirect()->route('votinggroups.index');
            }

            //tres ultimos digitos del codigo modular
            // $tres = substr($school->codigo_modular, 0, 3); //tres primeros
            $tres = substr((string)$school->codigo_modular, -3);

            $grupoMesas = [];

            for ($i = 1; $i <= $data->number_mesa; $i++) {
                $mesa = str_pad($i, 3, "0", STR_PAD_LEFT);
                //array push
                array_push($grupoMesas, $tres . $mesa);
            }

            VotingGroups::generarMesas($school_id, $grupoMesas);

            return redirect()->route('votinggroups.index');
        }
    }

    public function destroy()
    {
        $data = $this->request()->getInput();
        $result = VotingGroups::delete((int)$data->id);
        return redirect()->route('votinggroups.index');
    }

    public function pdf()
    {
        $data = $this->request()->getInput();
        if ($data->mesa == '') {
            session()->flash('errordata', 'No ha seleccionado ninguna mesa');
            return redirect()->route('actas.index');
        }

        $mesa = VotingGroups::where('group_name', $data->mesa)->get();

        $school = Schools::school($mesa->school_id);
        $rutaLogo = DIR_IMG  . $school->photo;
        $rutaEscudo = DIR_IMG . 'escudo.png';
        $rutaOnpe = DIR_IMG . 'onpe.png';

        $estudiantes = Students::getMembersGroup($mesa->id);

        $pdf = new PdfList('P', 'mm', 'A4', $school->name, $mesa->group_name, $rutaLogo, $rutaEscudo, $rutaOnpe);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        //foreach

        $pdf->SetFont('Arial', '', 10);

        foreach ($estudiantes as $key => $s) {
            $pdf->cell(10, 20, utf8_decode($key + 1), 'RTLB', 0, 'C',);
            $pdf->cell(95, 20, utf8_decode($s->fullname), 'RTLB', 0, 'L',);
            $pdf->cell(25, 20, utf8_decode($s->dni), 'RTLB', 0, 'C',);
            $pdf->cell(30, 20, utf8_decode(''), 'RTLB', 0, 'C',);
            $pdf->cell(30, 20, utf8_decode(''), 'RTLB', 1, 'C',);
        }


        // $pdf->Output();
        $pdf->Output("I", "mesa-$data->mesa.pdf");
    }

    public function pdfWall()
    {
        $data = $this->request()->getInput();
        if ($data->mesa == '') {
            session()->flash('errordata', 'No ha seleccionado ninguna mesa');
            return redirect()->route('actas.index');
        }

        $mesa = VotingGroups::where('group_name', $data->mesa)->get();

        $school = Schools::school($mesa->school_id);
        $rutaLogo = DIR_IMG  . $school->photo;
        $rutaEscudo = DIR_IMG . 'escudo.png';
        $rutaOnpe = DIR_IMG . 'onpe.png';

        $estudiantes = Students::getMembersGroup($mesa->id);

        $pdf = new PdfListWall('P', 'mm', 'A4', $school->name, $mesa->group_name, $rutaLogo, $rutaEscudo, $rutaOnpe);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        //foreach

        $pdf->SetFont('Arial', '', 11);

        foreach ($estudiantes as $key => $s) {
            $pdf->cell(15, 10, utf8_decode($key + 1), 'RTLB', 0, 'C',);
            $pdf->cell(140, 10, utf8_decode($s->fullname), 'RTLB', 0, 'L',);
            $pdf->cell(35, 10, utf8_decode($s->dni), 'RTLB', 1, 'C',);
        }

        // $pdf->Output();
        $pdf->Output("I", "mesa-$data->mesa.pdf");
    }
}
