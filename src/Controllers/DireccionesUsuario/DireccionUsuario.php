<?php

namespace Controllers\DireccionesUsuario;


use Controllers\PrivateController;

use Dao\DireccionesUsuario\DireccionesUsuario as DireccionesDao;

use Utilities\Security;
use Utilities\Site;
use Utilities\Validators;

use Views\Renderer;



class DireccionUsuario extends PrivateController
{

    private array $viewData = [];

    private string $mode = "DSP";

    private array $modeDescriptions = [

        "DSP" => "Detalle Dirección",
        "INS" => "Nueva Dirección",
        "UPD" => "Editar Dirección",
        "DEL" => "Eliminar Dirección"

    ];

    private array $direccion = [

        "direccion_id" => "",
        "direccion_alias" => "",
        "direccion_receptor" => "",
        "direccion_telefono" => "",
        "direccion_departamento" => "",
        "direccion_ciudad" => "",
        "id_ruta" => "",
        "direccion_detalle" => "",
        "direccion_referencia" => "",
        "direccion_predeterminada" => 0,
        "direccion_estado" => "ACT"

    ];



    private string $readonly = "";

    private bool $showCommitBtn = true;


    public function run(): void
    {
        try {


            $usercod =
                strval(
                    Security::getUserId()
                );



            $this->getData(
                $usercod
            );



            if (
                $this->isPostBack()
            ) {


                if (
                    $this->mode == "DEL"
                ) {

                    $this->handleDelete(
                        $usercod
                    );
                } else {


                    if (
                        $this->validateData()
                    ) {

                        $this->handlePostAction(
                            $usercod
                        );
                    }
                }
            }


            $this->setViewData();



            Renderer::render(
                "direccionesusuario/direccionusuario",
                $this->viewData
            );
        } catch (\Exception $ex) {


            Site::redirectToWithMsg(

                "index.php?page=DireccionesUsuario_DireccionesUsuarios",

                $ex->getMessage()

            );
        }
    }

    private function getData(
        string $usercod
    ): void {


        $this->mode =
            $_GET["mode"] ?? "NOF";



        if (
            !isset(
                $this->modeDescriptions[$this->mode]
            )
        ) {

            throw new \Exception(
                "Modo inválido"
            );
        }




        $this->readonly =
            $this->mode == "DEL"
            ? "readonly"
            : "";



        $this->showCommitBtn =
            $this->mode != "DSP";





        if (
            $this->mode != "INS"
        ) {


            $direccion_id =
                intval(
                    $_GET["direccion_id"] ?? 0
                );



            $direccion =
                DireccionesDao::getDireccionById(

                    $direccion_id,

                    $usercod

                );



            if (!$direccion) {

                throw new \Exception(
                    "Dirección no encontrada"
                );
            }


            $this->direccion =
                $direccion;
        }


        $this->viewData["rutas"] =
            DireccionesDao::getRutasActivas();
    }

    private function validateData(): bool
    {

        $errors = [];

        $campos = [


            "direccion_receptor",

            "direccion_telefono",

            "direccion_departamento",

            "direccion_ciudad",

            "id_ruta",

            "direccion_detalle"


        ];

        foreach ($campos as $campo) {


            $this->direccion[$campo] =

                trim(

                    $_POST[$campo] ?? ""

                );



            if (
                Validators::IsEmpty(
                    $this->direccion[$campo]
                )
            ) {

                $errors[$campo . "_error"] =
                    "Campo requerido";
            }
        }


        $this->direccion["direccion_alias"] =

            trim(
                $_POST["direccion_alias"] ?? ""
            );



        $this->direccion["direccion_referencia"] =

            trim(
                $_POST["direccion_referencia"] ?? ""
            );



        $this->direccion["direccion_predeterminada"] =

            isset(
                $_POST["direccion_predeterminada"]
            )

            ? 1

            : 0;






        if (
            count($errors) > 0
        ) {


            foreach ($errors as $key => $value) {

                $this->direccion[$key] = $value;
            }


            return false;
        }



        return true;
    }

    private function handlePostAction(
        string $usercod
    ): void {



        switch ($this->mode) {



            case "INS":


                if (
                    DireccionesDao::insertDireccion(

                        $usercod,

                        $this->direccion

                    )
                ) {


                    Site::redirectToWithMsg(

                        "index.php?page=DireccionesUsuario_DireccionesUsuarios",

                        "Dirección agregada correctamente"

                    );
                }


                break;






            case "UPD":


                if (
                    DireccionesDao::updateDireccion(

                        $usercod,

                        $this->direccion

                    )
                ) {


                    Site::redirectToWithMsg(

                        "index.php?page=DireccionesUsuario_DireccionesUsuarios",

                        "Dirección actualizada correctamente"

                    );
                }


                break;
        }
    }









    private function handleDelete(
        string $usercod
    ): void {



        if (
            DireccionesDao::deleteDireccion(

                intval(
                    $this->direccion["direccion_id"]
                ),

                $usercod

            )
        ) {


            Site::redirectToWithMsg(

                "index.php?page=DireccionesUsuario_DireccionesUsuarios",

                "Dirección eliminada correctamente"

            );
        }
    }


    private function setViewData(): void
    {


        $this->direccion["direccion_predeterminada_checked"] =
            (
                intval(
                    $this->direccion["direccion_predeterminada"]
                ) === 1
            )
            ? "checked"
            : "";



        if (
            isset($this->viewData["rutas"])
        ) {

            foreach (
                $this->viewData["rutas"] as &$ruta
            ) {

                $ruta["selected"] =
                    (
                        intval($ruta["id_ruta"]) ===
                        intval($this->direccion["id_ruta"])
                    )
                    ? "selected"
                    : "";
            }


            unset($ruta);
        }




        $this->viewData = array_merge(

            $this->viewData,

            [

                "mode" => $this->mode,

                "FormTitle" => sprintf(

                    $this->modeDescriptions[$this->mode],

                    $this->direccion["direccion_id"]

                ),

                "readonly" => $this->readonly,

                "showCommitBtn" => $this->showCommitBtn

            ],

            $this->direccion

        );

        array_merge(

            [

                "mode" => $this->mode,


                "FormTitle" =>

                sprintf(

                    $this->modeDescriptions[$this->mode],

                    $this->direccion["direccion_id"]

                ),


                "readonly" => $this->readonly,


                "showCommitBtn" => $this->showCommitBtn


            ],


            $this->direccion

        );
    }
}
