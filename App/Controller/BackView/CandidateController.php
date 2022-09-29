<?php

namespace App\Controller\BackView;

use System\Controller;
use App\Model\Candidates;
use Intervention\Image\ImageManagerStatic as Image;

class CandidateController extends Controller
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
        $schoolID = session()->user()->school_id;

        $candidates = Candidates::where('school_id', $schoolID)->get();
        if (is_object($candidates)) {
            $candidates = [$candidates];
        }

        return view('candidates/index', [
            'titleHead' => 'panel de candidatos',
            'candidates' => $candidates
        ]);
    }

    public function create()
    {
        return view('candidates/create', [
            'titleHead' => 'panel de candidatos',
        ]);
    }

    public function store()
    {
        $data = $this->request()->getInput();
        // dd($data);

        $valid = $this->validate($data, [
            'fullname' => 'required|alpha_space|min:3|max:100',
            'dni' => 'required|integer|between:8,8',
            'photo' => 'requiredFile',
            'logo' => 'requiredFile',
            'group_name' => 'required|alpha_space|min:3|max:120',
            'estado' => 'alpha_numeric',
        ]);

        if ($valid !== true) {
            // $data->photo = null;
            // $data->logo = null;
            return back()->route('candidates.create', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {
            if (!empty($data->photo["tmp_name"]) && !empty($data->logo["tmp_name"])) {
                //generar nombre unico para la imagen
                $namePhoto = md5(uniqid(rand(), true)) . '.jpg';
                $nameLogo = md5(uniqid(rand(), true)) . '.jpg';
                //modificar imagen
                $imagePhoto = Image::make($data->photo['tmp_name'])->fit(200, 200);
                $imageLogo = Image::make($data->logo['tmp_name'])->fit(200, 200);
                //agregar al objeto
                $data->photo = $namePhoto;
                $data->logo = $nameLogo;

                //guardar imagen
                if (!is_dir(DIR_IMG)) {
                    mkdir(DIR_IMG);
                }

                $imagePhoto->save(DIR_IMG . $namePhoto);
                $imageLogo->save(DIR_IMG . $nameLogo);
            } else {
                $data->photo = null;
                $data->logo = null;
            }

            $data->school_id = session()->user()->school_id;

            $result = Candidates::create($data);

            return redirect()->route('candidates.index');
        }
    }

    public function edit()
    {
        $id = $this->request()->getInput();

        if (empty((array)$id)) {
            $candidato = null;
        } else {
            $candidato = Candidates::first($id->id);
        }
        return view('candidates.edit', [
            'data' => $candidato,
        ]);
    }

    public function update()
    {
        $data = $this->request()->getInput();

        $valid = $this->validate($data, [
            'fullname' => 'required|alpha_space|min:3|max:100',
            'dni' => 'required|integer|between:8,8',
            'group_name' => 'required|alpha_space|min:3|max:100',
            'estado' => 'alpha_numeric',
        ]);
        if ($valid !== true) {
            return back()->route('candidates.create', [
                'err' =>  $valid,
                'data' => $data,
            ]);
        } else {
            if (!empty($data->photo["tmp_name"])) {
                //generar nombre unico para la imagen
                $namePhoto = md5(uniqid(rand(), true)) . '.jpg';
                //modificar imagen
                $imagePhoto = Image::make($data->photo['tmp_name'])->fit(200, 200);
                //agregar al objeto
                $data->photo = $namePhoto;

                $candidate = Candidates::first($data->id);

                //eliminar imagen anterior
                $photoExists = file_exists(DIR_IMG . $candidate->photo);
                if ($photoExists) {
                    unlink(DIR_IMG . $candidate->photo);
                }

                //guardar imagen
                if (!is_dir(DIR_IMG)) {
                    mkdir(DIR_IMG);
                }

                $imagePhoto->save(DIR_IMG . $namePhoto);
            } else {
                $data->photo = null;
            }

            if (!empty($data->logo["tmp_name"])) {
                //generar nombre unico para la imagen
                $nameLogo = md5(uniqid(rand(), true)) . '.jpg';
                //modificar imagen
                $imageLogo = Image::make($data->logo['tmp_name'])->fit(200, 200);
                //agregar al objeto
                $data->logo = $nameLogo;

                $candidate = Candidates::first($data->id);

                //eliminar imagen anterior
                $logoExists = file_exists(DIR_IMG . $candidate->logo);
                if ($logoExists) {
                    unlink(DIR_IMG . $candidate->logo);
                }

                //guardar imagen
                if (!is_dir(DIR_IMG)) {
                    mkdir(DIR_IMG);
                }

                $imageLogo->save(DIR_IMG . $nameLogo);
            } else {
                $data->logo = null;
            }
            // dd($data);
            Candidates::update($data->id, $data);
            return redirect()->route('candidates.index');
        }
    }

    public function destroy()
    {
        $data = $this->request()->getInput();

        $candidate = Candidates::first($data->id);

        //eliminar imagen anterior
        $photoExists = file_exists(DIR_IMG . $candidate->photo);
        if ($photoExists) {
            unlink(DIR_IMG . $candidate->photo);
        }

        $logoExists = file_exists(DIR_IMG . $candidate->logo);
        if ($logoExists) {
            unlink(DIR_IMG . $candidate->logo);
        }

        $result = Candidates::delete((int)$data->id);
        return redirect()->route('candidates.index');
    }
}
