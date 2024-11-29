<?php

namespace Dao\Usuarios;
use Dao\Table;

class Usuarios extends Table
{
    public static function obtenerUsuarios()
    {
        $sqlstr = 'SELECT * FROM usuario;';
        $usuarios = self::obtenerRegistros($sqlstr, []);
        return $usuarios;
    }

    public static function obtenerUsuarioPorId($id)
    {
        $sqlstr = 'SELECT * FROM usuario WHERE usercod = :usercod;';
        $usuario = self::obtenerUnRegistro($sqlstr, ["usercod" => $id]);
        return $usuario;
    }

    public static function agregarUsuario($usuario)
    {
        unset($usuario['usercod']);
        $sqlstr = 'INSERT INTO usuario (useremail, username, userpswd, userfching, userpswdest, userpswdexp, userest, useractcod, userpswdchg, usertipo) 
                    VALUES (:useremail, :username, :userpswd, :userfching, :userpswdest, :userpswdexp, :userest, :useractcod, :userpswdchg, :usertipo);';
        return self::executeNonQuery($sqlstr, $usuario);
    }

    public static function actualizarUsuario($usuario)
    {
        $sqlstr = 'UPDATE usuario SET useremail = :useremail, 
                    username = :username, 
                    userpswd = :userpswd, 
                    userfching = :userfching, 
                    userpswdest = :userpswdest, 
                    userpswdexp = :userpswdexp, 
                    userest = :userest, 
                    useractcod = :useractcod, 
                    userpswdchg = :userpswdchg, 
                    usertipo = :usertipo
                    WHERE usercod = :usercod;';
        return self::executeNonQuery($sqlstr, $usuario);
    }

    public static function eliminarUsuario($usercod)
    {
        $sqlstr = 'DELETE FROM usuario WHERE usercod = :usercod;';
        return self::executeNonQuery($sqlstr, ["usercod" => $usercod]);
    }
}
