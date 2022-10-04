<?php

namespace App\Model;

use System\Model;

class StartVoting extends Model
{
    /**
     * nombre de la tabla
     */
    protected static $table       = 'start_voting';
    /**
     * nombre primary key
     */
    protected static $primaryKey  = 'id';
    /**
     * nombre de la columnas de la tabla
     */
    protected static $allowedFields = ['student_id', 'date_start', 'date_end'];
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
