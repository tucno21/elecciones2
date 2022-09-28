<?php

namespace App\Controller\BackView;

use System\Controller;
use App\Model\StudentRoles;

class StudentRolesController extends Controller
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
        $roles = StudentRoles::get();

        //cuando viene un solo objeto
        if (is_object($roles)) {
            $roles = [$roles];
        }

        return view('studentroles/index', [
            'titleHead' => 'lista roles estudiantes',
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        return view('studentroles/create', [
            'titleHead' => 'crear roles estudiantes',
        ]);
    }

    public function store()
    {
        $data = $this->request()->getInput();

        $valid = $this->validate($data, [
            'name' => 'required',
        ]);
        if ($valid !== true) {
            return back()->route('studentroles.create', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {
            StudentRoles::create($data);
            return redirect()->route('studentroles.index');
        }
    }

    public function edit()
    {
        $id = $this->request()->getInput();

        if (empty((array)$id)) {
            $rol = null;
        } else {
            $rol = StudentRoles::first($id->id);
        }
        return view('studentroles.edit', [
            'data' => $rol,
        ]);
    }

    public function update()
    {
        $data = $this->request()->getInput();
        $valid = $this->validate($data, [
            'name' => 'required',
        ]);

        if ($valid !== true) {
            return back()->route('studentroles.edit', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {
            StudentRoles::update($data->id, $data);
            return redirect()->route('studentroles.index');
        }
    }

    public function destroy()
    {
        $data = $this->request()->getInput();
        $result = StudentRoles::delete((int)$data->id);
        return redirect()->route('studentroles.index');
    }
}
