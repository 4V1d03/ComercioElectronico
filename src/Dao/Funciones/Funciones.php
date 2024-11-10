<?php

namespace Dao\Funciones;

use Dao\Table;

class Funciones extends Table
{
    public static function getFunciones(
        string $partialDsc = "",
        string $status = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {
        $sqlstr = "SELECT f.fncod, f.fndsc, f.fnest, f.fntyp, case when f.fnest = 'ACT' then 'Activo' when f.fnest = 'INA' then 'Inactivo' else 'Sin Asignar' end as fnStatusDsc FROM funciones f";
        $sqlstrCount = "SELECT COUNT(*) as count FROM funciones f";
        $conditions = [];
        $params = [];
        if ($partialDsc != "") {
            $conditions[] = "f.fndsc LIKE :partialDsc";
            $params["partialDsc"] = "%" . $partialDsc . "%";
        }
        if (!in_array($status, ["ACT", "INA", ""])) {
            throw new \Exception("Error Processing Request Status has invalid value");
        }
        if ($status != "") {
            $conditions[] = "f.fnest = :status";
            $params["status"] = $status;
        }
        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }
        if (!in_array($orderBy, ["fncod", "fndsc", "fntyp", ""])) {
            throw new \Exception("Error Processing Request OrderBy has invalid value");
        }
        if ($orderBy != "") {
            $sqlstr .= " ORDER BY " . $orderBy;
            if ($orderDescending) {
                $sqlstr .= " DESC";
            }
        }
        $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
        $pagesCount = ceil($numeroDeRegistros / $itemsPerPage);
        $page = max(0, min($page, $pagesCount - 1));
        $sqlstr .= " LIMIT " . $page * $itemsPerPage . ", " . $itemsPerPage;

        $registros = self::obtenerRegistros($sqlstr, $params);
        return ["funciones" => $registros, "total" => $numeroDeRegistros, "page" => $page, "itemsPerPage" => $itemsPerPage];
    }

    public static function getFuncionById(string $fncod)
    {
        $sqlstr = "SELECT f.fncod, f.fndsc, f.fnest, f.fntyp FROM funciones f WHERE f.fncod = :fncod";
        $params = ["fncod" => $fncod];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertFuncion(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {
        $sqlstr = "INSERT INTO funciones (fncod, fndsc, fnest, fntyp) VALUES (:fncod, :fndsc, :fnest, :fntyp)";
        $params = [
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateFuncion(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {
        $sqlstr = "UPDATE funciones SET fndsc = :fndsc, fnest = :fnest, fntyp = :fntyp WHERE fncod = :fncod";
        $params = [
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteFuncion(string $fncod)
    {
        $sqlstr = "DELETE FROM funciones WHERE fncod = :fncod";
        $params = ["fncod" => $fncod];
        return self::executeNonQuery($sqlstr, $params);
    }
}
