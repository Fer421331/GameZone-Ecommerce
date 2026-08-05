<?php

namespace Controllers\Perfil;

use Controllers\PrivateController;
use Dao\Perfil\Perfil as PerfilDao;
use Dao\Security\Security as SecurityDao;
use Utilities\Security;
use Utilities\Bitacora;
use Utilities\Site;
use Views\Renderer;

class Perfil extends PrivateController
{
    private array $viewData = [];

    public function run(): void
    {
        $usercod = strval(Security::getUserId());

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $accion = $_POST["accion"] ?? "";


            if ($accion === "perfil") {

                $username = trim($_POST["username"] ?? "");
                $useremail = trim($_POST["useremail"] ?? "");

                if ($username === "") {

                    $this->viewData["error"] =
                        "El nombre de usuario es obligatorio.";
                }


                if (
                    !isset($this->viewData["error"]) &&
                    !filter_var($useremail, FILTER_VALIDATE_EMAIL)
                ) {

                    $this->viewData["error"] =
                        "El correo no es válido.";
                }


                if (
                    !isset($this->viewData["error"]) &&
                    PerfilDao::existeCorreo(
                        $useremail,
                        $usercod
                    )
                ) {

                    Bitacora::registrar(
                        "Perfil",
                        "Correo existente",
                        "Usuario ID: " . $usercod,
                        "WAR"
                    );


                    $this->viewData["error"] =
                        "El correo ya pertenece a otro usuario.";
                }


                if (!isset($this->viewData["error"])) {


                    if (
                        PerfilDao::updatePerfil(
                            $usercod,
                            $username,
                            $useremail
                        )
                    ) {


                        $_SESSION["login"]["userName"] =
                            $username;


                        $_SESSION["login"]["userEmail"] =
                            $useremail;


                        Bitacora::registrar(
                            "Perfil",
                            "Perfil actualizado",
                            "Usuario ID: " . $usercod,
                            "LOG"
                        );


                        Site::redirectToWithMsg(
                            "index.php?page=Perfil_Perfil",
                            "Perfil actualizado correctamente."
                        );


                        return;
                    }


                    $this->viewData["error"] =
                        "No se pudieron guardar los cambios.";
                }
            }



            if ($accion === "password") {


                $passwordActual =
                    trim($_POST["passwordActual"] ?? "");


                $passwordNueva =
                    trim($_POST["passwordNueva"] ?? "");


                $passwordConfirmar =
                    trim($_POST["passwordConfirmar"] ?? "");



                $usuario =
                    SecurityDao::getUsuarioById(
                        $usercod
                    );



                if ($passwordActual === "") {


                    $this->viewData["errorPassword"] =
                        "Debe ingresar la contraseña actual.";
                } elseif (
                    !$usuario ||
                    !SecurityDao::verifyPassword(
                        $passwordActual,
                        $usuario["userpswd"]
                    )
                ) {


                    $this->viewData["errorPassword"] =
                        "La contraseña actual es incorrecta.";
                } elseif ($passwordNueva === "") {


                    $this->viewData["errorPassword"] =
                        "Debe ingresar la nueva contraseña.";
                } elseif (
                    $passwordNueva !== $passwordConfirmar
                ) {


                    $this->viewData["errorPassword"] =
                        "Las contraseñas nuevas no coinciden.";
                } elseif (
                    SecurityDao::verifyPassword(
                        $passwordNueva,
                        $usuario["userpswd"]
                    )
                ) {


                    $this->viewData["errorPassword"] =
                        "La nueva contraseña no puede ser igual a la actual.";
                } elseif (
                    !\Utilities\Validators::IsValidPassword(
                        $passwordNueva
                    )
                ) {


                    $this->viewData["errorPassword"] =
                        "La contraseña debe tener mínimo 8 caracteres, una mayúscula, un número y un símbolo.";
                } else {


                    if (
                        SecurityDao::changePassword(
                            $usercod,
                            $passwordNueva
                        )
                    ) {


                        Bitacora::registrar(
                            "Perfil",
                            "Cambio de contraseña",
                            "Usuario ID: " . $usercod,
                            "UPD"
                        );


                        $this->viewData["successPassword"] =
                            "Contraseña actualizada correctamente.";
                    } else {


                        $this->viewData["errorPassword"] =
                            "No se pudo actualizar la contraseña.";
                    }
                }
            }
        }



        $perfil =
            PerfilDao::getPerfil(
                $usercod
            );



        if (!$perfil) {


            Site::redirectToWithMsg(
                "index.php",
                "No se encontró información del usuario."
            );


            return;
        }



        $estadisticas =
            PerfilDao::getEstadisticas(
                $usercod
            );



        $this->viewData =
            array_merge(
                $perfil,
                $estadisticas,
                $this->viewData
            );



        $this->viewData["mostrarRol"] =
            Security::isInRol(
                $usercod,
                "1"
            )
            ||
            Security::isInRol(
                $usercod,
                "4"
            );



        Renderer::render(
            "perfil/perfil",
            $this->viewData
        );
    }
}
