<?php

namespace App\Controller\Auth;

use App\Model\Users;
use System\Controller;
use App\Model\Students;
use App\Model\VotingDate;


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
    }

    public function admin()
    {
        return view('auth/admin', [
            'title' => 'Login administrador',
        ]);
    }

    public function adminstore()
    {
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login.index');
    }
}
