<?php

namespace App\Controller\BackView;

use App\Model\Users;
use App\Model\Roles;
use App\Model\Schools;
use System\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        //ejecutar para proteger la rutas cuando inicia sesion
        //enviar la sesion y el parametro principal de la url
        $this->middleware('auth');
    }

    public function index()
    {
        $users = Users::dataUsers();

        //cuando viene un solo objeto
        if (is_object($users)) {
            $users = [$users];
        }
        // dd($user);

        return view('users.index', [
            'titleHead' => 'lista de usuarios',
            'users' => $users,
        ]);
    }

    public function create()
    {
        $roles = Roles::get();
        if (is_object($roles)) {
            $roles = [$roles];
        }

        $schools = Schools::get();
        if (is_object($schools)) {
            $schools = [$schools];
        }

        return view('users.create', [
            'titleHead' => 'crear usuarios',
            'roles' => $roles,
            'schools' => $schools,
        ]);
    }

    public function store()
    {
        $data = $this->request()->getInput();
        // dd($data);
        $valid = $this->validate($data, [
            'fullname' => 'required|text',
            'email' => 'required|email|unique:Users,email',
            'password' => 'required|min:3|max:20',
            'rol_id' => 'required',
            'school_id' => 'required',
            'status' => 'alpha_numeric',
        ]);

        if ($valid !== true) {
            return back()->route('users.create', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {

            session()->remove('renderView');
            session()->remove('reserveRoute');

            Users::create($data);

            return redirect()->route('users.index');
        }
    }

    public function edit()
    {
        $roles = Roles::get();
        $schools = Schools::get();

        $id = $this->request()->getInput();

        if (empty((array)$id)) {
            $user = null;
        } else {
            // $user = Auth::first($id->id);
            $user = Users::select('id', 'fullname', 'email', 'status', 'rol_id', 'school_id')
                ->where('id', $id->id)
                ->get();
        }

        return view('users.edit', [
            'titleHead' => 'actualizar usuarios',
            'roles' => $roles,
            'data' => $user,
            'schools' => $schools,
        ]);
    }

    public function update()
    {
        $data = $this->request()->getInput();

        $valid = $this->validate($data, [
            'fullname' => 'required|text',
            'email' => 'required|email|not_unique:Users,email',
            'password' => 'required|min:3|max:20',
            'rol_id' => 'required',
            'school_id' => 'required',
            'status' => 'alpha_numeric',
        ]);

        if ($valid !== true) {
            return back()->route('users.edit', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {

            session()->remove('renderView');
            session()->remove('reserveRoute');

            // Auth::create($data);
            Users::update($data->id, $data);

            return redirect()->route('users.index');
        }
    }

    public function destroy()
    {
        $data = $this->request()->getInput();
        // dd((int)$data->id);
        $result = Users::delete((int)$data->id);
        // dd($result);
        return redirect()->route('users.index');
    }
}
