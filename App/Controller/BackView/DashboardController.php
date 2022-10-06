<?php

namespace App\Controller\BackView;

use App\Model\Schools;
use System\Controller;
use App\Model\Students;
use App\Model\Candidates;

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
}
