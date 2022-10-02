<?php

namespace App\Controller\BackView;

require DIR_APP . '/Library/phpqrcode/phpqrcode.php';

use System\Controller;
use App\Library\FPDF\FPDF;
use App\Model\Students;

class QrController extends Controller
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
        $school_id = session()->user()->school_id;
        $students = Students::fullStudent($school_id);

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        $x = 10;
        $y = 12;

        $row = 1;
        $col = 1;

        $i = 0;
        foreach ($students as $k => $s) {
            $nombres = $s->fullname;
            //separar nombre y apellido
            $nombres = explode(',', $nombres);
            $nombre = trim($nombres[1]);
            $apellidos = $nombres[0];

            $texto_qr = $s->dni . '|' . $s->password;
            $ruta_qr = DIR_IMG . 'qr/' . $s->dni . '.png';

            //crear carpeta si no existe
            if (!is_dir(DIR_IMG . 'qr/')) {
                mkdir(DIR_IMG . 'qr/', 0777, true);
            }

            \QRcode::png($texto_qr, $ruta_qr, 'Q', 10, 1);

            // ==============================

            $temp_x = $x;
            $temp_y = $y;

            //color celeste
            $pdf->SetFillColor(139, 216, 242);

            $pdf->SetFont('helvetica', '', 10);
            $pdf->SetXY($temp_x, $temp_y);
            //$pdf->cell(x, y, texto, borde LRTB, salto de linea 0,1, alineacion, color, link)
            $pdf->cell(86, 7, utf8_decode('Elecciones Municipales 2022'), 'RTL', 1, 'C', 1);

            $pdf->SetFillColor(3, 181, 129);
            $pdf->SetFont('helvetica', 'BU', 12);
            $pdf->SetXY($temp_x, $temp_y + 7);
            $pdf->cell(86, 6, 'I.E. ' . utf8_decode($s->name), 'RL', 1, 'C', 1);

            $pdf->SetFillColor(139, 216, 242);
            $pdf->SetXY($temp_x, $temp_y + 13);
            $pdf->cell(86, 2, '', 'RL', 1, 'C', 1);

            $pdf->SetFont('helvetica', '', 7);
            $pdf->SetXY($temp_x, $temp_y + 15);
            $pdf->cell(4, 4, '', 'L', 0, 'C', 1);
            $pdf->cell(82, 4, 'Nombre', 'R', 1, 'L', 1);

            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetXY($temp_x, $temp_y + 19);
            $pdf->cell(4, 4, '', 'L', 0, 'C', 1);
            $pdf->cell(82, 4, utf8_decode($nombre), 'R', 1, 'L', 1);

            $pdf->SetXY($temp_x, $temp_y + 23);
            $pdf->cell(86, 2, '', 'RL', 1, 'C', 1);

            $pdf->SetFont('helvetica', '', 7);
            $pdf->SetXY($temp_x, $temp_y + 25);
            $pdf->cell(4, 4, '', 'L', 0, 'C', 1);
            $pdf->cell(82, 4, 'Apellidos', 'R', 1, 'L', 1);

            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetXY($temp_x, $temp_y + 29);
            $pdf->cell(4, 4, '', 'L', 0, 'C', 1);
            $pdf->cell(82, 4, utf8_decode($apellidos), 'R', 1, 'L', 1);

            $pdf->SetXY($temp_x, $temp_y + 33);
            $pdf->cell(86, 2, '', 'RL', 1, 'C', 1);

            $pdf->SetFont('helvetica', '', 7);
            $pdf->SetXY($temp_x, $temp_y + 35);
            $pdf->cell(4, 4, '', 'L', 0, 'C', 1);
            $pdf->cell(82, 4, 'DNI', 'R', 1, 'L', 1);

            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetXY($temp_x, $temp_y + 39);
            $pdf->cell(4, 4, '', 'L', 0, 'C', 1);
            $pdf->cell(82, 4, $s->dni, 'R', 1, 'L', 1);

            $pdf->SetXY($temp_x, $temp_y + 43);
            $pdf->cell(86, 2, '', 'RL', 1, 'C', 1);

            $pdf->SetFont('helvetica', '', 7);
            $pdf->SetXY($temp_x, $temp_y + 45);
            $pdf->cell(4, 4, '', 'L', 0, 'C', 1);
            $pdf->cell(82, 4, utf8_decode('Mesa de Votación'), 'R', 1, 'L', 1);

            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetXY($temp_x, $temp_y + 49);
            $pdf->cell(4, 4, '', 'L', 0, 'C', 1);
            $pdf->cell(82, 4, $s->group_name, 'R', 1, 'L', 1);

            $pdf->SetXY($temp_x, $temp_y + 53);
            $pdf->cell(86, 2, '', 'RBL', 1, 'C', 1);

            $pdf->Image($ruta_qr, $x + 44, $y + 14, 39, 39, 'PNG');

            if (($i + 1) % 4 == 0) //cantidad de columana en vertical
            {
                $col += 1;

                if ($col > 2) //crea nueva pagina si tiene mas de 
                {
                    $col = 1;
                    $pdf->AddPage();
                    $x = 10;
                    $y = 12;
                } else {
                    $x += 105; //aumentar espacio en horizontal
                    $y = 12; //regresar a la posicion inicial
                }
            } else {
                $y += 69; //aumentar espacio vertical
            }

            $i++;

            //eliminar carpeta
            if (is_dir(DIR_IMG . 'qr/')) {
                unlink($ruta_qr);
            }
        }

        $pdf->Output('I', 'CodigoIdentidad.pdf');
    }
}
