<?php

namespace App\Library\PdfList;

use App\Library\FPDF\FPDF;

class PdfListWall extends FPDF
{
    private $shoolName;
    private $numberMesa;
    private $rutaLogo;
    private $rutaEscudo;
    private $rutaOnpe;


    public function __construct($orientation, $unit, $size, $shoolName, $numberMesa, $rutaLogo, $rutaEscudo, $rutaOnpe)
    {
        parent::__construct($orientation, $unit, $size);

        $this->shoolName = $shoolName;
        $this->numberMesa = $numberMesa;
        $this->rutaLogo = $rutaLogo;
        $this->rutaEscudo = $rutaEscudo;
        $this->rutaOnpe = $rutaOnpe;
    }

    function Header()
    {
        $this->Image($this->rutaLogo, 175, 10, 18);
        $this->Image($this->rutaEscudo, 15, 10, 18);
        $this->Image($this->rutaOnpe, 24, 20, 27);


        $this->SetFont('Arial', '', 10);
        $this->cell(190, 7, utf8_decode('ELECCIÓN DEL MUNICIPIO ESCOLAR'), '', 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->cell(190, 7, utf8_decode('INSTITUCIÓN EDUCATIVA ' . mb_strtoupper($this->shoolName)), '', 1, 'C');
        $this->SetFont('Arial', 'B', 18);
        $this->cell(190, 9, utf8_decode('RELACIÓN DE ELECTORES'), '', 1, 'C');
        $this->SetFont('Arial', '', 8);
        $this->cell(35, 6, utf8_decode('MESA DE SUFRAGIO N°'), '', 1, 'C');
        $this->SetFont('Arial', 'B', 18);
        $this->cell(35, 9, utf8_decode($this->numberMesa), 'RTLB', 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->cell(190, 8, utf8_decode('Ubica tus Apellidos y Nombres, Numero de Orden, en la mesa indica tu  número de orden'), '', 1, 'L');


        //datos
        $this->SetFont('Arial', 'B', 11);
        $this->cell(15, 11, utf8_decode('N°'), 'RTLB', 0, 'C',);
        $this->cell(140, 11, utf8_decode('APELLIDOS Y NOMBRES'), 'RTLB', 0, 'C',);
        $this->cell(35, 11, utf8_decode('DNI'), 'RTLB', 1, 'C',);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 9);
        $this->cell(150, 8, utf8_decode('Para ser pegado en la entrada del Aula de Votación'), '', 0, 'C');
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 8, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 1, 'R');
    }
}
