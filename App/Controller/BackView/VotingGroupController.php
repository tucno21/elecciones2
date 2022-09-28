<?php

namespace App\Controller\BackView;

use App\Model\Schools;
use System\Controller;
use App\Model\VotingGroups;

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
}
