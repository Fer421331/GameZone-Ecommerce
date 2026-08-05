<?php

namespace Utilities;

use Dao\Security\Security as DaoSecurity;

class Security
{
    private const SESSION_TIMEOUT = 1800; // 30 minutos
    private function __construct() {}
    private function __clone() {}
    public static function logout($message = "")
    {
        unset($_SESSION["login"]);

        \Utilities\Context::removeContextByKey("NAVIGATION");
        \Utilities\Context::removeContextByKey("PANEL_CAPTION");
        \Utilities\Context::removeContextByKey("USER_MENU");


        if ($message !== "") {

            $_SESSION["sessionMessage"] = $message;
        }


        session_regenerate_id(true);
    }
    public static function login(
        $userId,
        $userName,
        $userEmail,
        $rol = "",
        $rolNombre = ""
    ) {

        session_regenerate_id(true);

        $_SESSION["login"] = array(

            "isLogged" => true,

            "userId" => $userId,

            "userName" => $userName,

            "userEmail" => $userEmail,

            "rol" => $rol,

            "rolNombre" => $rolNombre,

            "lastActivity" => time()

        );
    }
    public static function isLogged(): bool
    {
        return isset($_SESSION["login"]) && $_SESSION["login"]["isLogged"];
    }
    public static function checkSessionTimeout(): bool
    {

        if (!self::isLogged()) {
            return false;
        }


        if (
            !isset($_SESSION["login"]["lastActivity"])
        ) {

            $_SESSION["login"]["lastActivity"] = time();

            return true;
        }


        $inactiveTime =
            time() - $_SESSION["login"]["lastActivity"];


        if ($inactiveTime > self::SESSION_TIMEOUT) {

            self::logout();


            $_SESSION["sessionMessage"] =
                "Su sesión se cerró por inactividad.";

            return false;
        }


        $_SESSION["login"]["lastActivity"] = time();


        return true;
    }
    public static function getUser()
    {
        if (isset($_SESSION["login"])) {
            return $_SESSION["login"];
        }
        return false;
    }
    public static function getUserId()
    {
        if (isset($_SESSION["login"])) {
            return $_SESSION["login"]["userId"];
        }
        return 0;
    }
    public static function isAuthorized($userId, $function, $type = 'FNC'): bool
    {
        if (\Utilities\Context::getContextByKey("DEVELOPMENT") == "1") {
            $functionInDb = DaoSecurity::getFeature($function);
            if (!$functionInDb) {
                DaoSecurity::addNewFeature($function, $function, "ACT", $type);
            }
        }
        return DaoSecurity::getFeatureByUsuario($userId, $function);
    }
    public static function isInRol($userId, $rol): bool
    {
        if (\Utilities\Context::getContextByKey("DEVELOPMENT") == "1") {
            $rolInDb = DaoSecurity::getRol($rol);
            if (!$rolInDb) {
                DaoSecurity::addNewRol($rol, $rol, "ACT");
            }
        }
        return DaoSecurity::isUsuarioInRol($userId, $rol);
    }
}
