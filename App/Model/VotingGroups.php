<?php

namespace App\Model;

use System\Model;

class VotingGroups extends Model
{
    /**
     * nombre de la tabla
     */
    protected static $table       = 'votinggroups';
    /**
     * nombre primary key
     */
    protected static $primaryKey  = 'id';
    /**
     * nombre de la columnas de la tabla
     */
    protected static $allowedFields = ['group_name', 'school_id'];
    /**
     * obtener los datos de la tabla en 'array' u 'object'
     */
    protected static $returnType     = 'object';
    /**
     * si hay un campo de contraseña cifrar (true/false)
     */
    protected static $passEncrypt = false;

    protected static $useTimestamps   = true;
    /**
     * $createdField debe ser DATETIME o TIMESTAMPS con condicion null
     * $$updatedField debe ser TIMESTAMPS con condicion null
     * el framework se encarga de enviar las fechas y no BD
     * colocar el nombre de los campos de fecha de la BD
     */
    protected static $createdField    = 'created_at';
    protected static $updatedField    = 'updated_at';

    public static function generarMesas($school_id, $grupoMesas)
    {
        //query para eliminar los permisos del permisos del rol
        $sql = "DELETE FROM `votinggroups` WHERE school_id = $school_id";
        self::querySimple($sql);

        //query para insertar los permisos del rol
        //INSERT INTO `roles_permisos` (`permiso_id`, `rol_id`) VALUES ('1', '1'), ('6', '1'), ('2', '1'), ('3', '1');
        $sql2 = "INSERT INTO `votinggroups` (`group_name`, `school_id`) VALUES ";

        foreach ($grupoMesas as $key => $value) {
            $sql2 .= "($value, $school_id),";
        }

        $sql2 = substr($sql2, 0, -1);

        self::querySimple($sql2);
    }
}
