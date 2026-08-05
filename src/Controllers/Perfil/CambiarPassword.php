<?php

namespace Controllers\Perfil;

use Controllers\PrivateController;
use Dao\Security\Security as SecurityDao;
use Utilities\Security;
use Utilities\Bitacora;

class CambiarPassword extends PrivateController
{

    public function run(): void
    {
        header("Content-Type: application/json; charset=UTF-8");

        try {

            $usercod = strval(Security::getUserId());

            $actual = trim($_POST["passwordActual"] ?? "");
            $nueva = trim($_POST["passwordNueva"] ?? "");
            $confirmar = trim($_POST["passwordConfirmar"] ?? "");

            if ($actual === "") {
                echo json_encode([
                    "success" => false,
                    "message" => "Ingrese la contraseña actual."
                ]);
                return;
            }

            $usuario = SecurityDao::getUsuarioById($usercod);

            if (!$usuario) {
                echo json_encode([
                    "success" => false,
                    "message" => "Usuario no encontrado."
                ]);
                return;
            }

            if (!SecurityDao::verifyPassword($actual, $usuario["userpswd"])) {
                echo json_encode([
                    "success" => false,
                    "message" => "La contraseña actual es incorrecta."
                ]);
                return;
            }

            if ($nueva === "") {
                echo json_encode([
                    "success" => false,
                    "message" => "Ingrese la nueva contraseña."
                ]);
                return;
            }

            if ($nueva !== $confirmar) {
                echo json_encode([
                    "success" => false,
                    "message" => "Las contraseñas no coinciden."
                ]);
                return;
            }

            if (SecurityDao::verifyPassword($nueva, $usuario["userpswd"])) {
                echo json_encode([
                    "success" => false,
                    "message" => "La nueva contraseña no puede ser igual."
                ]);
                return;
            }

            if (!\Utilities\Validators::IsValidPassword($nueva)) {
                echo json_encode([
                    "success" => false,
                    "message" => "La contraseña debe tener mínimo 8 caracteres, mayúscula, número y símbolo."
                ]);
                return;
            }

            if (!SecurityDao::changePassword($usercod, $nueva)) {
                echo json_encode([
                    "success" => false,
                    "message" => "No se pudo actualizar."
                ]);
                return;
            }

            Bitacora::registrar(
                "Perfil",
                "Cambio contraseña",
                "Usuario ID: " . $usercod,
                "UPD"
            );

            echo json_encode([
                "success" => true,
                "message" => "Contraseña actualizada correctamente."
            ]);
        } catch (\Exception $e) {

            echo json_encode([
                "success" => false,
                "message" => "Error interno."
            ]);
        }
    }
}
