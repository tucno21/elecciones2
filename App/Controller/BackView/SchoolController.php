<?php

namespace App\Controller\BackView;

use App\Model\Schools;
use System\Controller;
use Intervention\Image\ImageManagerStatic as Image;

class SchoolController extends Controller
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
        $schools = Schools::get();

        $schools = Schools::get();
        if (is_object($schools)) {
            $schools = [$schools];
        }

        return view('schools/index', [
            'titleHead' => 'Panel de escuelas',
            'schools' => $schools,
        ]);
    }

    public function create()
    {
        return view('schools/create', [
            'titleHead' => 'Crear Institución',
        ]);
    }

    public function store()
    {
        $data = $this->request()->getInput();
        // dd($data);

        $valid = $this->validate($data, [
            'name' => 'required|alpha_space|min:3|max:50',
            'color' => 'required',
            'colorletter' => 'required',
            'date' => 'required',
            'message' => 'required|alpha_space|min:3|max:100',
            'photo' => 'requiredFile',
        ]);
        if ($valid !== true) {
            $data->photo = null;
            return back()->route('schools.create', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {
            if (!empty($data->photo["tmp_name"])) {
                //generar nombre unico para la imagen
                $namePhoto = md5(uniqid(rand(), true)) . '.png';
                //modificar imagen
                $imagePhoto = Image::make($data->photo['tmp_name'])->fit(200, 200);
                //agregar al objeto
                $data->photo = $namePhoto;

                //guardar imagen
                if (!is_dir(DIR_IMG)) {
                    mkdir(DIR_IMG);
                }

                $imagePhoto->save(DIR_IMG . $namePhoto);
            } else {
                $data->photo = null;
            }
            $newDate = implode('-', array_reverse(explode('-', $data->date)));
            $data->date =  $newDate;

            $result =  Schools::create($data);

            return redirect()->route('schools.index');
        }
    }

    public function edit()
    {
        $id = $this->request()->getInput();

        if (empty((array)$id)) {
            $School = null;
        } else {
            $School = Schools::first($id->id);
        }
        return view('schools.edit', [
            'titleHead' => 'Editar Institución',
            'data' => $School,
        ]);
    }

    public function update()
    {
        $data = $this->request()->getInput();

        $valid = $this->validate($data, [
            'name' => 'required|alpha_space|min:3|max:50',
            'color' => 'required',
            'colorletter' => 'required',
            'date' => 'required',
            'message' => 'required|alpha_space|min:3|max:100',
            // 'photo' => 'requiredFile',
            'codigo_modular' => 'required|integer|between:7,7',
        ]);

        // dd($data);
        if ($valid !== true) {
            $data->photo = null;
            return back()->route('schools.edit', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {
            if (!empty($data->photo["tmp_name"])) {
                //generar nombre unico para la imagen
                $namePhoto = md5(uniqid(rand(), true)) . '.png';
                //modificar imagen
                $imagePhoto = Image::make($data->photo['tmp_name'])->fit(200, 200);
                //agregar al objeto
                $data->photo = $namePhoto;

                $school = Schools::first($data->id);

                //eliminar imagen anterior
                $photoExists = file_exists(DIR_IMG . $school->photo);
                if ($photoExists) {
                    unlink(DIR_IMG . $school->photo);
                }

                //guardar imagen
                if (!is_dir(DIR_IMG)) {
                    mkdir(DIR_IMG);
                }

                $imagePhoto->save(DIR_IMG . $namePhoto);
            } else {
                $data->photo = null;
            }

            $newDate = implode('-', array_reverse(explode('-', $data->date)));
            $data->date =  $newDate;

            Schools::update($data->id, $data);

            if (session()->user()->id === 1) {
                return redirect()->route('schools.index');
            } else {
                return redirect()->route('schools.myschool');
            }
        }
    }

    public function destroy()
    {
        $data = $this->request()->getInput();

        $school = Schools::first($data->id);

        //eliminar imagen anterior
        $photoExists = file_exists(DIR_IMG . $school->photo);
        if ($photoExists) {
            unlink(DIR_IMG . $school->photo);
        }

        $result = Schools::delete((int)$data->id);

        return redirect()->route('schools.index');
    }


    public function myschool()
    {
        $school = session()->user();

        $school = Schools::first($school->school_id);
        // dd($school);

        return view('schools.myschool', [
            'titleHead' => 'Panel Institución',
            'school' => $school,
        ]);
    }
}
