<?php

namespace App\Controller\BackView;

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

    public function create()
    {
        return view('votinggroups/create', [
            'titleHead' => 'crear mesas de sufragio',
        ]);
    }

    public function store()
    {
        $data = $this->request()->getInput();

        $valid = $this->validate($data, [
            'group_name' => 'required|integer|between:6,6',
        ]);
        if ($valid !== true) {
            return back()->route('votinggroups.create', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {
            $data->school_id = session()->user()->school_id;

            VotingGroups::create($data);
            return redirect()->route('votinggroups.index');
        }
    }

    public function edit()
    {
        $id = $this->request()->getInput();

        if (empty((array)$id)) {
            $mesa = null;
        } else {
            $mesa = VotingGroups::first($id->id);
        }
        return view('votinggroups.edit', [
            'data' => $mesa,
        ]);
    }

    public function update()
    {
        $data = $this->request()->getInput();

        $valid = $this->validate($data, [
            'group_name' => 'required|integer|between:6,6',
        ]);

        if ($valid !== true) {
            return back()->route('votinggroups.edit', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {
            VotingGroups::update($data->id, $data);
            return redirect()->route('votinggroups.index');
        }
    }

    public function destroy()
    {
        $data = $this->request()->getInput();
        //$result = Model::delete((int)$data->id);
        //return redirect()->route('route.name');
    }
}
