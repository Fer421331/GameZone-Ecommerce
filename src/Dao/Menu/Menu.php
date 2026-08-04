<?php

namespace Dao\Menu;

use Dao\Table;

class Menu extends Table
{
    public static function getMenuCompleto(): array
    {
        return [
            [
                "titulo" => "Dashboard",
                "descripcion" => "Ver estadísticas del sistema",
                "url" => "index.php?page=Dashboard_Dashboard"
            ],
            [
                "titulo" => "Categorías",
                "descripcion" => "Administrar categorías",
                "url" => "index.php?page=Categorias_Categorias"
            ],
            [
                "titulo" => "Productos",
                "descripcion" => "Administrar productos",
                "url" => "index.php?page=Productos_Productos"
            ],
            [
                "titulo" => "Usuarios",
                "descripcion" => "Administrar usuarios",
                "url" => "index.php?page=Security_RolesUsuarios"
            ],
            [
                "titulo" => "Roles",
                "descripcion" => "Administrar roles",
                "url" => "index.php?page=Security_Roles"
            ],
            [
                "titulo" => "Funciones",
                "descripcion" => "Administrar funciones",
                "url" => "index.php?page=Security_Funciones"
            ],
            [
                "titulo" => "Funciones por Roles",
                "descripcion" => "Administrar funciones por roles",
                "url" => "index.php?page=Security_FuncionesRoles"
            ],
            [
                "titulo" => "Bitácora",
                "descripcion" => "Ver bitácora",
                "url" => "index.php?page=Security_Bitacora"
            ],
            [
                "titulo" => "Historial",
                "descripcion" => "Consultar historial",
                "url" => "index.php?page=Historial_Historial"
            ],
            [
                "titulo" => "Perfil",
                "descripcion" => "Mi perfil",
                "url" => "index.php?page=Perfil_Perfil"
            ],
        ];
    }

    public static function getMenuPorRoles($roles): array
    {
        $menuCompleto = self::getMenuCompleto();
        $esAdminOAuditor = false;
        $esVentas = false;
        $esInvitado = true;

        foreach ($roles as $rol) {
            $codigoRol = $rol["rolescod"];
            
            if ($codigoRol == '1' || $codigoRol == '4') {
                $esAdminOAuditor = true;
                $esInvitado = false;
            }
            
            if ($codigoRol == '2') {
                $esVentas = true;
                $esInvitado = false;
            }
        }

        if ($esInvitado) {
            return [];
        }

        if ($esAdminOAuditor) {
            return $menuCompleto;
        }

        if ($esVentas) {
            $urlsVentas = [
                "index.php?page=Dashboard_Dashboard",
                "index.php?page=Categorias_Categorias",
                "index.php?page=Productos_Productos",
                "index.php?page=Carrito_Carrito",
                "index.php?page=Checkout_Checkout",
                "index.php?page=Historial_Historial",
                "index.php?page=Perfil_Perfil"
            ];

            return array_values(array_filter($menuCompleto, function ($item) use ($urlsVentas) {
                return in_array($item["url"], $urlsVentas);
            }));
        }

        return [];
    }
}