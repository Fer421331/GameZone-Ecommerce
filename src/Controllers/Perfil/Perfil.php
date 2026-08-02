<?php

namespace Controllers\Perfil;

use Controllers\PrivateController;
use Dao\Perfil\Perfil as PerfilDao;
use Utilities\Security;
use Utilities\Site;
use Views\Renderer;

class Perfil extends PrivateController
{
    private array $viewData = [];

    public function run(): void
    {
        $usercod = strval(
            Security::getUserId()
        );


        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $username = trim(
                $_POST["username"] ?? ""
            );

            $useremail = trim(
                $_POST["useremail"] ?? ""
            );


            if ($username === "") {

                $this->viewData["error"] =
                    "El nombre de usuario es obligatorio.";

            }


            if (
                !isset($this->viewData["error"])
                &&
                !filter_var(
                    $useremail,
                    FILTER_VALIDATE_EMAIL
                )
            ) {

                $this->viewData["error"] =
                    "El correo no es válido.";

            }


            if (
                !isset($this->viewData["error"])
                &&
                PerfilDao::existeCorreo(
                    $useremail,
                    $usercod
                )
            ) {

                $this->viewData["error"] =
                    "El correo ya pertenece a otro usuario.";

            }


            if (!isset($this->viewData["error"])) {


                PerfilDao::updatePerfil(
                    $usercod,
                    $username,
                    $useremail
                );


                Site::redirectToWithMsg(
                    "index.php?page=Perfil_Perfil",
                    "Perfil actualizado correctamente."
                );

                return;
            }

        }

        $perfil = PerfilDao::getPerfil(
            $usercod
        );


        if (!$perfil) {

            Site::redirectToWithMsg(
                "index.php",
                "No se encontró información del usuario."
            );

            return;
        }

        $estadisticas = PerfilDao::getEstadisticas(
            $usercod
        );


        $this->viewData = array_merge(
            $this->viewData,
            $perfil,
            $estadisticas
        );

        Renderer::render(
            "perfil/perfil",
            $this->viewData
        );
    }
}