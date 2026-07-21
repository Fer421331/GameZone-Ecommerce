<?php

namespace Dao\Security;

if (version_compare(phpversion(), '7.4.0', '<')) {
    define('PASSWORD_ALGORITHM', 1);  //BCRYPT
} else {
    define('PASSWORD_ALGORITHM', '2y');  //BCRYPT
}
/*
usercod     bigint(10) AI PK
useremail   varchar(80)
username    varchar(80)
userpswd    varchar(128)
userfching  datetime
userpswdest char(3)
userpswdexp datetime
userest     char(3)
useractcod  varchar(128)
userpswdchg varchar(128)
usertipo    char(3)

 */

use Exception;

class Security extends \Dao\Table
{
    static public function getUsuarios($filter = "", $page = -1, $items = 0)
    {
        $sqlstr = "";
        if ($filter == "" && $page == -1 && $items == 0) {
            $sqlstr = "SELECT * FROM usuario;";
        } else {
            if ($page == -1 && $items == 0) {
                $sqlstr = sprintf(
                    "SELECT * FROM usuario %s;",
                    $filter
                );
            } else {
                $offset = (($page - 1) * $items);

                $sqlstr = sprintf(
                    "SELECT * FROM usuario %s LIMIT %d, %d;",
                    $filter,
                    $offset,
                    $items
                );
            }
        }

        return self::obtenerRegistros($sqlstr, array());
    }

    static public function newUsuario($email, $password)
    {
        if (!\Utilities\Validators::IsValidEmail($email)) {
            throw new Exception("Correo no es válido");
        }
        if (!\Utilities\Validators::IsValidPassword($password)) {
            throw new Exception("Contraseña debe ser almenos 8 caracteres, 1 número, 1 mayúscula, 1 símbolo especial");
        }

        $newUser = self::_usuarioStruct();

        $hashedPassword = self::_hashPassword($password);

        unset($newUser["usercod"]);
        unset($newUser["userfching"]);
        unset($newUser["userpswdchg"]);

        $newUser["useremail"] = $email;
        $newUser["username"] = "John Doe";
        $newUser["userpswd"] = $hashedPassword;
        $newUser["userpswdest"] = Estados::ACTIVO;
        $newUser["userpswdexp"] = date('Y-m-d', time() + 7776000);  //(3*30*24*60*60) (m d h mi s)
        $newUser["userest"] = Estados::ACTIVO;
        $newUser["useractcod"] = hash("sha256", $email . time());
        $newUser["usertipo"] = UsuarioTipo::PUBLICO;

        $sqlIns = "INSERT INTO `usuario` (`useremail`, `username`, `userpswd`,
            `userfching`, `userpswdest`, `userpswdexp`, `userest`, `useractcod`,
            `userpswdchg`, `usertipo`)
            VALUES
            ( :useremail, :username, :userpswd,
            now(), :userpswdest, :userpswdexp, :userest, :useractcod,
            now(), :usertipo);";

        return self::executeNonQuery($sqlIns, $newUser);
    }

    static public function getUsuarioByEmail($email)
    {
        $sqlstr = "SELECT * from `usuario` where `useremail` = :useremail ;";
        $params = array("useremail" => $email);

        return self::obtenerUnRegistro($sqlstr, $params);
    }

    static private function _saltPassword($password)
    {
        return hash_hmac(
            "sha256",
            $password,
            \Utilities\Context::getContextByKey("PWD_HASH")
        );
    }

    static private function _hashPassword($password)
    {
        return password_hash(self::_saltPassword($password), PASSWORD_ALGORITHM);
    }

    static public function verifyPassword($raw_password, $hash_password)
    {
        return password_verify(
            self::_saltPassword($raw_password),
            $hash_password
        );
    }


    static private function _usuarioStruct()
    {
        return array(
            "usercod"      => "",
            "useremail"    => "",
            "username"     => "",
            "userpswd"     => "",
            "userfching"   => "",
            "userpswdest"  => "",
            "userpswdexp"  => "",
            "userest"      => "",
            "useractcod"   => "",
            "userpswdchg"  => "",
            "usertipo"     => "",
        );
    }

    static public function getFeature($fncod)
    {
        $sqlstr = "SELECT * from funciones where fncod=:fncod;";
        $featuresList = self::obtenerRegistros($sqlstr, array("fncod" => $fncod));
        return count($featuresList) > 0;
    }

    static public function addNewFeature($fncod, $fndsc, $fnest, $fntyp)
    {
        $sqlins = "INSERT INTO `funciones` (`fncod`, `fndsc`, `fnest`, `fntyp`)
            VALUES (:fncod , :fndsc , :fnest , :fntyp );";

        return self::executeNonQuery(
            $sqlins,
            array(
                "fncod" => $fncod,
                "fndsc" => $fndsc,
                "fnest" => $fnest,
                "fntyp" => $fntyp
            )
        );
    }

    static public function getFeatureByUsuario($userCod, $fncod)
    {
        $sqlstr = "select * from
        funciones_roles a inner join roles_usuarios b on a.rolescod = b.rolescod
        where a.fnrolest = 'ACT' and b.roleuserest='ACT' and b.usercod=:usercod
        and a.fncod=:fncod limit 1;";
        $resultados = self::obtenerRegistros(
            $sqlstr,
            array(
                "usercod" => $userCod,
                "fncod" => $fncod
            )
        );
        return count($resultados) > 0;
    }

    static public function getRol($rolescod)
    {
        $sqlstr = "SELECT * from roles where rolescod=:rolescod;";
        $featuresList = self::obtenerRegistros($sqlstr, array("rolescod" => $rolescod));
        return count($featuresList) > 0;
    }

    static public function addNewRol($rolescod, $rolesdsc, $rolesest)
    {
        $sqlins = "INSERT INTO `roles` (`rolescod`, `rolesdsc`, `rolesest`)
        VALUES (:rolescod, :rolesdsc, :rolesest);";

        return self::executeNonQuery(
            $sqlins,
            array(
                "rolescod" => $rolescod,
                "rolesdsc" => $rolesdsc,
                "rolesest" => $rolesest
            )
        );
    }

    static public function isUsuarioInRol($userCod, $rolescod)
    {
        $sqlstr = "select * from roles a inner join
        roles_usuarios b on a.rolescod = b.rolescod where a.rolesest = 'ACT'
        and b.usercod=:usercod and a.rolescod=:rolescod limit 1;";
        $resultados = self::obtenerRegistros(
            $sqlstr,
            array(
                "usercod" => $userCod,
                "rolescod" => $rolescod
            )
        );
        return count($resultados) > 0;
    }

    static public function getRolesByUsuario($userCod)
    {
        $sqlstr = "SELECT *
        FROM roles a
        INNER JOIN roles_usuarios b
            ON a.rolescod = b.rolescod
        WHERE a.rolesest = 'ACT'
        AND b.roleuserest = 'ACT'
        AND b.usercod = :usercod;";

        $resultados = self::obtenerRegistros(
            $sqlstr,
            array(
                "usercod" => $userCod
            )
        );

        return $resultados;
    }

    static public function removeRolFromUser($userCod, $rolescod)
    {
        $sqldel = "UPDATE roles_usuarios set roleuserest='INA' 
        where rolescod=:rolescod and usercod=:usercod;";
        return self::executeNonQuery(
            $sqldel,
            array("rolescod" => $rolescod, "usercod" => $userCod)
        );
    }

    static public function removeFeatureFromRol($fncod, $rolescod)
    {
        $sqldel = "UPDATE funciones_roles set fnrolest='INA'
    where fncod=:fncod and rolescod=:rolescod;";
        return self::executeNonQuery(
            $sqldel,
            array("fncod" => $fncod, "rolescod" => $rolescod)
        );
    }
    static public function getUnAssignedFeatures($rolescod)
    {
        $sqlstr = "SELECT *
        FROM funciones
        WHERE fnest = 'ACT'
        AND fncod NOT IN (
            SELECT fncod
            FROM funciones_roles
            WHERE rolescod = :rolescod
            AND fnrolest = 'ACT'
        );";

        return self::obtenerRegistros(
            $sqlstr,
            array(
                "rolescod" => $rolescod
            )
        );
    }
    static public function getUnAssignedRoles($userCod)
    {
        $sqlstr = "SELECT *
        FROM roles
        WHERE rolesest = 'ACT'
        AND rolescod NOT IN (
            SELECT rolescod
            FROM roles_usuarios
            WHERE usercod = :usercod
            AND roleuserest = 'ACT'
        );";

        return self::obtenerRegistros(
            $sqlstr,
            array(
                "usercod" => $userCod
            )
        );
    }

    static public function assignRolToUser($userCod, $rolescod)
    {
        $sqlExiste = "SELECT COUNT(*) cantidad
                  FROM roles_usuarios
                  WHERE usercod = :usercod
                  AND rolescod = :rolescod;";

        $existe = self::obtenerUnRegistro(
            $sqlExiste,
            [
                "usercod" => $userCod,
                "rolescod" => $rolescod
            ]
        );

        if ($existe["cantidad"] > 0) {

            $sqlUpdate = "UPDATE roles_usuarios
                      SET roleuserest='ACT',
                          roleuserfch = NOW()
                      WHERE usercod=:usercod
                      AND rolescod=:rolescod;";

            return self::executeNonQuery(
                $sqlUpdate,
                [
                    "usercod" => $userCod,
                    "rolescod" => $rolescod
                ]
            );
        }

        $sqlInsert = "INSERT INTO roles_usuarios
        (usercod, rolescod, roleuserest, roleuserfch, roleuserexp)
        VALUES
        (:usercod,:rolescod,'ACT',NOW(),NULL);";

        return self::executeNonQuery(
            $sqlInsert,
            [
                "usercod" => $userCod,
                "rolescod" => $rolescod
            ]
        );
    }

    static public function assignFeatureToRol($rolescod, $fncod)
    {
        $sqlExiste = "SELECT COUNT(*) cantidad
                  FROM funciones_roles
                  WHERE rolescod = :rolescod
                  AND fncod = :fncod;";

        $existe = self::obtenerUnRegistro(
            $sqlExiste,
            [
                "rolescod" => $rolescod,
                "fncod" => $fncod
            ]
        );

        if ($existe["cantidad"] > 0) {

            $sqlUpdate = "UPDATE funciones_roles
                      SET fnrolest='ACT'
                      WHERE rolescod=:rolescod
                      AND fncod=:fncod;";

            return self::executeNonQuery(
                $sqlUpdate,
                [
                    "rolescod" => $rolescod,
                    "fncod" => $fncod
                ]
            );
        }

        $sqlInsert = "INSERT INTO funciones_roles
        (rolescod, fncod, fnrolest, fnexp)
        VALUES
        (:rolescod,:fncod,'ACT',NULL);";

        return self::executeNonQuery(
            $sqlInsert,
            [
                "rolescod" => $rolescod,
                "fncod" => $fncod
            ]
        );
    }
    static public function getRoles()
    {
        $sqlstr = "SELECT * FROM roles WHERE rolesest='ACT';";
        return self::obtenerRegistros($sqlstr, []);
    }

    static public function getFuncionesByRol($rolescod)
    {
        $sqlstr = "SELECT f.*
        FROM funciones f
        INNER JOIN funciones_roles fr
            ON f.fncod = fr.fncod
        WHERE fr.rolescod = :rolescod
        AND fr.fnrolest = 'ACT';";

        return self::obtenerRegistros(
            $sqlstr,
            [
                "rolescod" => $rolescod
            ]
        );
    }
    private function __construct() {}
    private function __clone() {}
}


 