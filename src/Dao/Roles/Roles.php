<?php

namespace Dao\Roles;

use Dao\Table;

class Roles extends Table
{
    public static function obtenerRoles()
    {
        $sqlstr = 'SELECT * FROM roles;';
        $roles = self::obtenerRegistros($sqlstr, []);
        return $roles;
    }
    public static function obtenerRolPorId($id)
    {
        $sqlstr = 'SELECT * FROM roles WHERE rolescod = :rolescod;';
        $rol = self::obtenerUnRegistro($sqlstr, ["rolescod" => $id]);
        return $rol;
    }
    

    // agregar un rol con código aleatorio
    public static function agregarRol($rol)
    {
        // Generar un código aleatorio para el rol
        //$rol['rolescod'] = self::generarCodigoAleatorio(10);  // Genera un código de 10 caracteres
        $sqlstr = 'INSERT INTO roles (rolescod, rolesdsc, rolesest) 
                VALUES (:rolescod, :rolesdsc, :rolesest);';

        return self::executeNonQuery($sqlstr, $rol);
    }

    public static function actualizarRol($rol)
    {
        $sqlstr = 'UPDATE roles SET rolesdsc = :rolesdsc, 
                    rolesest = :rolesest 
                    WHERE rolescod = :rolescod;';
        return self::executeNonQuery($sqlstr, $rol);
    }
    public static function eliminarRol($rolescod)
    {
        $sqlstr = 'DELETE FROM roles WHERE rolescod = :rolescod;';
        return self::executeNonQuery($sqlstr, ["rolescod" => $rolescod]);
    }
}
