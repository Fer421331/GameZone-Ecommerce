<?php

namespace Controllers\Marcas;

use Controllers\PrivateController;
use Dao\Marcas\Marcas as MarcasDao;
use Utilities\Site;
use Utilities\Bitacora;
use Views\Renderer;


class Marca extends PrivateController
{

    private array $viewData=[];

    private string $mode="DSP";


    private array $marca=[

        "marca_id"=>"",
        "marca_nombre"=>"",
        "marca_descripcion"=>"",
        "marca_estado"=>"ACT"

    ];



    public function run():void
    {

        try{

            $this->getData();


            if($this->isPostBack()){

                $this->validateCsrfToken();


                if($this->validateData()){

                    $this->handlePostAction();

                }

            }


            $this->setViewData();


            Renderer::render(
                "marcas/marca",
                $this->viewData
            );


        }catch(\Exception $ex){


            Site::redirectToWithMsg(
                "index.php?page=Marcas_Marcas",
                $ex->getMessage()
            );

        }

    }




    private function getData():void
    {


        $this->mode =
            strtoupper(
                $_GET["mode"] ?? "DSP"
            );


        if($this->mode!=="INS"){


            $id =
                intval(
                    $_GET["marca_id"] ?? 0
                );


            if($id<1){

                throw new \Exception(
                    "Marca inválida."
                );

            }


            $marca =
                MarcasDao::getMarcaById($id);



            if(!$marca){

                throw new \Exception(
                    "No existe la marca."
                );

            }


            $this->marca =
                array_merge(
                    $this->marca,
                    $marca
                );

        }

    }





    private function validateData():bool
    {

        $this->marca["marca_id"] =
            $_POST["marca_id"] ?? "";


        $this->marca["marca_nombre"] =
            trim(
                $_POST["marca_nombre"] ?? ""
            );


        $this->marca["marca_descripcion"] =
            trim(
                $_POST["marca_descripcion"] ?? ""
            );


        $this->marca["marca_estado"] =
            $_POST["marca_estado"] ?? "ACT";



        if($this->marca["marca_nombre"]===""){

            $this->viewData["error"]=
                "El nombre es obligatorio.";

            return false;

        }



        if(
            MarcasDao::existeNombre(
                $this->marca["marca_nombre"],
                intval($this->marca["marca_id"])
            )
        ){

            $this->viewData["error"]=
                "La marca ya existe.";

            return false;

        }



        return true;

    }





    private function handlePostAction():void
    {

        if($this->mode==="INS"){


            $ok =
            MarcasDao::insertMarca(
                $this->marca["marca_nombre"],
                $this->marca["marca_descripcion"],
                $this->marca["marca_estado"]
            );


            $mensaje=
                "Marca creada correctamente.";


        }else{


            $ok =
            MarcasDao::updateMarca(
                intval($this->marca["marca_id"]),
                $this->marca["marca_nombre"],
                $this->marca["marca_descripcion"],
                $this->marca["marca_estado"]
            );


            $mensaje=
                "Marca actualizada correctamente.";

        }



        if(!$ok){

            throw new \Exception(
                "No fue posible guardar."
            );

        }


        Bitacora::registrar(
            "Marcas",
            "Cambio de marca",
            $this->marca["marca_nombre"],
            "LOG"
        );



        Site::redirectToWithMsg(
            "index.php?page=Marcas_Marcas",
            $mensaje
        );

    }





    private function setViewData():void
    {


        $this->viewData =
            $this->marca;


        $this->viewData["mode"]=
            $this->mode;


        $this->viewData["csrf"]=
            $this->getCsrfToken();



        $this->viewData["estado_act"]=
            $this->marca["marca_estado"]==="ACT"
            ?"selected":"";


        $this->viewData["estado_ina"]=
            $this->marca["marca_estado"]==="INA"
            ?"selected":"";


    }





    private function getCsrfToken():string
    {

        if(empty($_SESSION["marca_csrf"])){

            $_SESSION["marca_csrf"]=
                bin2hex(
                    random_bytes(32)
                );

        }


        return $_SESSION["marca_csrf"];

    }





    private function validateCsrfToken():void
    {

        if(
            ($_POST["csrf"]??"")
            !==
            ($_SESSION["marca_csrf"]??"")
        ){

            throw new \Exception(
                "Token inválido."
            );

        }

    }

}