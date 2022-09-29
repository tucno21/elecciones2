<?php

namespace App\Model;

use System\Model;

class Candidates extends Model
{
    /**
     * nombre de la tabla
     */
    protected static $table       = 'candidates';
    /**
     * nombre primary key
     */
    protected static $primaryKey  = 'id';
    /**
     * nombre de la columnas de la tabla
     */
    protected static $allowedFields = ['fullname', 'dni', 'photo', 'logo', 'group_name', 'estado', 'school_id'];
    /**
     * obtener los datos de la tabla en 'array' u 'object'
     */
    protected static $returnType     = 'object';
    /**
     * si hay un campo de contraseña cifrar (true/false)
     */
    protected static $passEncrypt = false;

    protected static $useTimestamps   = false;
}
