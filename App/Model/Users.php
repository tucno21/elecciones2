<?php

namespace App\Model;

use System\Model;

class Users extends Model
{
    /**
     * nombre de la tabla
     */
    protected static $table       = 'users';
    /**
     * primary key
     */
    protected static $primaryKey  = 'id';
    /**
     * nombre de la columnas de la tabla
     */
    protected static $allowedFields = ['fullname', 'email', 'password', 'school_id', 'rol_id', 'status'];

    /**
     * obtener los datos de la tabla en 'array' u 'object'
     */
    protected static $returnType     = 'object';
    /**
     * si hay un campo de contraseña cifrar (true/false)
     */
    protected static $passEncrypt = true;
    /**
     * el campo debe ser el mismo $allowedFields
     * password_hash($password, PASSWORD_BCRYPT)
     * password_verify(Input['password'], $result->password) //true - false;
     */
    protected static $password = 'password'; //


    /**
     * nombre de la columnas de registro y actualizacion de fechas
     */
    /**
     * puede eliminar si desea estos campos si no lo rquiere
     * si desea que el framework registre las fechas para la creacion o  actualizacion
     */
    protected static $useTimestamps   = true;
    /**
     * $createdField debe ser DATETIME o TIMESTAMPS con condicion null
     * $$updatedField debe ser TIMESTAMPS con condicion null
     * el framework se encarga de enviar las fechas y no BD
     * colocar el nombre de los campos de fecha de la BD
     */
    protected static $createdField    = 'created_at';
    protected static $updatedField    = 'updated_at';

    public static function dataUsers()
    {
        $query = "SELECT users.id, users.email, users.fullname, users.status, roles.rol_name, schools.name as school_name FROM users inner JOIN roles ON users.rol_id = roles.id inner JOIN schools ON users.school_id = schools.id";

        $data = parent::querySimple($query);

        return $data;
    }

    public static function authUser($email)
    {
        $query = "SELECT users.id, users.email, users.fullname, users.status,users.school_id,users.rol_id, schools.name as school_name, schools.color, schools.colorletter  FROM users inner JOIN schools ON users.school_id = schools.id WHERE users.email = '$email'";

        $data = parent::querySimple($query);

        return $data;
    }
}
