<?php

namespace App\Controller\Auth;

use App\Model\Students;
use App\Model\Users;
use System\Controller;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth/index', [
            'title' => 'Login Estudiantes',
        ]);
    }



    public function store()
    {
        $data = $this->request()->getInput();

        $valid = $this->validate($data, [
            'dni' => 'required|integer|between:8,8|not_unique:Students,dni',
        ]);
        if ($valid !== true) {
            return back()->route('login.index', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {
            session()->remove('renderView');
            session()->remove('reserveRoute');

            $student = Students::where('dni', $data->dni)->first();

            if ($student->studentrol_id === 1) {
                auth()->attempt($student);
                return redirect()->route('votings.index');
            }

            session()->flash('errorSesion', 'No tienes permisos para ingresar');
            return redirect()->route('login.index');
        }
    }

    public function admin()
    {
        return view('auth/admin', [
            'title' => 'Login administrador',
        ]);
    }

    public function adminstore()
    {
        $data = $this->request()->getInput();

        $valid = $this->validate($data, [
            'email' => 'required|email|not_unique:Users,email',
            'password' => 'required|password_verify:Users,email',
        ]);
        if ($valid !== true) {
            return back()->route('login.admin', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {
            $user = Users::select('id, fullname, email, school_id,rol_id, status')->where('email', $data->email)->get();

            // $user = Users::select('users.id', 'users.email', 'users.name', 'users.status', 'users.rol_id', 'roles.rol_name')
            //     ->join('roles', 'users.rol_id', '=', 'roles.id')
            //     ->get();

            if ($user->status == 0) {
                session()->flash('status', 'El usuario se encuentra desactivado');
                return back()->route('login');
            }

            auth()->attempt($user);

            return redirect()->route('dashboard.index');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login.index');
    }
}
