<?php

namespace App\Model;

use System\Model;

class Students extends Model
{
    /**
     * nombre de la tabla
     */
    protected static $table       = 'students';
    /**
     * nombre primary key
     */
    protected static $primaryKey  = 'id';
    /**
     * nombre de la columnas de la tabla
     */
    protected static $allowedFields = ['fullname', 'dni', 'password', 'school_id', 'votinggroup_id', 'candidate_id', 'studentrol_id'];
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

    public static function createStudents($school_id, $dataStudents)
    {
        //query para eliminar estudiantes del ususario
        $sql = "DELETE FROM `students` WHERE school_id = $school_id";
        self::querySimple($sql);

        //query para insertar los permisos del rol
        //INSERT INTO `votinggroups` (`fullname`, `dni`,`votinggroup_id`,`school_id`,`password`) VALUES ('carlos', '45253665','3','3','asdsdasdad'),('juan', '58699875','3','3','fgasad') ;
        $sql2 = "INSERT INTO `students` (`fullname`, `dni`,`votinggroup_id`,`school_id`,`password`) VALUES ";

        foreach ($dataStudents as $k => $v) {
            // dd($value);
            $sql2 .= "('$v[fullname]', '$v[dni]','$v[votinggroup_id]','$v[school_id]','$v[password]'),";
        }

        $sql2 = substr($sql2, 0, -1);

        self::querySimple($sql2);
    }

    public static function deleteStudentSchool($id)
    {
        $sql = "DELETE FROM `students` WHERE school_id = $id";
        self::querySimple($sql);
    }

    public static function getStudents($school_id)
    {
        $sql = "SELECT students.id, students.fullname, students.dni, students.candidate_id, students.updated_at, students.school_id, votinggroups.group_name FROM students INNER JOIN votinggroups ON students.votinggroup_id = votinggroups.id WHERE students.school_id = $school_id";

        return self::querySimple($sql);
    }
}
