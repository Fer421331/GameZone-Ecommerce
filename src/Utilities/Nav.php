<?php

namespace Utilities;

class Nav
{
    public static function setPublicNavContext()
    {
        $tmpNAVIGATION = Context::getContextByKey("PUBLIC_NAVIGATION");
        if ($tmpNAVIGATION === "") {
            $navigationData = self::getNavFromJson()["public"];
            $saveToSession = intval(Context::getContextByKey("DEVELOPMENT")) !== 1;
            Context::setContext("PUBLIC_NAVIGATION", $navigationData, $saveToSession);
        }
    }

    public static function setNavContext()
    {
        $tmpNAVIGATION = [];
        $userID = Security::getUserId();

        if ($userID) {
            $roles = \Dao\Security\Security::getRolesByUsuario($userID);

            $esAdminOAuditor = false;
            $esVentas = false;
            $esInvitado = true;

            foreach ($roles as $rol) {
                $codigoRol = $rol["rolescod"];
                // 1: Admin, 4: Auditor
                if ($codigoRol == '1' || $codigoRol == '4') {
                    $esAdminOAuditor = true;
                    $esInvitado = false;
                }
                // 2: Ventas
                if ($codigoRol == '2') {
                    $esVentas = true;
                    $esInvitado = false;
                }
            }

            $navigationData = self::getNavFromJson()["private"];

            foreach ($navigationData as $navEntry) {

                if ($navEntry["id"] === "Menu_Logout") {

                    $tmpNAVIGATION[] = $navEntry;
                    continue;
                }
                
                if (!$esInvitado) {

                    if ($esVentas) {
                        $navEntry["nav_label"] = "Menú Ventas";
                    } else {
                        $navEntry["nav_label"] = "Menú Administrativo";
                    }

                    $tmpNAVIGATION[] = $navEntry;
                }
            }
        }

        $saveToSession = intval(Context::getContextByKey("DEVELOPMENT")) !== 1;
        Context::setContext("NAVIGATION", $tmpNAVIGATION, $saveToSession);
    }

    public static function invalidateNavData()
    {
        Context::removeContextByKey("NAVIGATION_DATA");
        Context::removeContextByKey("NAVIGATION");
        Context::removeContextByKey("PUBLIC_NAVIGATION");
    }

    private static function getNavFromJson()
    {
        $jsonContent = Context::getContextByKey("NAVIGATION_DATA");
        if ($jsonContent === "") {
            $filePath = 'nav.config.json';
            if (!file_exists($filePath)) {
                throw new \Exception(sprintf('%s does not exist', $filePath));
            }
            if (!is_readable($filePath)) {
                throw new \Exception(sprintf('%s file is not readable', $filePath));
            }
            $jsonContent = file_get_contents($filePath);
            $saveToSession = intval(Context::getContextByKey("DEVELOPMENT")) !== 1;
            Context::setContext("NAVIGATION_DATA", $jsonContent, $saveToSession);
        }
        $jsonData = json_decode($jsonContent, true);
        return $jsonData;
    }

    private function __construct() {}
    private function __clone() {}
}
