<?php

namespace Dao\Security;

use Dao\Table;

class Roles extends Table
{
    public static function getRoles(
        $partialName,
        $status,
        $orderBy,
        $desc,
        $page,
        $itemsPerPage
    ) {
        $sql = "SELECT rolescod, rolesdsc, rolesest FROM roles";
        $count = "SELECT COUNT(*) as total FROM roles";

        $where = [];
        $params = [];

        if ($partialName !== "") {
            $where[] = "rolesdsc LIKE :name";
            $params["name"] = "%$partialName%";
        }

        if ($status !== "") {
            $where[] = "rolesest = :status";
            $params["status"] = $status;
        }

        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
            $count .= " WHERE " . implode(" AND ", $where);
        }

        if (in_array($orderBy, ["rolescod", "rolesdsc"])) {
            $sql .= " ORDER BY $orderBy " . ($desc ? "DESC" : "");
        }

        $total = self::obtenerUnRegistro(
            $count,
            $params
        )["total"];

        $sql .= " LIMIT " . ($page * $itemsPerPage) . ", $itemsPerPage";

        return [
            "roles" => self::obtenerRegistros($sql, $params),
            "total" => $total
        ];
    }


    public static function getRolById($id)
    {
        return self::obtenerUnRegistro(
            "
            SELECT 
                rolescod,
                rolesdsc,
                rolesest
            FROM roles
            WHERE rolescod = :id
            ",
            [
                "id" => $id
            ]
        );
    }


    public static function insertRol(
        $rolescod,
        $rolesdsc,
        $rolesest
    ) {
        return self::executeNonQuery(
            "
            INSERT INTO roles
            (
                rolescod,
                rolesdsc,
                rolesest
            )
            VALUES
            (
                :rolescod,
                :rolesdsc,
                :rolesest
            )
            ",
            [
                "rolescod" => $rolescod,
                "rolesdsc" => $rolesdsc,
                "rolesest" => $rolesest
            ]
        );
    }


    public static function updateRol(
        $rolescod,
        $rolesdsc,
        $rolesest
    ) {
        return self::executeNonQuery(
            "
            UPDATE roles
            SET
                rolesdsc = :rolesdsc,
                rolesest = :rolesest
            WHERE rolescod = :rolescod
            ",
            [
                "rolescod" => $rolescod,
                "rolesdsc" => $rolesdsc,
                "rolesest" => $rolesest
            ]
        );
    }


    public static function deleteRol($rolescod)
    {
        return self::executeNonQuery(
            "
            DELETE FROM roles
            WHERE rolescod = :rolescod
            ",
            [
                "rolescod" => $rolescod
            ]
        );
    }
}