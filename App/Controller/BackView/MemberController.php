<?php

namespace App\Controller\BackView;

use System\Controller;
use App\Model\Students;
use App\Model\StudentRoles;
use App\Model\VotingGroups;

class MemberController extends Controller
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
        $data = $this->request()->getInput();

        $mesa = VotingGroups::first($data->id);

        $roles = StudentRoles::get();

        return view('members/index', [
            'titleHead' => 'Mienbros de mesa',
            'mesa' => $mesa,
            'roles' => $roles,
            // 'students' => $students,
        ]);
    }

    public function members()
    {
        $dataID = $this->request()->getInput();

        $data = Students::getMembers($dataID->id);

        //cuando viene un solo objeto
        if (is_object($data)) {
            $data = [$data];
        }

        $response = ['status' => false, 'data' => ''];
        if (!empty($data)) {
            $response['status'] = true;
            $response['data'] = $data;
        }

        echo json_encode($response);
    }

    public function search()
    {
        $dataX = $this->request()->getInput();

        $data = Students::searchStudent($dataX);

        $response = ['status' => false, 'data' => ''];
        if (!empty($data)) {
            $response['status'] = true;
            $response['data'] = $data;
        }

        echo json_encode($response);
    }

    public function student()
    {
        $dataX = $this->request()->getInput();
        // $data = Students::first($dataX->id);
        $data = Students::select('id', 'fullname', 'dni', 'studentrol_id')->where('id', $dataX->id)->get();
        $response = ['status' => false, 'data' => ''];
        if (!empty($data)) {
            $response['status'] = true;
            $response['data'] = $data;
        }

        echo json_encode($response);
    }

    public function create()
    {
        // return view('members/create', [
        //     'titleHead' => 'Mienbros de mesa',
        // ]);
    }

    public function store()
    {
        $dataX = (object)$_POST;

        $data = Students::update($dataX->id, $dataX);

        $response = ['status' => false, 'data' => ''];
        if (!empty($data)) {
            $response['status'] = true;
            $response['data'] = $data;
        }

        echo json_encode($response);
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
        $dataX = $this->request()->getInput();
        $data = Students::deleteUpdate($dataX);

        $data = ['hola' => 'hola'];

        $response = ['status' => false, 'data' => ''];
        if (!empty($data)) {
            $response['status'] = true;
            $response['data'] = $data;
        }

        echo json_encode($response);
    }
}
