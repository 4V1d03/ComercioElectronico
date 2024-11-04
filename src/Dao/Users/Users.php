<?php

namespace Dao\Users;

use Dao\Table;

class Users extends Table
{
    public static function getUsers(
        string $partialName = "",
        string $status = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {
        $sqlstr = "SELECT u.usercod, u.useremail, u.username, u.userfching, u.userest, case when u.userest = 'ACT' then 'Activo' when u.userest = 'INA' then 'Inactivo' else 'Sin Asignar' end as userStatusDsc FROM usuario u";
        $sqlstrCount = "SELECT COUNT(*) as count FROM usuario u";
        $conditions = [];
        $params = [];
        if ($partialName != "") {
            $conditions[] = "u.username LIKE :partialName";
            $params["partialName"] = "%" . $partialName . "%";
        }
        if (!in_array($status, ["ACT", "INA", ""])) {
            throw new \Exception("Error Processing Request Status has invalid value");
        }
        if ($status != "") {
            $conditions[] = "u.userest = :status";
            $params["status"] = $status;
        }
        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }
        if (!in_array($orderBy, ["usercod", "username", "useremail", ""])) {
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
        return ["users" => $registros, "total" => $numeroDeRegistros, "page" => $page, "itemsPerPage" => $itemsPerPage];
    }

    public static function getUserById(int $usercod)
    {
        $sqlstr = "SELECT u.usercod, u.useremail, u.username, u.userfching, u.userest FROM usuario u WHERE u.usercod = :usercod";
        $params = ["usercod" => $usercod];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertUser(
        string $useremail,
        string $username,
        string $userpswd,
        string $userest
    ) {
        $sqlstr = "INSERT INTO usuario (useremail, username, userpswd, userest, userfching) VALUES (:useremail, :username, :userpswd, :userest, NOW())";
        $params = [
            "useremail" => $useremail,
            "username" => $username,
            "userpswd" => password_hash($userpswd, PASSWORD_DEFAULT),
            "userest" => $userest
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateUser(
        int $usercod,
        string $useremail,
        string $username,
        string $userest
    ) {
        $sqlstr = "UPDATE usuario SET useremail = :useremail, username = :username, userest = :userest WHERE usercod = :usercod";
        $params = [
            "usercod" => $usercod,
            "useremail" => $useremail,
            "username" => $username,
            "userest" => $userest
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteUser(int $usercod)
    {
        $sqlstr = "DELETE FROM usuario WHERE usercod = :usercod";
        $params = ["usercod" => $usercod];
        return self::executeNonQuery($sqlstr, $params);
    }
}
