<?php

namespace Controllers\Sec;

use Utilities\Bitacora;

class Login extends \Controllers\PublicController
{
    private $txtEmail = "";
    private $txtPswd = "";
    private $errorEmail = "";
    private $errorPswd = "";
    private $generalError = "";
    private $sessionMessage = "";
    private $hasError = false;

    public function run(): void
    {
        if ($this->isPostBack()) {
            $this->txtEmail = $_POST["txtEmail"] ?? "";
            $this->txtPswd = $_POST["txtPswd"] ?? "";

            if (!\Utilities\Validators::IsValidEmail($this->txtEmail)) {
                $this->errorEmail = "¡Correo no tiene el formato adecuado!";
                $this->hasError = true;
            }
            if (\Utilities\Validators::IsEmpty($this->txtPswd)) {
                $this->errorPswd = "¡Debe ingresar una contraseña!";
                $this->hasError = true;
            }
            if (! $this->hasError) {
                if ($dbUser = \Dao\Security\Security::getUsuarioByEmail($this->txtEmail)) {
                    if ($dbUser["userest"] != \Dao\Security\Estados::ACTIVO) {

                        $this->generalError = "¡Credenciales son incorrectas!";
                        $this->hasError = true;

                        Bitacora::registrar(
                            "Login",
                            "Intento de inicio de sesión fallido",
                            "Usuario inactivo: " . $dbUser["useremail"],
                            "WAR"
                        );
                    } else if (!\Dao\Security\Security::verifyPassword($this->txtPswd, $dbUser["userpswd"])) {

                        $this->generalError = "¡Credenciales son incorrectas!";
                        $this->hasError = true;

                        Bitacora::registrar(
                            "Login",
                            "Intento de inicio de sesión fallido",
                            "Contraseña incorrecta para: " . $dbUser["useremail"],
                            "WAR"
                        );
                    }
                    if (! $this->hasError) {
                        \Utilities\Security::login(
                            $dbUser["usercod"],
                            $dbUser["username"],
                            $dbUser["useremail"]
                        );
                        $roles = \Dao\Security\Security::getRolesByUsuario(
                            $dbUser["usercod"]
                        );

                        $irAlMenu = false;

                        foreach ($roles as $rol) {

                            if (
                                $rol["rolescod"] == "1" ||
                                $rol["rolescod"] == "2" ||
                                $rol["rolescod"] == "4"
                            ) {
                                $irAlMenu = true;
                                break;
                            }
                        }


                        if ($irAlMenu) {

                            \Utilities\Site::redirectTo(
                                "index.php?page=Menu_Menu"
                            );
                        } else {

                            \Utilities\Site::redirectTo(
                                "index.php"
                            );
                        }
                        Bitacora::registrar(
                            "Login",
                            "Inicio de sesión exitoso",
                            "Usuario: " . $dbUser["useremail"],
                            "LOG"
                        );
                        $userId = $dbUser["usercod"];

                        if (
                            \Utilities\Security::isInRol($userId, "1") ||
                            \Utilities\Security::isInRol($userId, "2") ||
                            \Utilities\Security::isInRol($userId, "4")
                        ) {
                            \Utilities\Site::redirectTo("index.php?page=Menu_Menu");
                        }

                        \Utilities\Site::redirectTo("index.php");
                    }
                } else {
                    error_log(
                        sprintf(
                            "ERROR: %s trato de ingresar",
                            $this->txtEmail
                        )
                    );
                    $this->generalError = "¡Credenciales son incorrectas!";
                    Bitacora::registrar(
                        "Login",
                        "Intento de inicio de sesión fallido",
                        "Usuario inexistente: " . $this->txtEmail,
                        "WAR"
                    );
                }
            }
        }
        if (isset($_SESSION["sessionMessage"])) {

            $this->sessionMessage =
                $_SESSION["sessionMessage"];

            unset($_SESSION["sessionMessage"]);
        }
        $dataView = get_object_vars($this);
        \Views\Renderer::render("security/login", $dataView);
    }
}
