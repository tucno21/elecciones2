<?php

namespace App\Controller\BackView;

use App\Model\Schools;
use System\Controller;
use App\Model\Students;
use App\Model\Candidates;
use App\Model\StartVoting;

class VotingController extends Controller
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
        $president =  session()->user();
        $school = Schools::where('id', $president->school_id)->first();
        // dd($school);
        return view('votings/index', [
            'title' => 'Sistema de votación',
            'school' => $school,

        ]);
    }

    public function create()
    {
        //return view('folder/file', [
        //   'var' => 'es una variable',
        //]);
    }

    public function store()
    {
        $data = $this->request()->getInput();

        $buscar = StartVoting::where('student_id', $data->student_id)->first();

        if (empty($buscar)) {
            $result = StartVoting::create($data);
            return redirect()->route('votings.camera');
        } else {
            return redirect()->route('votings.camera');
        }
    }

    public function camera()
    {
        $president =  session()->user();
        $school = Schools::where('id', $president->school_id)->first();

        return view('votings/camera', [
            'title' => 'Sistema de votación',
            'school' => $school,
        ]);
    }

    public function search()
    {
        $data = $this->request()->getInput()->codigo;
        //separa |
        $codigo = explode("|", $data);
        $dni = $codigo[0];
        $password = $codigo[1];

        $student = Students::presidentStudent($dni);

        if (empty($student)) {
            $response = ['status' => false, 'data' => 'No existe el estudiante'];
            echo json_encode($response);
            exit;
        }

        if ($student->password != $password) {
            $response = ['status' => false, 'data' => 'No se acepta falsificación de códigos'];
            echo json_encode($response);
            exit;
        }

        if ($student->group_name !== session()->user()->group_name) {
            $response = ['status' => false, 'data' => 'No perteneces a la mesa de votación'];
            echo json_encode($response);
            exit;
        }

        if ($student->candidate_id !== null && $student->studentrol_id === 1) {

            $response = ['status' => false, 'data' => ['cerrar'  => true]];
            echo json_encode($response);
            exit;
        }

        if ($student->candidate_id !== null) {
            $response = ['status' => false, 'data' => 'usted ya ha votado, no puede volver a votar'];
            echo json_encode($response);
            exit;
        }

        $response = ['status' => false, 'data' => ''];
        if (!empty($student)) {
            session()->set('student', $student);
            $response['status'] = true;
            $response['data'] = $student;
        }

        echo json_encode($response);
    }

    public function candidate()
    {
        // $student =  session()->get('student');
        $president =  session()->user();

        $school = Schools::where('id', $president->school_id)->first();
        $candidatos = Candidates::getCandidates($president->school_id);
        if (is_object($candidatos)) {
            $candidatos = [$candidatos];
        }
        // dd($candidatos);
        return view('votings/voto', [
            'title' => 'Sistema de votación',
            'school' => $school,
            'candidatos' => $candidatos,
        ]);
    }

    public function candidatePost()
    {
        $data = $this->request()->getInput();

        $arr['candidate_id'] = $data->candidate_id;
        $arr['date_voting'] = date('Y-m-d H:i:s');

        Students::update($data->id, $arr);

        auth()->remove('student');

        return redirect()->route('votings.camera');
    }

    public function close()
    {
        session()->flush();
        return redirect()->route('login.index');
    }
}
