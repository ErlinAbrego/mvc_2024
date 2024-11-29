<?php

namespace Dao\Citas;

use Dao\Table;

class Citas extends Table
{
    public static function obtenerCitas()
    {
        $sqlstr = 'SELECT * FROM Citas;';
        $citas = self::obtenerRegistros($sqlstr, []);
        return $citas;
    }

    public static function obtenerCitasPorUsuario($usercod)
    {
        $sqlstr = 'SELECT * FROM Citas WHERE usercod = :usercod;';
        $citas = self::obtenerRegistros($sqlstr, ["usercod" => $usercod]);
        return $citas;
    }

    public static function obtenerCitaPorId($id)
    {
        $sqlstr = 'SELECT * FROM Citas WHERE CitaID = :CitaID;';
        $cita = self::obtenerUnRegistro($sqlstr, ["CitaID" => $id]);
        return $cita;
    }

    public static function agregarCita($cita)
    {
        try {
            // Validación básica
            if (!isset($cita['usercod'], $cita['FechaCita'], $cita['TipoExamen'], $cita['EstadoCita'])) {
                throw new \Exception("Faltan campos obligatorios en la cita");
            }
            unset($cita['CitaID']);
            $sqlstr = 'INSERT INTO Citas (usercod, FechaCita, TipoExamen, EstadoCita, FechaCreacion, FechaModificacion) 
                    VALUES (:usercod, :FechaCita, :TipoExamen, :EstadoCita, :FechaCreacion, :FechaModificacion);';
            return self::executeNonQuery($sqlstr, $cita);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }



    public static function actualizarCita($cita)
    {
        $sqlstr = 'UPDATE Citas SET usercod = :usercod, 
                    FechaCita = :FechaCita, 
                    TipoExamen = :TipoExamen, 
                    EstadoCita = :EstadoCita, 
                    Confirmada = :Confirmada, 
                    FechaCreacion = :FechaCreacion, 
                    FechaModificacion = :FechaModificacion
                    WHERE CitaID = :CitaID;';
        return self::executeNonQuery($sqlstr, $cita);
    }

    public static function eliminarCita($CitaID)
    {
        $sqlstr = 'DELETE FROM Citas WHERE CitaID = :CitaID;';
        return self::executeNonQuery($sqlstr, ["CitaID" => $CitaID]);
    }
}
