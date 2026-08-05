<?php

/**
 * PHP Version 7.2
 *
 * @category Private
 * @package  Controllers
 * @author   Orlando J Betancourth <orlando.betancourth@gmail.com>
 * @license  MIT http://
 * @version  CVS:1.0.0
 * @link     http://
 */

namespace Controllers;

/**
 * Private Access Controller Base Class
 *
 * @category Public 
 * @package  Controllers
 * @author   Orlando J Betancourth <orlando.betancourth@gmail.com>
 * @license  MIT http://
 * @link     http://
 */
abstract class PrivateController extends PublicController
{
    private function _isAuthorized()
    {
        $userId = \Utilities\Security::getUserId();
        $controllerAuthorized = \Utilities\Security::isAuthorized(
            $userId,
            $this->name,
            "CTR"
        );

        if (!$controllerAuthorized) {
            throw new PrivateNoAuthException();
        }

        if (isset($_GET["mode"])) {

            $function = $this->_getCurrentFunction();

            $actionAuthorized = \Utilities\Security::isAuthorized(
                $userId,
                $function,
                "FNC"
            );


            if (!$actionAuthorized) {
                throw new PrivateNoAuthException();
            }
        }
    }
    private function _isAuthenticated()
    {
        if (!\Utilities\Security::isLogged()) {
            throw new PrivateNoLoggedException();
        }
    }
    protected function isFeatureAutorized($feature): bool
    {
        return \Utilities\Security::isAuthorized(
            \Utilities\Security::getUserId(),
            $feature
        );
    }
    public function __construct()
    {
        parent::__construct();


        if (
            !\Utilities\Security::checkSessionTimeout()
        ) {

            throw new PrivateNoLoggedException();
        }


        $this->_isAuthenticated();

        $this->_isAuthorized();

        $userId = \Utilities\Security::getUserId();
        if ($userId) {
            $roles = \Dao\Security\Security::getRolesByUsuario($userId);

            $caption = "Tu tienda de videojuegos";

            foreach ($roles as $rol) {
                $codigoRol = $rol["rolescod"];

                foreach ($roles as $rol) {

                    $codigoRol = $rol["rolescod"];


                    if ($codigoRol == '1') {
                        $caption = "Panel administrativo";
                        break;
                    }


                    if ($codigoRol == '2') {
                        $caption = "Panel de ventas";
                    }


                    if ($codigoRol == '4') {
                        $caption = "Panel de auditoría";
                    }
                }
            }

            \Utilities\Context::setContext("PANEL_CAPTION", $caption);
        }
    }

    private function _getCurrentFunction()
    {
        $function = $this->name;


        if (isset($_GET["mode"]) && $_GET["mode"] !== "") {

            $function .= "&mode=" . $_GET["mode"];
        }


        return $function;
    }
}
