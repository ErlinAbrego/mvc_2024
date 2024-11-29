<?php

namespace Dao\Funciones;

use Dao\Table;

class Funciones extends Table
{
    public static function obtenerFunciones()
    {
        $sqlstr = 'SELECT * FROM funciones;';
        $funciones = self::obtenerRegistros($sqlstr, []);
        return $funciones;
    }
    public static function obtenerFuncionPorId($id)
    {
        $sqlstr = 'SELECT * FROM funciones WHERE fncod = :fncod;';
        $funcion = self::obtenerUnRegistro($sqlstr, ["fncod" => $id]);
        return $funcion;
    }

    //Agregar una función con código aleatorio
    public static function agregarFuncion($funcion)
    {
        //$funcion['fncod'] = self::generarCodigoAleatorio(10);  // Genera un código de 10 caracteres
        $sqlstr = 'INSERT INTO funciones (fncod, fndsc, fnest, fntyp) 
                    VALUES (:fncod, :fndsc, :fnest, :fntyp);';
        return self::executeNonQuery($sqlstr, $funcion);
    }

    public static function actualizarFuncion($funcion)
    {
        $sqlstr = 'UPDATE funciones SET fndsc = :fndsc, 
                    fnest = :fnest, 
                    fntyp = :fntyp 
                    WHERE fncod = :fncod;';
        return self::executeNonQuery($sqlstr, $funcion);
    }

    public static function eliminarFuncion($fncod)
    {
        $sqlstr = 'DELETE FROM funciones WHERE fncod = :fncod;';
        return self::executeNonQuery($sqlstr, ["fncod" => $fncod]);
    }
}
