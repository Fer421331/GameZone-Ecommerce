<?php

namespace Controllers\Sec;

use Controllers\PublicController;
use \Utilities\Validators;
use Utilities\Bitacora;
use Exception;

class Register extends PublicController
{
    private $txtNombre = "";
    private $txtEmail = "";
    private $txtPswd = "";

    private $errorNombre = "";
    private $errorEmail = "";
    private $errorPswd = "";

    private $hasErrors = false;

    public function run(): void
    {

        if ($this->isPostBack()) {
            $this->txtNombre = trim($_POST["txtNombre"] ?? "");
            $this->txtEmail = trim($_POST["txtEmail"] ?? "");
            $this->txtPswd = $_POST["txtPswd"] ?? "";
            //validaciones
            if (Validators::IsEmpty($this->txtNombre)) {
                $this->errorNombre = "Debe ingresar su nombre.";
                $this->hasErrors = true;
            }
            if (!(Validators::IsValidEmail($this->txtEmail))) {
                $this->errorEmail = "El correo no tiene el formato adecuado";
                $this->hasErrors = true;
            }
            if (!Validators::IsValidPassword($this->txtPswd)) {
                $this->errorPswd = "La contraseña debe tener al menos 8 caracteres una mayúscula, un número y un caracter especial.";
                $this->hasErrors = true;
            }

            if (!$this->hasErrors) {


                $usuarioExiste = \Dao\Security\Security::getUsuarioByEmail($this->txtEmail);

                if ($usuarioExiste) {

                    $this->errorEmail = "Este correo ya se encuentra registrado.";
                    $this->hasErrors = true;

                    Bitacora::registrar(
                        "Registro",
                        "Intento de registro fallido",
                        "Correo ya registrado: " . $this->txtEmail,
                        "WAR"
                    );
                }

                if (!$this->hasErrors) {

                    try {

                        if (\Dao\Security\Security::newUsuario(
                            $this->txtNombre,
                            $this->txtEmail,
                            $this->txtPswd
                        )) {

                            Bitacora::registrar(
                                "Registro",
                                "Usuario registrado correctamente",
                                "Correo: " . $this->txtEmail,
                                "INS"
                            );

                            \Utilities\Site::redirectToWithMsg(
                                "index.php?page=sec_login",
                                "¡Usuario Registrado Satisfactoriamente!"
                            );
                        }
                    } catch (Exception $ex) {

                        die($ex);
                    }
                }
            }
        }
        $viewData = get_object_vars($this);
        \Views\Renderer::render("security/sigin", $viewData);
    }
}
