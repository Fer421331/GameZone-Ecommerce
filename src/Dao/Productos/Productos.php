<?php

namespace Dao\Productos;

use Dao\Table;

class Productos extends Table
{
    public static function getProductos(): array
    {
        $sql = "
            SELECT
                p.producto_id,
                p.producto_sku,
                p.producto_nombre,
                p.producto_costo,
                p.producto_precio,
                p.producto_stock,
                p.producto_activo_web,
                p.producto_estado,
                c.categoria_nombre,
                m.marca_nombre,
                COALESCE(pl.plataforma_nombre, 'Sin plataforma') AS plataforma_nombre
            FROM productos p
            INNER JOIN categorias c
                ON p.categoria_id = c.categoria_id
            INNER JOIN marcas m
                ON p.marca_id = m.marca_id
            LEFT JOIN plataformas pl
                ON p.plataforma_id = pl.plataforma_id
            ORDER BY p.producto_id DESC;
        ";

        return self::obtenerRegistros($sql, []);
    }

    public static function getProductoById(int $productoId): ?array
    {
        $sql = "
            SELECT
                producto_id,
                categoria_id,
                marca_id,
                plataforma_id,
                producto_sku,
                producto_nombre,
                producto_descripcion,
                producto_costo,
                producto_precio,
                producto_stock,
                producto_activo_web,
                producto_estado
            FROM productos
            WHERE producto_id = :producto_id;
        ";

        $producto = self::obtenerUnRegistro(
            $sql,
            [
                "producto_id" => $productoId
            ]
        );

        return $producto ?: null;
    }

    public static function getCategoriasActivas(): array
    {
        $sql = "
            SELECT
                categoria_id,
                categoria_nombre
            FROM categorias
            WHERE categoria_estado = 'ACT'
            ORDER BY categoria_nombre;
        ";

        return self::obtenerRegistros($sql, []);
    }

    public static function getMarcasActivas(): array
    {
        $sql = "
            SELECT
                marca_id,
                marca_nombre
            FROM marcas
            WHERE marca_estado = 'ACT'
            ORDER BY marca_nombre;
        ";

        return self::obtenerRegistros($sql, []);
    }

    public static function getPlataformasActivas(): array
    {
        $sql = "
            SELECT
                plataforma_id,
                plataforma_nombre
            FROM plataformas
            WHERE plataforma_estado = 'ACT'
            ORDER BY plataforma_nombre;
        ";

        return self::obtenerRegistros($sql, []);
    }

    public static function insertProducto(
        int $categoriaId,
        int $marcaId,
        ?int $plataformaId,
        string $sku,
        string $nombre,
        string $descripcion,
        float $costo,
        float $precio,
        int $stock,
        string $activoWeb,
        string $estado
    ): bool {
        $sql = "
            INSERT INTO productos
            (
                categoria_id,
                marca_id,
                plataforma_id,
                producto_sku,
                producto_nombre,
                producto_descripcion,
                producto_costo,
                producto_precio,
                producto_stock,
                producto_activo_web,
                producto_estado,
                producto_fecha_publicacion
            )
            VALUES
            (
                :categoria_id,
                :marca_id,
                :plataforma_id,
                :producto_sku,
                :producto_nombre,
                :producto_descripcion,
                :producto_costo,
                :producto_precio,
                :producto_stock,
                :producto_activo_web,
                :producto_estado,
                CURRENT_TIMESTAMP
            );
        ";

        return self::executeNonQuery(
            $sql,
            [
                "categoria_id" => $categoriaId,
                "marca_id" => $marcaId,
                "plataforma_id" => $plataformaId,
                "producto_sku" => $sku,
                "producto_nombre" => $nombre,
                "producto_descripcion" => $descripcion,
                "producto_costo" => $costo,
                "producto_precio" => $precio,
                "producto_stock" => $stock,
                "producto_activo_web" => $activoWeb,
                "producto_estado" => $estado
            ]
        ) > 0;
    }

    public static function updateProducto(
        int $productoId,
        int $categoriaId,
        int $marcaId,
        ?int $plataformaId,
        string $sku,
        string $nombre,
        string $descripcion,
        float $costo,
        float $precio,
        int $stock,
        string $activoWeb,
        string $estado
    ): bool {
        $sql = "
            UPDATE productos
            SET
                categoria_id = :categoria_id,
                marca_id = :marca_id,
                plataforma_id = :plataforma_id,
                producto_sku = :producto_sku,
                producto_nombre = :producto_nombre,
                producto_descripcion = :producto_descripcion,
                producto_costo = :producto_costo,
                producto_precio = :producto_precio,
                producto_stock = :producto_stock,
                producto_activo_web = :producto_activo_web,
                producto_estado = :producto_estado,
                producto_fecha_actualizacion = CURRENT_TIMESTAMP
            WHERE producto_id = :producto_id;
        ";

        return self::executeNonQuery(
            $sql,
            [
                "producto_id" => $productoId,
                "categoria_id" => $categoriaId,
                "marca_id" => $marcaId,
                "plataforma_id" => $plataformaId,
                "producto_sku" => $sku,
                "producto_nombre" => $nombre,
                "producto_descripcion" => $descripcion,
                "producto_costo" => $costo,
                "producto_precio" => $precio,
                "producto_stock" => $stock,
                "producto_activo_web" => $activoWeb,
                "producto_estado" => $estado
            ]
        ) > 0;
    }

    public static function deleteProducto(int $productoId): bool
    {
        $sql = "
            UPDATE productos
            SET
                producto_estado = 'INA',
                producto_activo_web = 'INA',
                producto_fecha_actualizacion = CURRENT_TIMESTAMP
            WHERE producto_id = :producto_id;
        ";

        return self::executeNonQuery(
            $sql,
            [
                "producto_id" => $productoId
            ]
        ) > 0;
    }

    public static function existeSku(
        string $sku,
        int $productoId = 0
    ): bool {
        $sql = "
            SELECT COUNT(*) AS total
            FROM productos
            WHERE LOWER(producto_sku) = LOWER(:producto_sku)
              AND producto_id <> :producto_id;
        ";

        $resultado = self::obtenerUnRegistro(
            $sql,
            [
                "producto_sku" => $sku,
                "producto_id" => $productoId
            ]
        );

        return intval($resultado["total"] ?? 0) > 0;
    }

    public static function categoriaExiste(int $categoriaId): bool
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM categorias
            WHERE categoria_id = :categoria_id
              AND categoria_estado = 'ACT';
        ";

        $resultado = self::obtenerUnRegistro(
            $sql,
            [
                "categoria_id" => $categoriaId
            ]
        );

        return intval($resultado["total"] ?? 0) > 0;
    }

    public static function marcaExiste(int $marcaId): bool
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM marcas
            WHERE marca_id = :marca_id
              AND marca_estado = 'ACT';
        ";

        $resultado = self::obtenerUnRegistro(
            $sql,
            [
                "marca_id" => $marcaId
            ]
        );

        return intval($resultado["total"] ?? 0) > 0;
    }

    public static function plataformaExiste(int $plataformaId): bool
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM plataformas
            WHERE plataforma_id = :plataforma_id
              AND plataforma_estado = 'ACT';
        ";

        $resultado = self::obtenerUnRegistro(
            $sql,
            [
                "plataforma_id" => $plataformaId
            ]
        );

        return intval($resultado["total"] ?? 0) > 0;
    }

    public static function getProductosPublicados(
        string $buscar = "",
        int $categoria = 0,
        string $orden = "recientes"
    ): array {

        $params = [];

        $sql = "
    SELECT
        p.producto_id,
        p.producto_nombre,
        p.producto_descripcion,
        p.producto_precio,

        (
            p.producto_stock -
            COALESCE(
                (
                    SELECT SUM(r.cantidad_reservada)
                    FROM reservas_stock r
                    WHERE r.producto_id = p.producto_id
                      AND r.reserva_estado = 'ACT'
                      AND r.reserva_fecha_expiracion > NOW()
                ),
                0
            )
        ) AS producto_stock,

        c.categoria_nombre,
        c.categoria_id,

        m.marca_nombre,

        COALESCE(
            pl.plataforma_nombre,
            'Sin plataforma'
        ) AS plataforma_nombre,

        COALESCE(
            img.imagen_ruta,
            'public/img/no-image.png'
        ) AS imagen_ruta
    ";

        if (\Utilities\Security::isLogged()) {

            $sql .= ",
            f.favorito_id
        ";

            $params["usercod"] = \Utilities\Security::getUserId();
        }

        $sql .= "

    FROM productos p
    ";

        if (\Utilities\Security::isLogged()) {

            $sql .= "

        LEFT JOIN favoritos f
            ON p.producto_id = f.producto_id
            AND f.usercod = :usercod

        ";
        }

        $sql .= "

    INNER JOIN categorias c
        ON p.categoria_id = c.categoria_id

    INNER JOIN marcas m
        ON p.marca_id = m.marca_id

    LEFT JOIN plataformas pl
        ON p.plataforma_id = pl.plataforma_id

    LEFT JOIN producto_imagenes img
        ON img.imagen_id = (

            SELECT imagen_id

            FROM producto_imagenes

            WHERE producto_id = p.producto_id
              AND imagen_estado = 'ACT'

            ORDER BY
                imagen_principal DESC,
                imagen_orden ASC

            LIMIT 1
        )

    WHERE
        p.producto_estado = 'ACT'
    AND
        p.producto_activo_web = 'ACT'
    ";

        if ($buscar != "") {

            $sql .= "
        AND p.producto_nombre LIKE :buscar
        ";

            $params["buscar"] = "%{$buscar}%";
        }

        if ($categoria > 0) {

            $sql .= "
        AND p.categoria_id = :categoria
        ";

            $params["categoria"] = $categoria;
        }

        switch ($orden) {

            case "nombre_asc":

                $sql .= "
            ORDER BY
                p.producto_nombre ASC
            ";

                break;

            case "nombre_desc":

                $sql .= "
            ORDER BY
                p.producto_nombre DESC
            ";

                break;

            case "precio_asc":

                $sql .= "
            ORDER BY
                p.producto_precio ASC
            ";

                break;

            case "precio_desc":

                $sql .= "
            ORDER BY
                p.producto_precio DESC
            ";

                break;

            case "favoritos":

                if (\Utilities\Security::isLogged()) {

                    $sql .= "
                AND f.favorito_id IS NOT NULL

                ORDER BY
                    p.producto_nombre ASC
                ";
                } else {

                    $sql .= "
                ORDER BY
                    p.producto_nombre ASC
                ";
                }

                break;

            default:

                $sql .= "
            ORDER BY
                p.producto_fecha_publicacion DESC,
                p.producto_nombre
            ";

                break;
        }

        return self::obtenerRegistros(
            $sql,
            $params
        );
    }

    public static function getProductoCatalogoById(
        int $productoId
    ): ?array {

        $sql = "
    SELECT
        p.producto_id,
        p.producto_nombre,
        p.producto_descripcion,
        p.producto_precio,

        (
            p.producto_stock -
            COALESCE(
                (
                    SELECT SUM(r.cantidad_reservada)
                    FROM reservas_stock r
                    WHERE r.producto_id = p.producto_id
                      AND r.reserva_estado = 'ACT'
                      AND r.reserva_fecha_expiracion > NOW()
                ),
                0
            )
        ) AS producto_stock,

        c.categoria_nombre,

        m.marca_nombre,

        COALESCE(
            pl.plataforma_nombre,
            'Sin plataforma'
        ) AS plataforma_nombre,

        COALESCE(
            img.imagen_ruta,
            'public/img/no-image.png'
        ) AS imagen_ruta

    FROM productos p

    INNER JOIN categorias c
        ON p.categoria_id = c.categoria_id

    INNER JOIN marcas m
        ON p.marca_id = m.marca_id

    LEFT JOIN plataformas pl
        ON p.plataforma_id = pl.plataforma_id

    LEFT JOIN producto_imagenes img
        ON img.imagen_id = (
            SELECT imagen_id
            FROM producto_imagenes
            WHERE producto_id = p.producto_id
              AND imagen_estado = 'ACT'
            ORDER BY
                imagen_principal DESC,
                imagen_orden ASC
            LIMIT 1
        )

    WHERE
        p.producto_id = :producto_id
    AND
        p.producto_estado = 'ACT'
    AND
        p.producto_activo_web = 'ACT';
    ";

        $producto = self::obtenerUnRegistro(
            $sql,
            [
                "producto_id" => $productoId
            ]
        );

        return $producto ?: null;
    }

    public static function getStockDisponible(
        int $productoId
    ): int {

        $producto = self::getProductoById($productoId);

        if (!$producto) {
            return 0;
        }

        $sql = "
    SELECT
        COALESCE(
            SUM(cantidad_reservada),
            0
        ) AS reservado

    FROM reservas_stock

    WHERE producto_id = :producto_id
      AND reserva_estado = 'ACT'
      AND reserva_fecha_expiracion > NOW();
    ";

        $reservas = self::obtenerUnRegistro(
            $sql,
            [
                "producto_id" => $productoId
            ]
        );

        return intval($producto["producto_stock"])
            - intval($reservas["reservado"] ?? 0);
    }

    public static function descontarStock(
        int $productoId,
        int $cantidad
    ): bool {

        $sql = "
    UPDATE productos
    SET
        producto_stock = producto_stock - :cantidad,
        producto_fecha_actualizacion = CURRENT_TIMESTAMP

    WHERE producto_id = :producto_id
      AND producto_stock >= :cantidad;
    ";

        return self::executeNonQuery(
            $sql,
            [
                "producto_id" => $productoId,
                "cantidad" => $cantidad
            ]
        ) > 0;
    }
}
